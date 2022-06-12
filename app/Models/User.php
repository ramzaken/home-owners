<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use Illuminate\Support\Str;
use Auth;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
        'first_name',
        'last_name',
        'middle_name',
        'name_extension',
        'status',
        'role_id',
        'position_id',
        'registered_ip',
        'created_by',
        'created_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($password)
    {
        if ( !empty($password) ) {
            $this->attributes['password'] = bcrypt($password);
        }
    }

    public static function getUserUsingName($data)
    {
        return DB::table('users')
                    ->where('name', $data['name'])
                    ->first();
    }   

    public static function insertAccessToken($access_token, $user)
    {
        return DB::table('users')
                    ->where('name', $user->name)
                    ->update([
                        'access_token' => $access_token
                    ]);
    }

    public static function updateUser($data)
    {
        return DB::table('users')
                    ->where('id', $data['id'])
                    ->update($data);
    }

    public static function updateAccessTokenToNull($user_id)
    {
        return DB::table('users')
                    ->where('id', $user_id)
                    ->update([
                        'access_token'  =>  null
                    ]);
    }

    public static function getUsers($data)
    {
        $table  =   DB::table('users as u');
        $table  =   $table->select(
                                'u.id',
                                DB::raw('CONCAT(u.last_name,", ",u.first_name," ",u.middle_name) as name'),
                                'u.email',
                                'ul.block',
                                'ul.lot',
                                'uc.contact_number'
                            );
        $table  =   $table->leftJoin('user_locations as ul', 'u.id', '=', 'ul.user_id');
        $table  =   $table->leftJoin('user_contacts as uc', 'u.id', '=', 'uc.user_id');
        if ($data['sort_field'] == 'name' || $data['sort_field'] == 'email') {
            $table  =   $table->orderBy('u.'.$data['sort_field'], $data['sort']);
        }elseif ($data['sort_field'] == 'contact_number') {
            $table  =   $table->orderBy('uc.'.$data['sort_field'], $data['sort']);
        }else{
            $table  =   $table->orderBy('ul.'.$data['sort_field'], $data['sort']);
        }
        $table  =   $table->offset($data['offset']);
        $table  =   $table->limit($data['limit']);
        $table  =   $table->get();
        return $table;
    }

    public static function getTotalRecords(){
        return DB::table('users')
                    ->count();
    }

}
