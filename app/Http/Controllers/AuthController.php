<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
class AuthController extends Controller
{
   
     public function loginView()
    {
        return view('login');
    }

    public function login(Request $request)
    {
       
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        
        if (Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
           
            return response()->json([
                'success' => true,
                'message' => 'Login successful!',
            ]);
        } else {
           
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.',
            ], 401); 
        }
    }
   
    public function showRegistrationForm()
    {
         return view('register');
    }
    public function register(Request $request)
    {
      
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ];
    
       
        $messages = [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'password.required' => 'Please enter your password.',
            'password.confirmed' => 'Passwords do not match.',
            'password.min' => 'Password must be at least 6 characters long.',
        ];
    
       
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

       
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Registration successful!',
        ]);
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('message', 'Successfully logged out');
    }
}
