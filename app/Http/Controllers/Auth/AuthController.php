<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use DB;
use Illuminate\Support\Str;
use App\Models\GlobalModel;


class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $data           =   $request->all();
        $validator = Validator::make($data, [
            'name'      => 'required|max:255',
            'password'  => 'required|max:255|min:6'
        ]);
        //if validator fails
        if ($validator->fails()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $credentials    =   array(
                            'name'      => $data['name'],
                            'password'  => $data['password']
                        );
        // check if user is found in db
        if (! $token = $this->guard()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // get user information
        $user           =   User::getUserUsingUsername($data);
        // update token
        $update_token   =   User::insertAccessToken($token, $user);
        // audit trail
        $data['number'] = $data['name'];
        $data['module_name'] = 'Authentication';
        $data['action'] = 'Login';
        AuditTrail::trailLoginAndLogout($data,$user);
        // get role access and permissions
        $roles          =   UserRole::getUserRole($user->role_id);
        if ($roles) {
            $actions    =   json_decode($roles->actions);
        }else{
            $actions    =   [];
        }
        return $this->respondWithToken($token, $user, $roles, $actions);
    }

    public function register(Request $request)
    {
        $result = DB::transaction( function(&$data) use ($request) {
            $data           =   $request->all();
            $validator      =   Validator::make($data, [
                'name'          => 'required|unique:users|min:4',
                'password'      => 'required|min:6',
                'first_name'    => 'required',
                'last_name'     => 'required',
                'email'         => 'required',
                'contact_number'=> 'required'
            ]);

            if ($validator->fails()) {
                return  [
                            'response'  =>  false,
                            'auth'      =>  []
                        ];
            }

            $create_user        =   [
                                        'name'              => $data['name'],
                                        'email'             => $data['email'],
                                        'password'          => bcrypt($data['password']),
                                        'remember_token'    => Str::random(60),
                                        'first_name'        => $data['first_name'],
                                        'last_name'         => $data['last_name'],
                                        'middle_name'       => $data['middle_name'],
                                        'status'            => 1,
                                        'role_id'           => 1,
                                        'position_id'       => 1,
                                        'registered_ip'     => $request->ip(),
                                        'created_by'        => 0,
                                        'created_at'        => date('Y-m-d')
                                    ];
            $user_id            =   GlobalModel::createData('users', $create_user);

            if ($user_id) {
                $credentials    =   array(
                                        'name'      => $data['name'],
                                        'password'  => $data['password']
                                    );

                // check if user is found in db
                if (!$token = $this->guard()->attempt($credentials)) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
                // get user information
                $user           =   User::getUserUsingName($data);
                // update token
                $update_token   =   User::insertAccessToken($token, $user);
                
                $array          =   $this->respondWithTokenResetPassword($token, $user);
                return          [
                                    'response'  =>  true,
                                    'auth'      =>  $array
                                ];
            }else{
                return  [
                            'response'  =>  false,
                            'auth'      =>  []
                        ];
            }
        });
        return response()->json($result);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        if ($this->guard()->user()->access_token) {
            
            return response()->json($this->guard()->user());
        }
        $this->guard()->logout();
        return response()->json(false);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $user                   =   $this->guard()->user();
        $delete_access_token    =   User::updateAccessTokenToNull($user->id);
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user, $roles, $actions)
    {        
        return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => $this->guard()->factory()->getTTL() * 7200,
                'status'     => $user->status,
                'roles'      => $roles,
                'actions'    => $actions
            ]);
    }

    public function reset(Request $request)
    {
        $result = DB::transaction( function(&$data) use ($request) {
            $data           =   $request->all();
            $validator = Validator::make($data, [
                'token' => 'required',
                'name' => 'required',
                'password' => 'required|confirmed|min:6',
            ]);

            if ($validator->fails()) {
                return  [
                            'response'  =>  false,
                            'auth'      =>  []
                        ];
            }

            $update                 =   User::updatePassword($data);
            if ($update) {
                $credentials    =   array(
                            'name'      => $data['name'],
                            'password'  => $data['password']
                        );
                // check if user is found in db
                if (! $token = $this->guard()->attempt($credentials)) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
                // get user information
                $user           =   User::getUserUsingUsername($data);
                // update token
                $update_token   =   User::insertAccessToken($token, $user);
                // get role access and permissions
                $roles          =   UserRole::getUserRole($user->role_id);
                if ($roles) {
                    $actions    =   json_decode($roles->actions);
                }else{
                    $actions    =   [];
                }
                
                $array          =   $this->respondWithTokenResetPassword($token, $user, $roles, $actions);
                return          [
                                    'response'  =>  true,
                                    'auth'      =>  $array
                                ];
            }else{
                return  [
                            'response'  =>  false,
                            'auth'      =>  []
                        ];
            }
        });
        return response()->json($result);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithTokenResetPassword($token, $user)
    {        
        return  $array  =   [
                                'access_token'  =>  $token,
                                'token_type'    =>  'bearer',
                                'expires_in'    =>  $this->guard()->factory()->getTTL() * 7200,
                                'status'        =>  $user->status
                            ];
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }
}