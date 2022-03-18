<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class UserLocation extends Model
{
    use HasFactory;

    public static function createUserLocation($data){
        return DB::table('user_locations')
                    ->insert($data);
    }

    public static function getUserLocation($user_id){
        return DB::table('user_locations')
                    ->where('user_id', $user_id)
                    ->first();
    }

    public static function updateUserLocation($data)
    {
        return DB::table('user_locations')
                    ->where('user_id', $data['user_id'])
                    ->update($data);
    }
}
