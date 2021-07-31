<?php

namespace App\Http\Controllers;

use App\Events\Test;
use Illuminate\Http\Request;

class InvokeNewMessageEventController extends Controller
{
    
    public function getNewMessage(){
     
       broadcast(new Test('hellow kirumira your event has been fired'));

    }
}
