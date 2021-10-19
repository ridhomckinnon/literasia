<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Laravel\Passport\Passport;
use Laravel\Passport\Token;
use Auth;
class ApiController extends Controller
{
    public function register(Request $request){
        $input = $request->all();
        $input["password"] = bcrypt($input["password"]); 
        $data = User::create($input);
        
        $token = $data->createToken('LaravelPassport')->accessToken;
        return response()->json([
            "status" => "success",
            "result" => $data,
            "token" => $token
        ]);
    }

    public function login(Request $request)
    {
        $data = ([
            'email' => $request->email,   
            'password' => $request->password,
        ]); 
        if(auth()->attempt($data)){
            $token = auth()->user()->createToken('LaravelPassport')->accessToken;
            return response()->json([
                "status" => "success",
                "token" => $token
            ]);
        }
        else{
            return response()->json([
                "status" => "error",
                "message" => "Not found",
                401
            ]);
        }
    }

    
}
