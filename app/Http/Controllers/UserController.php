<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    public function register(Request $request)
    {
        $api_token=uniqid();
        $name=$request['name'];
        $email=$request['email'];
        $password=$request['password'];
        if(empty($password) or empty($email) or empty($name)) {
            return response()->json(['status'=>'500','message'=>'Fill all the fields']);

        }

        $userexists=User::where(['email'=>$email])->count();
        if($userexists>0) {
            return response()->json(['status'=>'400','message'=>'Email Id Already Exists']);
        }
    $user= User::create([
        'name'=>$name,
        'email'=>$email,
        'password'=>md5($password),
        'api_token'=> $api_token

    ]);
    return response()->json(['status'=>'200','api_token'=>$api_token,'message'=>'User created successfully']);

    }

    public function login(Request $request)
    {

        $email=$request['email'];
        $password=$request['password'];
        if(empty($password) or empty($email)) {
            return response()->json(['status'=>'400','message'=>'Fill all the fields']);

        }
        $api_token=uniqid();
        $encrpassword=md5($password);

        $userexists=User::where(['email'=>$email,'password'=>$encrpassword])->count();
        if($userexists>0) {


        $UpdateDetails = User::where('email', $email)->Update(['api_token'=>$api_token]);

        if($UpdateDetails) {
            return response()->json(['status'=>'200','api_token'=>$api_token,'message'=>'User logged successfully']);

        }
    }
        else {

            return response()->json(['status'=>'400','message'=>'Something went wrong']);

        }
   }



}
