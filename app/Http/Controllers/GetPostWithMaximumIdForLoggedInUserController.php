<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Chat;
use App\Exceptions\Handler;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GetPostWithMaximumIdForLoggedInUserController extends Controller
{
    protected $user;

    public function __construct(){
        $this->middleware('auth:api');
        $this->user = $this->guard()->user();
    }

    public function get_post_with_maxid(){
        //lets get the max id from chat for currently logged in user

        $maxid = Chat::max('id');

        $email = Auth()->user()->email;
        $chat = Chat::where('email',$email)->where('id',$maxid)->get();
        return response()->json(['chat_post_with_maxid' => $chat->toArray()]);
        if(!$chat){
            return respose()->json(['message' => 'No Chat Found']);
        }
    }


    protected function guard(){
        return Auth::guard();

    }
}
