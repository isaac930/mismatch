<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Chat;

use App\Models\User;
use App\Models\ChatReply;
use App\Exceptions\Handler;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminGellAllChatsController extends Controller
{
    protected $user;

    public function __construct(){
        $this->middleware('auth:api');
        $this->user = $this->guard()->user();
    }

public function get_all_chats_by_admin(){

    $usertype = Auth()->user()->usertype;
    if($usertype == 'admin'){
    $chats = ChatReply::all();
    return response()->json(['allchats' => $chats->toArray()]);
    if(!$chats){
        return respose()->json(['message' => 'No Chat Replies Found']);
    }

}

else{
    return respose()->json(['message' => 'Only Admin is allowed to this Resource']) ; 
}

}


    protected function guard(){
        return Auth::guard();

    }
}
