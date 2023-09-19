<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Complaint;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ShowComplaintTest extends TestCase
{
    use  WithoutMiddleware;
    public function test_show_by_id()
    {
        $response = $this->get('/api/admin/complaints/2');
        $response->assertStatus(200);
    }
    public function test_show_by_unknown_id()
    {
        $response = $this->get('/api/admin/complaints/' . 5000);
        $code = $response->getData()->code;
        $this->assertEquals($code ,500);  
    }
}
