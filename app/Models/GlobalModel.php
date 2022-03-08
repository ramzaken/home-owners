<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class GlobalModel extends Model
{
    public static function fetchData($table='', $order='')
    {
        return DB::table($table)
                ->orderBy('id', $order)
                ->get()->toArray();
    }

    public static function fetchActiveData($table='', $order='')
    {
        return DB::table($table)
                ->where('status', 1)
                ->orWhere('status', 99)
                ->orderBy('id', $order)
                ->get()->toArray();
    }

    public static function fetchActiveDataWithLimit($table='', $order='', $limit='')
    {
        return DB::table($table)
            ->where('status', 1)
            ->orWhere('status', 99)
            ->orderBy('id', $order)
            ->limit($limit)
            ->get()->toArray();
    }

    public static function fetchSingleData($table='', $id='')
    {
        return DB::table($table)
                ->where('id', $id)
                ->first();
    }

    public static function fetchDataByID($table='', $id='')
    {
        return DB::table($table)
                ->where('id', $id)
                ->get()->toArray();
    }

    public static function createData($table='', $data='')
    {   
                DB::table($table)
                ->insert($data);
        return DB::getPdo()->lastInsertId();
    }

    public static function updateUserById($table='', $data='', $array)
    {
                DB::table($table)
                ->where('id', $data)
                ->update($array);
        return  DB::table($table)
                ->where('id', $data)
                ->first();
    }

    public static function updateData($table='', $data='')
    {
                DB::table($table)
                ->where('id', $data['id'])
                ->update($data);
        return  DB::table($table)
                ->where('id', $data['id'])
                ->first();
    }

    public static function updateUserByUserId($table='', $data='', $array='')
    {
                DB::table($table)
                ->where('user_id', $data)
                ->update($array);
        return  DB::table($table)
                ->where('user_id', $data)
                ->first();
    }

    public static function deleteData($table='', $id='')
    {
        return DB::table($table)
                ->where('id', $id)
                ->delete();
    }

    public static function fetchSingleDataByName($table, $search)
    {
        return DB::table($table)
                ->where('name', 'LIKE', "%{$search}%")
                ->first();
    }

    public static function fetchDataByName($table, $search)
    {
        return DB::table($table)
                ->where('name', 'LIKE', "%{$search}%")
                ->get()->toArray();
    }

    public static function fetchUserSingleData($table='', $id='')
    {
        return DB::table($table)
                ->where('user_id', $id)
                ->first();
    }

    public static function checkNameIfExists($data)
    {
        return DB::table($data['table'])
                ->where('name', $data['name'])
                ->count();
    }

    public static function checkNameIfExistsEdit($data)
    {
        return DB::table($data['table'])
                ->where('name', $data['name'])
                ->where('id', '!=', $data['id'])
                ->count();
    }

}
