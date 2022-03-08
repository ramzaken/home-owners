<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\TelcoRequest;
use Image;
use File;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Auth;

class TelcoRequestController extends Controller
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

    public function getTelcoRequests(Request $request) {
        $result     =   TelcoRequest::getTelcoRequests();
        return response()->json($result);
    }

    public function submit(Request $request) {
        $result = DB::transaction( function(&$data) use ($request) {
        	$data 		=	$request->all();

            $destination_path 	= 	public_path().'/attachments/forms/telco_requests/signatures/';
            if (!File::exists($destination_path)) {
                File::makeDirectory($destination_path, 0777, true, true);
            }

            Image::make(file_get_contents($data['file']))->save($destination_path . str_replace(' ', '_', strtolower($data['full_name'])) . '.png');

            TelcoRequest::create($data);

            return true;
        });       
        return response()->json($result);
    }

}