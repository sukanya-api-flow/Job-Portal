<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class RegistrationController extends Controller
{
     // method to show registration page
    public function index() {
        return view('client.accounts.registration');
    }

     // method to register user
    public function register(Request $request) {
        $validator = Validator::make($request->all(),[
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:8',
        'confirm_password' => 'required|required_with:password|same:password'
        ]);
        if ($validator->fails() ) {
            return response()->json( ['status' => false, 'errors' => $validator->errors() ] , 422);
            }
            else{
                 $registeredUser = User::create($request->all());
                 return response()->json( ['status' => true, 'meassage'=> 'You have been registered successfully', 'data' => $registeredUser ] , 200);

            }
       
        
    }
}
