<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Player;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class RequestProgramTest extends TestCase
{
    use  WithoutMiddleware;
    public function test_right_data()
    {
        $request = [ "email" => "test2@gmail.com" ,
                     "password" => "123456" ] ;
        $response = $this->post('/api/player/login' , $request);
        $token = $response->getData()->data->Token;

        $newRequest = ['coach_id' => 4 ,
                     'note' => 'blablablabla'];

        $newResponse = $this->withHeaders([
            "Authorization" => "Bearer ". $token
        ])->post('/api/player/requestprogram' , $newRequest);
        
        $newResponse->assertStatus(200);
    }

    public function test_without_money()
    {
        $request = [ "email" => "test3@gmail.com" ,
                     "password" => "123456" ] ;
        $response = $this->post('/api/player/login' , $request);
        $token = $response->getData()->data->Token;

        $newRequest = ['coach_id' => 4 ,
                     'note' => 'blablablabla'];

        $newResponse = $this->withHeaders([
            "Authorization" => "Bearer ". $token
        ])->post('/api/player/requestprogram' , $newRequest);
        
        $code = $newResponse->getData()->code;
        $this->assertEquals($code ,400); 
    }

    public function test_with_Unfinished_program()
    {
        $request = [ "email" => "test3@gmail.com" ,
                     "password" => "123456" ] ;
        $response = $this->post('/api/player/login' , $request);
        $token = $response->getData()->data->Token;

        $id = Player::where('email'  , '=' , 'test3@gmail.com')->first()->id;

        Program::create([
        'players_id' => $id,
        'coaches_id' => 2,
        'first_day' => "xxxxx",
        'second_day'  => "xxxxx",
        'third_day'  => "xxxxx",
        'fourth_day'  => "xxxxx", 
        'fifth_day'  => "xxxxx",
        'sixth_day'  => "xxxxx",  
        'seventh_day'  => "xxxxx",
        'notes'  => "xxxxx",
        'end_date' => "2023-10-10" ]);

        $newRequest = ['coach_id' => 4 ,
                     'note' => 'blablablabla'];

        $newResponse = $this->withHeaders([
            "Authorization" => "Bearer ". $token
        ])->post('/api/player/requestprogram' , $newRequest);
        $code = $newResponse->getData()->code;
        $this->assertEquals($code ,400);    
    }
}

