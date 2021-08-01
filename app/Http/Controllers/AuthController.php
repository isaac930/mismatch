<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\User;
use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;
use Nexmo\Laravel\Facade\Nexmo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
 
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
      
    }

    protected function login(Request $request){
       
      $validator = Validator::make($request->all(), [
          'email' => 'required|email',
          'password' => 'required|string|min:6'
      ]);

      if($validator->fails()){
          return response()->json($validator->errors(), 400);
      }

      $token_validity = 24 * 60;
      $this->guard()->factory()->setTTL($token_validity);

      if(!$token = $this->guard()->attempt($validator->validated())){
          return response()->json(['error' => 'Unauthorized'], 401);   
      }

      $usertype = User::where('email',$request->email)->get('usertype');

      return response()->json(['usertype' => $usertype,'token' => $token]);
    }

    protected function register(Request $request){
      
      $validator = Validator::make($request->all(), [
          'name' => 'required|string|between:2,100',
          'email' => 'required|email|unique:users',
          'password' => 'required|confirmed|min:6',
          'file' => 'max:5120', //5MB 
          'contact' => 'required',
    
      ]);
      
      if($validator->fails()){
          return response()->json([
              $validator->errors()
          ], 422);
      }


      if(!$request->hasFile('file')) {
        return response()->json(['Upload_file_not_found, You Must Upload A File'], 400);
    }
     //allowed file extensions
    $allowedfileExtension=['jpg','png','jpeg'];

    $extension = $request->file('file')->getClientOriginalExtension();

    $check = in_array($extension,$allowedfileExtension);

    $image = $request->file('file');
    $new_name = rand().'.'.$image->getClientOriginalExtension();

    $image->move(public_path('/uploads/users/'),$new_name);

    // $filePath = 'users/' . $new_name;

    // Storage::disk('s3')->put($filePath, file_get_contents($image));
      
    $user = new User;
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password= bcrypt($request->password);
    $user->usertype = 'user';
    $user->image_path = $new_name;
    $user->contact = $request->contact;
    $results = $user->save();


     //lets send an sms


     $from = 'MISMATCH';
     $to = $request->contact;
     $sms = 'Your Mismatch Account Has Been Created';

     try{
 
     Nexmo::message()->send([
         'to' => $to,// 256751550658
         'from' => $from,
         'text' => $sms
     ]);

  }
  catch(Exception $e){
   return 'error:'.' '.$e;
  }
      
     //sms ends


     //lets also notify the user via email

     $email = $request->email;
     $subject= 'MisMatch';
     $body= 'Your Accout Has Been Created Now You Can Go Ahead With Your Search, We Wish You Success';
     $name =$request->name;
     $mailData = [
         'name' => $name,
         'email' => $email,
         'subject' => $subject,
         'body' => $body
     ];
     
     $job = (new SendEmailJob($email,$mailData))

                      ->delay(Carbon::now()->addSeconds(5));

             dispatch($job);   
     
     return response()->json([
         'message' =>  'Your Account Has Been Created ,Message has been sent to You & Email has been sent to Your Mail To Confirm Account Creation'
     ]);

     //email sending ends here

    }


    protected function logout(){
      $this->guard()->logout();
      return response()->json(['message' => 'User logged out successfully']);  
    }

    protected function profile(){
     return response()->json(['user_registration_profile' => $this->guard()->user()]);   
    }

    protected function refresh(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);
  
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        
        $token_validity = 24 * 60;
        $this->guard()->factory()->setTTL($token_validity);
  
        if(!$token = $this->guard()->attempt($validator->validated())){
            return response()->json(['error' => 'Unauthorized'], 401);   
        }
       $usertype = User::where('email',$request->email)->get('usertype');

       return response()->json(['usertype' => $usertype,'token' => $token]); 
    }

    protected function guard(){
        return Auth::guard();
    }
}
