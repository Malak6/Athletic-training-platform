<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class SearchNameTest extends TestCase
{
    use  WithoutMiddleware;
    public function test_search_by_name()
    {
        $request = ['name' => 'test11'];
        $response = $this->post('/api/player/search/coach' , $request);
        $response->assertStatus(200);
    }
    public function test_search_without_name()
    {
        $request = [];
        $response = $this->post('/api/player/search/coach' , $request);
        $code = $response->getData()->code;
        $this->assertEquals($code ,500);  
        
    }
    public function test_search_unknown_name()
    {
        $request = ['name' => 'xxxxxx'];
        $response = $this->post('/api/player/search/coach' , $request);
        $response->assertStatus(200);
    }
}
