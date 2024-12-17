<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(Request $request)
    {
        $query = $request->header('Query'); 
        if (!$query) {
            return response()->json(['error' => 'No query provided in header'], 400);
        }

        return response()->json([
            $query
        ]);
    }
}
