<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Guideline extends Model
{
    public static function getGuidelines($data)
    {
        return DB::table('guidelines')
                    ->select(
                                'id',
                                'title',
                                'blurb',
                                'content',
                                'status',
                                DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_at')
                            )
                    ->orderBy($data['sort_field'], $data['sort'])
                    ->offset($data['offset'])
                    ->limit($data['limit'])
                    ->get();
    }

    public static function getTotalRecords(){
        return DB::table('guidelines')
                    ->count();
    }
}
