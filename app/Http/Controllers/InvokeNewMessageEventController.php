<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use Illuminate\Http\Request;

class InvokeNewMessageEventController extends Controller
{
    public function getNewMessage(){
        event(new NewMessage('Hello Kirumira Isaac this is a message from our event to test websockets'));
    }
}
