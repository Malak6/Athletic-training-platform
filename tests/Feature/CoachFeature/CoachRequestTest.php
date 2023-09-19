<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CoachRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CoachRequestTest extends TestCase
{
    use  WithoutMiddleware;
    public function test_missing_info()
    {
        $request = [
        'name'     => "malak"               ,
        'gender'   => "female"              , 
        'password'   => "123456"             ,
        'phone_number' => "00011"           ,
        'email'         => "malaksrhan914@gmail.com"          ,
        ];
        $response = $this->post('/api/coach/register' , $request);
        $code = $response->getData()->code;
        $this->assertEquals($code ,500);  
    }

    public function test_right_data()
    {
        $num = rand(1 , 500);
        $request = [
        'name'     => "malak"               ,
        'gender'   => "female"              , 
        'weight'  => 70                ,
        'height'   => 170               ,    
        'password'   => "123456"             ,
        'phone_number' => "001"           ,
        'email'         => "test" . $num ."@gmail.com"          ,
        'confirm_password'          => "123456".$num  ,
        'experience_certificate'  => "vcxzcvbnhjkjhgfvcdfghjk",
        'birth_date'                => "2001-2-1",
        ];
        $response = $this->post('/api/coach/register' , $request);
        $response->assertStatus(200);
    }
    public function test_wrong_password()
    {
        $request = [
        'name'     => "malak"               ,
        'gender'   => "female"              , 
        'weight'  => 70                ,
        'height'   => 170               ,    
        'password'   => "123456"             ,
        'phone_number' => "00011"           ,
        'email'         => "malaksrhan914@gmail.com"          ,
        'confirm_password'          => "123"  ,
        'experience_certificate'  => "vcxzcvbnhjkjhgfvcdfghjk",
        'birth_date'                => "2001-2-1",
        ];
        $response = $this->post('/api/coach/register' , $request);
        $code = $response->getData()->code;
        $this->assertEquals($code ,500); 
    }
}
