<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\User;


class LoginController extends Controller
{
    //
    public function index() {
        // method to show login page
        return view('client.accounts.login');
    }

         // method to register user
         public function login(Request $request) {
            $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
            ]);
            if ($validator->fails()) 
            {
                return redirect()->route('login')->withErrors($validator)->withInput($request->only('email'));

                }
                else{
                    if(Auth::attempt(['email'=> $request->email, 'password' => $request->password])){
                        return redirect()->route('profile')->with('success','logged in');

                    }
                    else{
                        return redirect()->route('login')->with('error','Either email or password is invalid');

                    }                    
    
                }
           
            
    }

         public function profile() {
            $user = User:: where('id', Auth::user()->id)->first();
            return view('client.accounts.profile',[
                'user'=> $user
            ]);

            
    }
    public function updateProfile(Request $request) {
        $id = Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'designation' => 'required|string',
            'mobile' => 'required'
            ]);
            if ($validator->fails() ) {
                return response()->json( ['status' => false, 'errors' => $validator->errors() ] , 422);
                }
                else{
                     $updatedUser = User::where('id',$id)->update(['name' => $request->name,
                     'email' => $request->email,
                     'designation' => $request->designation,
                     'mobile' => $request->mobile,
                    ]);
                     return response()->json( ['status' => true, 'meassage'=> 'Your account details have been updated successfully', 'data' => $updatedUser ] , 200);
    
                }       
            }
            public function updateProfilePic(Request $request) {
                {
                   // Validate the uploaded file
                   $id = Auth::user()->id;

                    $validator = Validator::make($request->all(),[
                        'dp' => 'required|image|mimes:jpeg,png,jpg,gif', // Adjust max file size as needed
                    ]);
                    if($validator-> fails()){
                       // return redirect()->route('profile')->with('error',$validator->errors());

                        return response()->json( ['status' => false, 'errors' => $validator->errors() ] , 422);
                    }
                    else{
                       // Get the original filename of the uploaded file
                            $originalFileName = $request->file('dp')->getClientOriginalName();

                            // Generate a unique filename to avoid conflicts
                            $fileName = time() . '_' . $originalFileName;

                            // Move the uploaded file to the desired location
                            $request->file('dp')->move(public_path('profile_pictures'), $fileName);

                            // Update user's profile picture in the database
                            User::where('id',$id)->update(['dp' => $fileName]);

            
                            return response()->json( ['status' => true, 'meassage'=> 'Your avatar has been updated successfully', 'data' => null ] , 200);
                        }
            
                    }                 
                }
            
            
            
        public function logout() {
            Auth::logout();
            return redirect()->route('login')->with('success','successfully logged out');        
            }
    }
