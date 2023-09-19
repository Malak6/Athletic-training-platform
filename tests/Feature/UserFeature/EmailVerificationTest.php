<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Models\EmailVer;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class EmailVerificationTest extends TestCase
{
    use  WithoutMiddleware;
    public function test_without_email()
    {
        $request = [];
        $response = $this->post('/api/check/code' , $request);
        $code = $response->getData()->code;
        $this->assertEquals($code ,500); 
    }
    public function test_not_found_email()
    {
        $request = ['email' => "blabla@gmail.com"];
        $response = $this->post('/api/check/code' , $request);
        // $code = $response->getData()->code;
        // $this->assertEquals($code ,500); 
        $response->assertStatus(200);

    }

    public function test_wrong_code()
    {
        $email = EmailVer::create([
        'email'    => "test22@gmail.com"         ,
        'verable_id'  =>   1    ,
        'verable_type' =>  "App\Models\CoachRequest"     , 
        'vefrification_code'  => 4444 ,
        'is_confirmed'  => 0    ,
            
        ]);

        $request = ['email' => "test22@gmail.com" ,
        'confirm_code' => 0000
        ];
        $response = $this->post('/api/check/code' , $request);
        $email->delete();
        $response->assertStatus(200);
    }

    public function test_valid_email()
    { 
        $email = EmailVer::create([
                'email'    => "test42@gmail.com"         ,
                'verable_id'  =>   3    ,
                'verable_type' =>  "App\Models\CoachRequest"     , 
                'vefrification_code'  => 5555 ,
                'is_confirmed'  => 0    ,
        ]);
        $request = ['email' => "test42@gmail.com" ,
        'confirm_code' => 5555
        ];
        $response = $this->post('/api/check/code' , $request);
        $response->assertStatus(200);
    }
}
