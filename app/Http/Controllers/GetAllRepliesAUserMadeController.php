<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\ChatReply;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetAllRepliesAUserMadeController extends Controller
{
    protected $user;

    public function __construct(){
        $this->middleware('auth:api');
        $this->user = $this->guard()->user();
    }

    public function get_all_replies_auser_makes(){

        $email = Auth()->user()->email;
        $chats = ChatReply::where('chatment_email',$email)->get();
        return response()->json(['chats_replies' => $chats->toArray()]);
        if(!$chats){
            return respose()->json(['message' => 'No Chat Replies Found']);
        }

    }


    protected function guard(){
        return Auth::guard();

    }
}
