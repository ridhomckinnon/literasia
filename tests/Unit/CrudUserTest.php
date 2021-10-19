<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class CrudUserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected function authenticate(){
        $user = User::create([
            'name' => 'indah',
            'email' => 'indah01@gmail.com',
            'password' => Hash::make('indah123'),
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
        ])->json('POST',url('api/user'),[
            'name' => 'udin',
            'email' => 'udin01@gmail.com',
            'password' => Hash::make('udin123'),
        ]);
        User::where('email','indah01@gmail.com')->delete();
        $response->assertStatus(200);
        User::where('email','udin01@gmail.com')->delete();
    }

    public function test_delete(){
        $token = $this->authenticate();
        $user = User::create([
            'name' => 'udin',
            'email' => 'udin01@gmail.com',
            'password' => Hash::make('udin1234'),
        ]);        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json("DELETE",url('api/user/'.$user->id,));
        User::where('email','indah01@gmail.com')->delete();
        $response->assertStatus(200);
    }

    public function test_getalldata(){
        //Authenticate and attach recipe to user
        $token = $this->authenticate();
        $user = User::create([
            'name' => 'udin',
            'email' => 'udin01@gmail.com',
            'password' => Hash::make('udin1234'),
        ]);
        //call route and assert response
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET',url('api/user/'));
        User::where('email','indah01@gmail.com')->delete();
        $response->assertStatus(200);
        User::where('email','udin01@gmail.com')->delete();
    }
    public function test_showdata(){
        $token = $this->authenticate();
        $user = User::create([
            'name' => 'udin',
            'email' => 'udin01@gmail.com',
            'password' => Hash::make('udin1234'),
        ]);
        // call route and assert response
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET',url('api/user/'.$user->id));
        User::where('email','indah01@gmail.com')->delete();
        $response->assertStatus(200);
        User::where('email','udin01@gmail.com')->delete();
    }

    public function testUpdate(){
        $token = $this->authenticate();
        $user = User::create([
            'name' => 'udin',
            'email' => 'udin01@gmail.com',
            'password' => Hash::make('udin123'),
        ]);
        //call route and assert response
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('PUT',url('api/user/'.$user->id),[
            'name' => 'bayau',
        ]);
        User::where('email','udin01@gmail.com')->delete();
        $response->assertStatus(200);
        User::where('email','indah01@gmail.com')->delete();
    }


    //Test the delete route
    
    
}