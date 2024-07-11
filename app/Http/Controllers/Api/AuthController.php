<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\admin;
use App\Models\User;
use App\Models\student;
use App\Models\Student as ModelsStudent;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Seeder;

class AuthController extends Controller
{
    public function registerAdmin(Request $request)
    {
        Admin::create([
            'name' => 'admin',
            'email' => "admin@gmail.com",
            'password' => bcrypt('admin'),
        ]);
        return response()->json([
            'message' => 'Admin successfully registered'
        ], 201);
    }
    public function registerStudent(Request $request)
    {
        Student::create([
            'id' => 12100582,
            'name' => 'Abdelrahman Mamdouh',
            'email' => "abdo@gmail.com",
            'password' => bcrypt('abdo'),
        ]);
        return response()->json([
            'message' => 'Student successfully registered'
        ], 201);
    }

    public function loginAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = Auth::guard('api_admins')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }
    public function loginStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = Auth::guard('api_students')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }


    protected function createNewToken($token)
    {

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ]);
    }
}
