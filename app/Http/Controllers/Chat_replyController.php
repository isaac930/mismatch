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

class Chat_replyController extends Controller
{
    protected $user;

    public function __construct(){
        $this->middleware('auth:api');
        $this->user = $this->guard()->user();
    }

    public  function store(Request $request){


        $validator = Validator::make($request->all(), [
            'chatment_email' => 'required',
            'post_reply' => 'required',
            'post_id' => 'required',
        ]);
    
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $name = Auth()->user()->name; //my name
        $email = Auth()->user()->email; //my email
        $contact = Auth()->user()->contact; //my contact

        $chatment_email = $request->chatment_email; // email of chatment to reply to
        $id = $request->post_id; //id of post to reply to
        $post_reply = $request->post_reply; //reply to the post

        $now = Carbon::now();

        //lets get the post we are going to reply to from chats

        $post_to_reply_to = Chat::where('email',$chatment_email)->where('id',$id)->get('post');
        $chatment_name = Chat::where('email',$chatment_email)->where('id',$id)->get('name');
        $chatment_contact = Chat::where('email',$chatment_email)->where('id',$id)->get('contact');

        $reply = new ChatReply;
        $reply->date = $now;
        $reply->name = $name;
        $reply->email = $email;
        $reply->contact = $contact;
        $reply->chatment_email = $chatment_email;
        $reply->chatment_name = $chatment_name[0]['name'];
        $reply->chatment_contact = $chatment_contact[0]['contact'];
        $reply->post = $post_to_reply_to[0]['post'];
        $reply->reply_post = $post_reply;
        $results = $reply->save();

    

        if($results){ 
            return response()->json(['message' => 'Your Reply To Post Has Been Submited']);
            }
           else{
            return response()->json(['message' => 'Post Reply Submission Failed']); 
           }
    }

    public function index(){
   
        $email = Auth()->user()->email;
        $chats = ChatReply::where('email',$email)->get();
        return response()->json(['chats_replies' => $chats->toArray()]);
        if(!$chats){
            return respose()->json(['message' => 'No Chat Replies Found']);
        }

    }

    public function show($id){

        $email = Auth()->user()->email;
        $chat = ChatReply::where('email',$email)->where('id',$id)->get();
        return response()->json(['chat_reply' => $chat->toArray()]);
        if(!$chat){
            return respose()->json(['message' => 'No Chat Reply Found']);
        }
    }

    public function destroy($id){

        $email = Auth()->user()->email;
        $chat = ChatReply::where('email',$email)->where('id',$id)->delete();
        return response()->json(['message' => 'Chat Reply Deleted Successfully']);
        if(!$chat){
            return respose()->json(['message' => 'Chat Reply Could Not Be Deleted Found']);
        }
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'chatment_email' => 'required',
            'post_reply' => 'required',
            'post_id' => 'required',
        ]);
    
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $name = Auth()->user()->name; //my name
        $email = Auth()->user()->email; //my email
        $contact = Auth()->user()->contact; //my contact

        $chatment_email = $request->chatment_email; // email of chatment to reply to
        $postid = $request->post_id; //id of post to reply to
        $post_reply = $request->post_reply; //reply to the post

        $now = Carbon::now();

        //lets get the post we are going to reply to from chats

        $post_to_reply_to = Chat::where('email',$chatment_email)->where('id',$postid)->get('post');
        $chatment_name = Chat::where('email',$chatment_email)->where('id',$postid)->get('name');
        $chatment_contact = Chat::where('email',$chatment_email)->where('id',$postid)->get('contact');

        $reply = ChatReply::find($id);
        $reply->date = $now;
        $reply->name = $name;
        $reply->email = $email;
        $reply->contact = $contact;
        $reply->chatment_email = $chatment_email;
        $reply->chatment_name = $chatment_name[0]['name'];
        $reply->chatment_contact = $chatment_contact[0]['contact'];
        $reply->post = $post_to_reply_to[0]['post'];
        $reply->reply_post = $post_reply;
        $results = $reply->save();

        if($results){ 
            return response()->json(['message' => 'Your Reply To Post Have Been Updated']);
            }
           else{
            return response()->json(['message' => 'Post Reply Update Failed']); 
           }
    }

    protected function guard(){
        return Auth::guard();

    }
}
