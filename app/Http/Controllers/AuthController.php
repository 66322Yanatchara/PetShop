<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
    {
        //สร้างข้อมูลผู้ใช้ใหม่
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);
        //user สร้างข้อมูล
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'token' => $user->createToken('API Token')->plainTextToken
        ], 201);
    }





    //login function
    public function login(Request $request)
    {
        //validate request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:25'
        ]);

        // check email
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        //generate token
        $token = $user->createToken($user->name . 'Auth-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'message' => 'Login successful',
            'token' => $token
        ], 200);
    }

    //logout function
    public function logout(Request $request)
    {
 
        if ($request->user()) {
            $request->user()->tokens()->delete();
            return response()->json(['success' => true, 'message' => 'User logged out'], 200);
        }
 
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
