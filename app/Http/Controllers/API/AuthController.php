<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function login(Request $request)
    {
       
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        
        if (Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
            $user= Auth::user();
            return response()->json([
                'token' => $user->createToken('token-name')->plainTextToken,
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

    public function logout(Request $request)
    {
        $user = $request->user();

        $user->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful!',
        ]);
    }

}
