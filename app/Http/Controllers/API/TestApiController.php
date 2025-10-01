<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestApiController extends Controller
{
    // test function
    public function test()
    {
        return response()->json([
            'message' => 'API is working fine!'
        ], 200);
    }
}
