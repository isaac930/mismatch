<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Exceptions\Handler;

class GetUserAvatarController extends Controller
{
    protected $user;

    public function __construct(){
        $this->middleware('auth:api');
        $this->user = $this->guard()->user();
        
    }

    public function getuseravatar(){

        $filename = Auth()->user()->image_path;

        $path    = "https://isaacbucketenock.s3.us-east-2.amazonaws.com/users/$filename";
     
        return response()->json(['avatar_path' => $path ]);
        
     }

     protected function guard(){
        return Auth::guard();
    }

}
