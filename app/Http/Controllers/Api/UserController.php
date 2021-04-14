<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function checklogin(Request $request)
    {
        // print_r($request->all());
        // die;
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            return response()->json(['success'=>1,'message'=>'You are Login successfully']);
            // return redirect()->intended('dashboard');
        }
        else
        {
            return response()->json(['success'=>0,'message'=>'Your credentials incorrect']);
        }
    }

    public function profile(Request $request)
    {
        print_r($request->all());
        die;
    }
}
