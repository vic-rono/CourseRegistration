<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
    {
    $request->validate([
        "name" => "required",
        "email" => "required|email|unique:users",
        "phone_no" => "required",
        "password" => "required"
    ]);

    $user = new User();

    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone_no = $request->phone_no;
    $user->password = bcrypt($request->password);

    $user->save();

    return response()->json([
        "status" => 1,
        "message" => "Registration successful"
    ], 200);

    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
        
        if(!$token = auth()->attempt(["email" => $request->email, "password" => $request->password])){
            return response()->json([
                "status" => 0,
                "message" => "Invalid Credentials"
            ]);
        }

        return response()->json([
            "status" => 1,
            "message"=> "Loggedin Successfuly",
            "access_token" => $token
        ]);
    }

    public function profile()
    {
        $user_data = auth()->user();

        return response()->json([
            "status" => 1,
            "message" => "User profile data",
            "data" => $user_data
        ]);
    }

    public function logout(){
        
        auth()->logout();
        

        return response()->json([
            "status" => 1,
            "message" => "User logged out"
        ]);
    }
}
