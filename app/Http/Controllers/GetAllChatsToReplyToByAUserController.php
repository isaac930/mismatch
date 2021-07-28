<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Chat;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GetAllChatsToReplyToByAUserController extends Controller
{
    protected $user;

    public function __construct(){
        $this->middleware('auth:api');
        $this->user = $this->guard()->user();
    }

    public function get_all_chats_toberepliedto_byauser(){

        $email = Auth()->user()->email;
        $chats = Chat::orderByDesc('id')->where('chatment_email',$email)->get();
        return response()->json(['chats' => $chats->toArray()]);
        if(!$chats){
            return respose()->json(['message' => 'No Chat Found']);
        }
    }


    protected function guard(){
        return Auth::guard();

    }
}
