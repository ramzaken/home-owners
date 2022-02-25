<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class TelcoRequest extends Model
{
    use HasFactory;

    public static function getTelcoRequests(){
        return DB::table('telco_requests')
                    ->get();
    }

    public static function create($data){
        return DB::table('telco_requests')
                ->insert([
                    'full_name' =>  $data['full_name'],
                    'block'     =>  $data['block'],
                    'lot'       =>  $data['lot'],
                    'signature' =>  str_replace(' ', '_', strtolower($data['full_name'])) . '.png'
                ]);
    }
}
