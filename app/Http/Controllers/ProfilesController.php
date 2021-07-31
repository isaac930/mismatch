<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Profile;
use App\Exceptions\Handler;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfilesController extends Controller
{

protected $user;

public function __construct(){
    $this->middleware('auth:api');
    $this->user = $this->guard()->user();
}

public  function store(Request $request){

    $validator = Validator::make($request->all(), [
        'age' => 'required',
        'location' => 'required',
        'place_of_birth' => 'required',
        'occupation' => 'required',
        'likes' => 'required',
        'dislikes' => 'required',
        'gender' => 'required',
        'searching_status' => 'required'

    ]);

    if($validator->fails()){
        return response()->json($validator->errors(), 400);
    }
    
    if (Auth::check()){
    $name = Auth()->user()->name;
    $email = Auth()->user()->email;
    $contact = Auth()->user()->contact;
    $image_path = Auth()->user()->image_path;
    }

    else{   
        
        $name = "kirumira isaac";
        $email = "kirumiraisaac@gmail.com";
        $contact = "256759939936";
        $image_path = "1234566.jpeg";
    }

    $checkprofile_existance = Profile::where('email',$email)->get();

    $userprofile_count = $checkprofile_existance->count();

    if($userprofile_count >= 1){
    return response()->json(['message' => 'You Have a Profile Already Set, What You Can Do Is Only To Update Your Profile']); 
    
     }

    else{
    
    $profile = new Profile;
    $profile->name = $name;
    $profile->email = $email;
    $profile->contact = $contact;
    $profile->age = $request->age;
    $profile->location = $request->location;
    $profile->place_of_birth = $request->place_of_birth;
    $profile->occupation = $request->occupation;
    $profile->likes = $request->likes;
    $profile->dislikes = $request->dislikes;
    $profile->gender = $request->gender;
    $profile->searching_status = $request->searching_status;
    $profile->image_path = $image_path;
    $results = $profile->save();

    if($results){ 
        return response()->json(['message' => 'Your Profile Has Been Setup successfully']);
        }
       else{
        return response()->json(['message' => 'Profile creation failed']); 
       }

    }
}

public function index(){

    if (Auth::check()){
    $email = Auth()->user()->email;
    }

    else{
        $email = "kirumiraisaac@gmail.com";
    }

    $usergender = Profile::where('email',$email)->get('gender');
    
    $profiles = Profile::orderByDesc('id')->where('email','!=',$email)->where('gender','!=',$usergender)->get();
    return response()->json(['profiles' => $profiles->toArray()]);
    if(!$profiles){
        return respose()->json(['message' => 'No Profile Found']);
    }
}

public function show($id){

    $exclude = 'Not Searching';
    $email = Auth()->user()->email;
    $profile = Profile::where('searching_status','!=',$exclude)->where('email','!=',$email)->where('id',$id)->get();
    return response()->json(['profile' => $profile->toArray()]);
    if(!$profile){
        return respose()->json(['message' => 'Profile Not Found']);
    } 
}

public function update(Request $request, $id){

    $validator = Validator::make($request->all(), [
        'age' => 'required',
        'location' => 'required',
        'place_of_birth' => 'required',
        'occupation' => 'required',
        'likes' => 'required',
        'dislikes' => 'required',
        'gender' => 'required',
        'searching_status' => 'required'

    ]);

    if($validator->fails()){
        return response()->json($validator->errors(), 400);
    }

    $name = Auth()->user()->name;
    $email = Auth()->user()->email;
    $contact = Auth()->user()->contact;
    $image_path = Auth()->user()->image_path;
  
    $exclude = 'Not Searching';
    $profile = Profile::where('searching_status','!=',$exclude)->find($id);
    $profile->name = $name;
    $profile->email = $email;
    $profile->contact = $contact;
    $profile->age = $request->age;
    $profile->location = $request->location;
    $profile->place_of_birth = $request->place_of_birth;
    $profile->occupation = $request->occupation;
    $profile->likes = $request->likes;
    $profile->dislikes = $request->dislikes;
    $profile->gender = $request->gender;
    $profile->searching_status = $request->searching_status;
    $profile->image_path = $image_path;
    $results = $profile->save();

    if($results){ 
        return response()->json(['message' => 'Profile Details Updated successfully']);
        }
       else{
        return response()->json(['message' => 'Profile Update Failed']); 
       }


}

public function destroy($id){
    try{

        $exclude = 'Not Searching';
        $profile = Profile::where('searching_status','!=',$exclude)->where('id',$id)->find($id);
        $results = $profile->delete();

        if($results){ 
            return response()->json(['message' => 'Profile Deleted successfully']);
            }
           else{
            return response()->json(['message' => 'Profile deletion failed']); 
           }
        }
       
catch(Exception $e){
    return response()->json(['error' => $e]); 
}
}


    protected function guard(){
        return Auth::guard();

    }
}
