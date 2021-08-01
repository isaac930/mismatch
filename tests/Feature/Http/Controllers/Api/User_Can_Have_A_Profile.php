<?php

namespace Tests\Feature\Http\Controllers\Api;

use Tests\TestCase;
use App\Models\Profile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class User_Can_Have_A_Profile extends TestCase
{
  
  // use RefreshDatabase;

  //i will enable the above code later

  /** @test */
    public function a_user_can_have_a_profile()
    {
        $this->withoutExceptionHandling();
        $this->withoutMiddleware();
        $response = $this->post("http://localhost:8000/api/auth/profiles",[
          
        'name' => 'kirumira isaac',
        'email' => 'james@gmail.com',
        'image_path' => '123456.jpg',   
        'age' => '20',
        'location' => 'mengo',
        'place_of_birth' => 'mityana',
        'occupation' => 'engineer',
        'likes' => 'prayers',
        'dislikes' => 'alcohol',
        'gender' => 'male',
        'searching_status' => 'single',
        ]);
        $response->assertOk();
    }


      /** @test */
      public function a_user_can_get_other_people_profile()
      {

        //$this->withoutExceptionHandling();
        $this->withoutMiddleware();
        $response = $this->get("http://localhost:8000/api/auth/profiles");
        $response->assertOk();
       

      }
}
