<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class UserContact extends Model
{
    use HasFactory;

    public static function createUserContact($data){
        return DB::table('user_contacts')
                    ->insert($data);
    }

    public static function getUserContact($user_id){
        return DB::table('user_contacts')
                    ->where('user_id', $user_id)
                    ->first();
    }

    public static function updateUserContact($data)
    {
        return DB::table('user_contacts')
                    ->where('user_id', $data['user_id'])
                    ->update($data);
    }
}
