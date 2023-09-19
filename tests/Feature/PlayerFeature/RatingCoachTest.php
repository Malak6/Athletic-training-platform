<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class RatingCoachTest extends TestCase
{
    use  WithoutMiddleware;
    public function test_over_rate()
    {
        $request = ['rating' => 10 ];
        $response = $this->post('/api/player/rate/2' , $request);
        $code = $response->getData()->code;
        $this->assertEquals($code ,500);  
    }

    public function test_right_rate()
    {
        $request = ['rating' => 4   ];
        $response = $this->post('/api/player/rate/2' , $request);
        $response->assertStatus(200);
    }
}
