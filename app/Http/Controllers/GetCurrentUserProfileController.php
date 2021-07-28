<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Profile;
use App\Exceptions\Handler;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GetCurrentUserProfileController extends Controller
{
    protected $user;

public function __construct(){
    $this->middleware('auth:api');
    $this->user = $this->guard()->user();
}

public function get_profile_for_current_user(){

    $name = Auth()->user()->name;
    $email = Auth()->user()->email;
    $contact = Auth()->user()->contact;

    $profile = Profile::where('name',$name)->where('email',$email)->where('contact',$contact)->get();
    return response()->json(['profile' => $profile->toArray()]);
    if(!$profile){
        return respose()->json(['message' => 'Profile Not Found']);
    }

}



protected function guard(){
    return Auth::guard();

}
}
