<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserLocation;
use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\User;

class UserController extends Controller
{

    /**
     * Create a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getUserLocation(Request $request) {
        $data       =   $request->all();
        $result     =   UserLocation::getUserLocation($data['id']);
        return response()->json($result);
    }

    public function getUserContacts(Request $request) {
        $data       =   $request->all();
        $result     =   UserContact::getUserContact($data['id']);
        return response()->json($result);
    }

    public function updateUser(Request $request) {
        $result = DB::transaction( function(&$data) use ($request) {
            $data       =   $request->all();
            $update     =   [
                                'id'            =>  $data['id'],
                                'first_name'    =>  $data['first_name'],
                                'middle_name'   =>  $data['middle_name'],
                                'last_name'     =>  $data['last_name'],
                                'email'         =>  $data['email'],
                                'birth_date'    =>  date('Y-m-d', strtotime(json_decode($data['birth_date'])))
                            ];

            User::updateUser($update);
            return 'User details successfully updated!';
        });
        return response()->json($result);
    }

    public function updateUserLocation(Request $request) {
        $result = DB::transaction( function(&$data) use ($request) {
            $data       =   $request->all();
            $update     =   [
                                'user_id'       =>  $data['id'],
                                'block'         =>  $data['block'],
                                'lot'           =>  $data['lot']
                            ];

            UserLocation::updateUserLocation($update);
            return 'User location successfully updated!';
        });
        return response()->json($result);
    }

    public function updateUserContacts(Request $request) {
        $result = DB::transaction( function(&$data) use ($request) {
            $data       =   $request->all();
            $update     =   [
                                'user_id'           =>  $data['id'],
                                'contact_number'    =>  $data['contact_number']
                            ];

            UserContact::updateUserContact($update);
            return 'User contact successfully updated!';
        });
        return response()->json($result);
    }
    
    public function getHomeOwners(Request $request)
    {
        $data       =   $request->all();
        $params     =   [
                            'offset'        =>  ($data['page'] - 1) * $data['perPage'],
                            'limit'         =>  $data['perPage'],
                            'sort_field'    =>  $data['sort'][0]['field'],
                            'sort'          =>  $data['sort'][0]['type']
                        ];
        $homeOwners     =   User::getUsers($params);
        $totalRecords   =   User::getTotalRecords();
        $result         =   [
                                'rows'          =>  $homeOwners,
                                'totalRecords'  =>  $totalRecords
                            ];
        return response()->json($result);
    }
    
}