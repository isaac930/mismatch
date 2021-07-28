<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Exception;
use App\Models\Profile;
use App\Exceptions\Handler;

class AdminGetAllProfiles extends Controller
{
    public function get_all_profiles(){

        $getallprofiles = Profile::orderByDesc('id')->get();
     
        return response()->json(['All_Profiles' => $getallprofiles ]);
     
         }
}
