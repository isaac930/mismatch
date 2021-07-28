<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Register_Admin_Users extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register_admin_users']]);
      
    }

    protected function register_admin_users(Request $request){
      
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'contact' => 'required',
            'file' => 'max:5120', //5MB 
      
        ]);
        
        if($validator->fails()){
            return response()->json([
                $validator->errors()
            ], 422);
        }
  
  
        if(!$request->hasFile('file')) {
          return response()->json(['Upload_file_not_found, You Must Upload A File'], 400);
      }
  
      $allowedfileExtension=['jpg','png','jpeg'];
  
      $extension = $request->file('file')->getClientOriginalExtension();
  
      $check = in_array($extension,$allowedfileExtension);
  
      $image = $request->file('file');
      $new_name = rand().'.'.$image->getClientOriginalExtension();
  
      $image->move(public_path('/uploads/users'),$new_name);
        
      $user = new User;
      $user->name = $request->name;
      $user->email = $request->email;
      $user->contact = $request->contact;
      $user->password= bcrypt($request->password);
      $user->usertype = 'admin';
      $user->image_path = $new_name;
      $results = $user->save();
  
           return response()->json(['message' => 'New User created successfully']);
      }

      protected function guard(){
        return Auth::guard();
    }
}
