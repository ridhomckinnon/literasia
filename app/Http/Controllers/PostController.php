<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Post;

use Auth;
use Validator;
class PostController extends Controller
{
    public function index()
    {
        $data = Post::all();
        return response()->json([
            'status' => 'success',
            'result' => $data
        ]);
    }

    public function store(Request $request)
    {
        
        $user_id = auth()->user()->id;
        // $input = $request->all();
        // $data = Post::create($input);
        $data = Post::create([
            'user_id' => $user_id,
            'title' => $request->title,
            'content' => $request->content,
        ]);

        if(!is_null($data)){
            return response()->json([
               'status' => 'success',
               'data' => $data     
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Not Found',
                401     
             ]);
        }
    }public function show($id){
        $post = Post::find($id);
        return response()->json([
            'status' => 'success',
            'result' => $post,
        ],200);

        if($post){
            return response()->json([
                'status' => 'success',
                'result' => $post,
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
        $post = Post::find($id);
        if(!$post){
            return response()->json([
                'status' => false,
                'message' => 'post error'
            ]);
            
        }
        $update = $post->update($request->all());
        if($update){
            return response()->json([
                'status' => true,
                'message' => $post
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
        $post = Post::find($id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'berhasil delete'
        ]);
    }
    
}
