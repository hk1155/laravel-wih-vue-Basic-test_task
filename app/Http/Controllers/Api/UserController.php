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
        // $credentials = $request->only('email', 'password');
        $email=$request->email;
        $password=$request->password;
        if (Auth::attempt(['email' => $email, 'password' => $password, 'role' => 'user'])) {

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
        // $id = Auth::id(); // profile updatation by login user only.
        $id=3;
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:20|min:4',
        ]);

        if ($validator->fails()) {
            return response()->json(['result' => '0', "message" => "Validation error", 'errors' => $validator->errors()->messages()]);
        }

        $image = $request->file('avtar');
        $filename= $image->getClientOriginalName();
        $image_resize = Image::make($image->getRealPath());
        $image_resize->resize(256, 256);
        $image_resize->save(public_path('uploads/' .$filename));
        $imagepath = '/uploads/'.$filename;


        $name=$request->name;
        $username=$request->username;

        $data=User::where('id', $id)
       ->update([
           'name' => $name,
           'username'=>$username,
            'avtar'=>$imagepath
        ]);

        if($data==true)
        {
            return response()->json(['result' => '1', "message" => "Profile Update successfully"]);
        }
        else
        {
            return response()->json(['result' => '0', "message" => "Something went wrong please try again later."]);
        }



    }
}
