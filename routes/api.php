<?php

use App\Http\Controllers\Api\Attendancecontroller;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\AuthController as ControllersAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Examcontroller;
use App\Http\Controllers\Api\StudentController;
use App\Models\Attendance;
use App\Models\student;
use PharIo\Manifest\AuthorCollection;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::get('student/register', [AuthController::class, 'registerStudent']);
    Route::get('admin/register', [AuthController::class, 'registerAdmin']);
    Route::post('student/login', [AuthController::class, 'loginStudent']);
    Route::post('admin/login', [AuthController::class, 'loginAdmin']);
    // Route::get('student/attendance/{examName}', [AttendanceController::class, 'checkStudentAttendance']);
});


Route::get('/get-data/{subject}', [ImageController::class, 'getAllData']);
Route::post('/upload', [ImageController::class, 'uploadImage']);
Route::delete('/delete-image', [ImageController::class, 'deleteImage']);
Route::post('/exams', [ExamController::class, 'store']);
Route::post('/attendance', [Attendancecontroller::class, 'recordAttendance']);
Route::get('/show-attendance/{examName}', [Attendancecontroller::class, 'showAttendance']);
// Route::middleware('auth:api')->get('student/attendance/{examName}', [AttendanceController::class, 'checkStudentAttendance']);
Route::get('student/attendance/{examName}', [AttendanceController::class, 'checkStudentAttendance']);
