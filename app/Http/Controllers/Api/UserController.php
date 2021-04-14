<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    public function checklogin(Request $request)
    {
        // print_r($request->all());
        // die;
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            return response()->json(['success'=>1,'message'=>'You are Login successfully','token'=>$request->bearerToken()]);
            // return redirect()->intended('dashboard');
        }
        else
        {
            return response()->json(['success'=>0,'message'=>'Your credentials incorrect']);
        }
    }

    public function profile(Request $request)
    {
        // print_r($request->all());
        // die;

        // $validated = $request->validate([
        //     'username' => 'required|max:20|min:4',

        // ]);
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:20|min:4',
        ]);

        if ($validator->fails()) {
            return response()->json(['result' => '0', "message" => "Validation error", 'errors' => $validator->errors()->messages()]);
        }

        $image       = $request->file('avtar');
        $filename    = $image->getClientOriginalName();
        $image_resize = Image::make($image->getRealPath());
        $image_resize->resize(256, 256);
        $image_resize->save(public_path('uploads/' .$filename));
        $imagepath = public_path().'/uploads/';

        // $avtar=$request->avtar;
        // $flyername = strtolower(time().$avtar->getClientOriginalName());
        // $flyerpath = public_path().'/uploads/';
        // $avtar = Image::make($avtar->getRealPath());
        // $avtar->resize(256,256);
        // $avtar->move($flyerpath, $flyername);


        print_r($image_resize);
        die;
    }
}
