<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceResource;
use App\Models\attendance;
use App\Models\student;
use App\Models\Attendance as ModelsAttendance;
use App\Models\exam;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;

class Attendancecontroller extends Controller
{
    public function showAttendance($examName)
    {
        $data = AttendanceResource::collection(Attendance::where('exam_name', $examName)->get());
        return response()->json($data);
    }

    public function recordAttendance(Request $request)
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

            $latestExam = Exam::latest()->first();

            $existingAttendance = Attendance::where('student_id', $request->student_id)
                ->where('exam_id', $latestExam->id)
                ->exists();

            if ($existingAttendance) {
                return;
            }

            $student = Student::find($request->student_id);
            if (!$student) {
                return response()->json('Student not found', 404);
            }

            Attendance::create([
                'student_id' => $request->student_id,
                'exam_id' => $latestExam->id,
                'exam_name' => $latestExam->name,
                'student_name' => $student->name,
                // 'admin_id' => 1,
                'admin_id' => $adminId,
            ]);

            return response()->json('Attendance recorded successfully', 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal server error.'], 500);
        }
    }

    public function checkStudentAttendance($examName)
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

            $studentId = $payload['sub'];

            $attendance = Attendance::where('exam_name', $examName)
                ->where('student_id', $studentId)
                ->first();

            if (!$attendance) {
                return response()->json(['error' => 'Attendance not found.'], 404);
            }

            return response()->json([
                'student_id' => $attendance->student_id,
                'name' => $attendance->student->name,
                'created_at' => $attendance->created_at->format('Y-m-d H:i:s'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal server error.'], 500);
        }
    }
}
