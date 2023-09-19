<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AdminAcceptRequestTest extends TestCase
{   use  WithoutMiddleware;
    public function test_right_email()
    {  
        $request = ["email"=> "test23@gmail.com" ];
        $response = $this->post('/api/admin/accept/coach', $request);
        $response->assertStatus(200);
    }
    public function test_without_email()
    {
        $request = [];
        $response = $this->post('/api/admin/accept/coach', $request);
        $code = $response->getData()->code;
        $this->assertEquals($code ,500);  
        
    }
    public function test_unverified_email()
    {  
        $request =["email" => "test21@gmail.com"];
        $response = $this->post('/api/admin/accept/coach', $request);
        $code = $response->getData()->code;
        $this->assertEquals($code ,500);  
    }
    public function test_wrong_email()
    {  
        $request = ["email" => "test100@gmail.com" ];
        $response = $this->post('/api/admin/accept/coach', $request);
        $code = $response->getData()->code;
        $this->assertEquals($code ,500);  
    }
}