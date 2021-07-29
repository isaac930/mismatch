<?php

namespace App\Http\Controllers;

use App\Events\Test;
use Illuminate\Http\Request;

class InvokeNewMessageEventController extends Controller
{
    
    public function getNewMessage(){
     
       $event = event(new Test('hellow kirumira your event has been fired'));

       if($event){

       return response()->json(['message' => 'Event Fired']);

       }

       else{
        return response()->json(['message' => 'Failed to fire Event']); 
       }
    }
}
