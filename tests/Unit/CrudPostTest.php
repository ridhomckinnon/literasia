<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
class CrudPostTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected function authenticate(){
        $user = User::create([
            'name' => 'robin',
            'email' => 'robin01@gmail.com',
            'password' => Hash::make('robin123'),
        ]);
        $token = $user->createToken('LaravelPassport')->accessToken;

        return $token;
    }

    public function test_create()
    {
        //Get token
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('POST',url('api/post'),[
            'user_id' => 700,
            'title' => 'serigala terakhir',
            'content' => 'isinya',
        ]);
        User::where('email','robin01@gmail.com')->delete();
        $response->assertStatus(200);
        Post::where('title','serigala terakhir')->delete();
    }

    public function test_delete(){
        $token = $this->authenticate();
        $post = Post::create([
            'user_id' => 700,
            'title' => 'serigala terakhir',
            'content' => 'isinya',
        ]);        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json("DELETE",url('api/post/'.$post->id,));
        User::where('email','robin01@gmail.com')->delete();
        $response->assertStatus(200);
    }

    public function test_getalldata(){
        //Authenticate and attach recipe to user
        $token = $this->authenticate();
        $post = Post::create([
            'user_id' => 700,
            'title' => 'serigala terakhir',
            'content' => 'isinya',
        ]);
        //call route and assert response
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET',url('api/post/'));
        User::where('name','robin')->delete();
        $response->assertStatus(200);
        Post::where('title','serigala terakhir')->delete();
    }
    public function test_showdata(){
        $token = $this->authenticate();
        $post = Post::create([
            'user_id' => 700,
            'title' => 'serigala terakhir',
            'content' => 'isinya',
        ]);
        // call route and assert response
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET',url('api/post/'.$post->id));
        User::where('email','robin01@gmail.com')->delete();
        $response->assertStatus(200);
        Post::where('title','serigala terakhir')->delete();
    }

    public function testUpdate(){
        $token = $this->authenticate();
        $post = Post::create([
            'user_id' => 700,
            'title' => 'serigala terakhir',
            'content' => 'isinya',
        ]);
        //call route and assert response
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('PUT',url('api/post/'.$post->id),[
            'name' => 'bayau',
        ]);
        User::where('email','robin01@gmail.com')->delete();
        $response->assertStatus(200);
        Post::where('title','serigala terakhir')->delete();
    }


    //Test the delete route
    
    
}