<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Chat;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChatsController extends Controller
{
    protected $user;

    public function __construct(){
        $this->middleware('auth:api');
        $this->user = $this->guard()->user();
    }

    public  function store(Request $request){

        $validator = Validator::make($request->all(), [
            'chatment_email' => 'required',
            'post' => 'required',
            
    
        ]);
    
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
    
        $name = Auth()->user()->name;
        $email = Auth()->user()->email;
        $contact = Auth()->user()->contact;

        $chatment_email = $request->chatment_email;
        $post = $request->post;

        $now = Carbon::now();
    
        $chatment_name = User::where('email',$chatment_email)->get('name');
        $chatment_contact = User::where('email',$chatment_email)->get('contact');
        
        $chat = new Chat;
        $chat->date = $now;
        $chat->name = $name;
        $chat->email = $email;
        $chat->contact = $contact;
        $chat->chatment_email = $chatment_email;
        $chat->chatment_name = $chatment_name[0]['name'];
        $chat->chatment_contact = $chatment_contact[0]['contact'];
        $chat->post = $post;
        $results = $chat->save();
    
        if($results){ 
            return response()->json(['message' => 'Your Chat Post Has Been Submited']);
            }
           else{
            return response()->json(['message' => 'Chat Post Submission Failed']); 
           }
    
    }

    public function index(){
   
        $email = Auth()->user()->email;
        $chats = Chat::orderByDesc('id')->where('email',$email)->get();
        return response()->json(['chats' => $chats->toArray()]);
        if(!$chats){
            return respose()->json(['message' => 'No Chat Found']);
        }

    }

    public function show($id){

        $email = Auth()->user()->email;
        $chat = Chat::where('email',$email)->where('id',$id)->get();
        return response()->json(['chat' => $chat->toArray()]);
        if(!$chat){
            return respose()->json(['message' => 'No Chat Found']);
        }
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'chatment_email' => 'required',
            'post' => 'required',
    
        ]);
    
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
    
        $name = Auth()->user()->name;
        $email = Auth()->user()->email;
        $contact = Auth()->user()->contact;

        $chatment_email = $request->chatment_email;
        $post = $request->post;

        $now = Carbon::now();
    
        $chatment_name = User::where('email',$chatment_email)->get('name');
        $chatment_contact = User::where('email',$chatment_email)->get('contact');
        
        $chat = Chat::find($id);
        $chat->date = $now;
        $chat->name = $name;
        $chat->email = $email;
        $chat->contact = $contact;
        $chat->chatment_email = $chatment_email;
        $chat->chatment_name = $chatment_name[0]['name'];
        $chat->chatment_contact = $chatment_contact[0]['contact'];
        $chat->post = $post;
        $results = $chat->save();
    
        if($results){ 
            return response()->json(['message' => 'Your Chat Post Have Been Updated']);
            }
           else{
            return response()->json(['message' => 'Chat Post Update Failed']); 
           }
    
    }

    public function destroy($id){
        $email = Auth()->user()->email;
        $chat = Chat::where('email',$email)->where('id',$id)->delete();
        return response()->json(['message' => 'Chat Post Deleted Successfully']);
        if(!$chat){
            return respose()->json(['message' => 'No Chat Post Found']);
        }
    }

    protected function guard(){
        return Auth::guard();

    }
}
