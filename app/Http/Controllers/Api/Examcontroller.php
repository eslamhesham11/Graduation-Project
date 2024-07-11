<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\exam;
use Illuminate\Http\Request;

class Examcontroller extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $exam = Exam::create([
            'name' => $request->name,
            'admin_id' => 1,
        ]);

        return response()->json(['message' => 'Exam created successfully'], 201);
    }
}
