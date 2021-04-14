<?php

namespace App\Http\Controllers;
use Mail;
use Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;



class InviteController extends Controller
{
    public function invite(Request $request)
    {
        $email = $request->email;


        $code = rand(1000,9999);
        // $code=base64_encode($code);
        $link = "http://localhost:8000/api/invitation?code=$code";
        $data = array('email' => $email, 'link' => $link);

        \Mail::send('template',$data, function($request) use ($email){
            $request->to($email)->subject('Invitation Link');
            });

        // \Mail::send ( 'template', $data, function ($sendemail) use($email) {
        //     $sendemail->from ( 'info@me.com', 'Me Team' );
        //     $sendemail->to ( $email, '' )->subject ( 'Activate your account' );
        // } );
    }

    public function check(Request $request)
    {
        print_r($request->all());
        die;
    }

    public function store(Request $request)
    {
        $data=new User;
        $semail=$request->username;
        $data['email']=$request->username;
        $data['password']=Hash::make($request->password);
        $data['role']='user';



        if($data->save())
        {
            $lastid=$data->id;
            $otpcode = rand(10000,99999);
            $otpcode = "http://localhost:8000/api/verify/".$lastid;
            $dataotp = array('email' =>$semail, 'otplink' => $otpcode);
            \Mail::send('otp',$dataotp, function($request) use ($semail){
                $request->to($semail)->subject('Invitation Link');
                });
            return response()->json(['success'=>1,'result'=>'Added successfully']);
        }
        else
        {
            return response()->json(['success'=>0,'result'=>'Something went wrong']);
        }
    }

    public function verify(Request $request,$id)
    {
        // print_r($id);
        // die;
        $up=User::where('id', $id)
        ->update(['verified' => 1]);

        if($up==true)
        {
            return response()->json(['success'=>1,'result'=>'Verified successfully']);
        }
        else
        {
            return response()->json(['success'=>0,'result'=>'Not verified']);
        }
    }
}
