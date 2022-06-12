<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guideline;
use Image;
use File;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Auth;

class GuidelineController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getGuidelines(Request $request) {
        $data       =   $request->all();
        $params     =   [
                            'offset'        =>  ($data['page'] - 1) * $data['perPage'],
                            'limit'         =>  $data['perPage'],
                            'sort_field'    =>  $data['sort'][0]['field'],
                            'sort'          =>  $data['sort'][0]['type']
                        ];
        $guidelines     =   Guideline ::getGuidelines($params);
        $totalRecords   =   Guideline ::getTotalRecords();
        $result         =   [
                                'rows'          =>  $guidelines,
                                'totalRecords'  =>  $totalRecords
                            ];
        return response()->json($result);
    }

    // public function submit(Request $request) {
    //     $result = DB::transaction( function(&$data) use ($request) {
    //     	$data 		=	$request->all();

    //         $destination_path 	= 	public_path().'/attachments/forms/telco_requests/signatures/';
    //         if (!File::exists($destination_path)) {
    //             File::makeDirectory($destination_path, 0777, true, true);
    //         }

    //         Image::make(file_get_contents($data['file']))->save($destination_path . str_replace(' ', '_', strtolower($data['full_name'])) . '.png');

    //         TelcoRequest::create($data);

    //         return true;
    //     });       
    //     return response()->json($result);
    // }

    public function imageAdded(Request $request){
        $data    =   $request->all();
    }

    public function create(Request $request){
        $data    =   $request->all();
        dd($data);
    }
}