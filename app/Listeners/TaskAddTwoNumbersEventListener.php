<?php

namespace App\Listeners;

use App\Events\TaskAddTwoNumbersEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TaskAddTwoNumbersEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TaskAddTwoNumbersEvent  $event
     * @return void
     */
    public function handle(TaskAddTwoNumbersEvent $event)
    {
        
       dd($event);
       
      
    }
}
