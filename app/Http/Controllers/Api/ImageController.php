<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Resources\ImageResource;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class ImageController extends Controller
{
    public function getAllData($subject)
    {
        $data = ImageResource::collection(Image::where('subjectName', $subject)->get());
        return response()->json($data);
    }


    public function uploadImage(Request $request)
    {
        try {
            $token = request()->bearerToken();

            if (!$token) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }

            $payload = JWTAuth::setToken($token)->getPayload();

            if (!$payload || !isset($payload['sub'])) {
                return response()->json(['error' => 'Invalid token.'], 401);
            }
            $adminId = $payload['sub'];

            $path = $request->input('path');
            $title = $request->input('title');
            if (!$path) {
                return response()->json(['error' => "Not Found path"], 400);
            }
            $latestExam = Exam::latest()->first();
            Image::create([
                'path' => $path,
                'title' => $title,
                'exam_id' => $latestExam->id,
                'subjectName' => $latestExam->name,
                // 'admin_id' => 1,
                'admin_id' => $adminId,
            ]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal server error.'], 500);
        }
    }

    public function deleteImage(Request $request)
    {
        $relativePath = $request->input('path');

        // if ($relativePath) {
        // $fullPath=$relativePath
        // $fullPath = 'D:/graduation/' . str_replace('/', '\\', $relativePath);
        if (file_exists($relativePath)) {
            Storage::delete($relativePath);
            $image = Image::where('path', $relativePath)->first();
            $image->delete();
            return response()->json(['message' => 'Image deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Image not found on disk'], 404);
        }
        // } else {
        // return response()->json(['message' => 'Invalid path provided'], 400);
        // }
    }
}
