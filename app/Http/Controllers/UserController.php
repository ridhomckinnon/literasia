<?php

namespace App\Http\Controllers;

use App\Models\User;
use Validator;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $data = User::all();
        // $data = DB::table('users')->get();
        return response()->json([
            'status' => 'success',
            'result' => $data
        ]);
    }
    public function store(Request $request)
    {
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
    public function show($id){
        $user = User::find($id);
        return response()->json([
            'status' => 'success',
            'result' => $user,
        ],200);

        if($user){
            return response()->json([
                'status' => 'success',
                'result' => $user,
            ],200);
        }
        else{
            return response()->json([
                'status' => 'fase',
                'result' => 'not found'
            ]); 
        }
    }
    public function update(Request $request,$id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'status' => false,
                'message' => 'user not found'
            ]);
            
        }
        $update = $user->update($request->all());
        if($update){
            return response()->json([
                'status' => true,
                'message' => $user
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'data gagal'
            ]);
        }
        
    }
    public function destroy($id)
    {
        $user = User::find($id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'berhasil delete'
        ]);
    }
}
