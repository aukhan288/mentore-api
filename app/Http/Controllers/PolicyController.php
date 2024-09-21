<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Policy;

class PolicyController extends Controller
{
    function getPolicy($policy) {
        $policies = Policy::where('title', $policy)->first();
        return response()->json([
            'data' => $policies,
            'code' => 200
        ], 200); // HTTP 201 Created
    }
}
