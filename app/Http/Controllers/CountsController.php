<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Exception;
use App\Models\User;
use App\Models\Profile;
use App\Exceptions\Handler;


class CountsController extends Controller
{


    public function get_total_users(){

   $getallusers = User::all();

   $totalusers = $getallusers->count();

   return response()->json(['total_users' => $totalusers ]);

    }


    public function get_total_no_successful_profiles(){

        $exclude = 'Not Searching';

        $getallprofiles = Profile::where('searching_status','=',$exclude)->get();

        $totalprofiles = $getallprofiles->count();
     
        return response()->json(['total_successfull_profiles' => $totalprofiles ]);
   
    }

    public function get_total_men(){

    
        $getallprofiles = Profile::where('gender','Male')->count();

     
        return response()->json(['total_men' => $getallprofiles ]);
   
    }

    public function get_total_women(){

        $women = 'Female';

        $getallprofiles = Profile::where('gender',$women)->get();

        $totalwomen = $getallprofiles->count();
     
        return response()->json(['total_women' => $totalwomen ]);
   
    }

}
