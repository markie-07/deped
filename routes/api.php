<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

// ─── User Synchronization API ───
Route::middleware(\App\Http\Middleware\ApiTokenMiddleware::class)->group(function () {
    Route::get('/users', [App\Http\Controllers\Api\UserApiController::class, 'index']);
    Route::post('/users', [App\Http\Controllers\Api\UserApiController::class, 'store']);
    Route::get('/users/{id}', [App\Http\Controllers\Api\UserApiController::class, 'show']);
    Route::put('/users/{id}', [App\Http\Controllers\Api\UserApiController::class, 'update']);
    Route::delete('/users/{id}', [App\Http\Controllers\Api\UserApiController::class, 'destroy']);
    
    // ─── Leave Records API ───
    Route::post('/leave-records', [App\Http\Controllers\Api\LeaveRecordApiController::class, 'store']);
});


// ─── Authentication ───
Route::post('/login', function (Request $request) {
    // TODO: Implement login logic
    return response()->json(['message' => 'Login endpoint'], 200);
});

Route::post('/logout', function (Request $request) {
    // TODO: Implement logout logic
    return response()->json(['message' => 'Logged out successfully'], 200);
});

// ─── Dashboard Stats ───
Route::get('/dashboard/stats', function () {
    return response()->json([
        'total_employees' => 5800,
        'total_departments' => 120,
        'active_today' => 5234,
        'on_leave' => 142,
        'pending_requests' => 38,
        'attendance_rate' => 96.5,
    ]);
});

// ─── Employees ───
Route::group(['prefix' => 'employees'], function () {
    Route::get('/', [EmployeeController::class, 'getEmployees']);
    Route::get('/records', [EmployeeController::class, 'getRecordsByEmployee']);
});

// ─── Departments ───
Route::group(['prefix' => 'departments'], function () {
    Route::get('/', function () {
        return response()->json(['message' => 'List departments'], 200);
    });

    Route::get('/{id}', function ($id) {
        return response()->json(['message' => "Get department {$id}"], 200);
    });
});

// ─── Attendance ───
Route::group(['prefix' => 'attendance'], function () {
    Route::get('/', function () {
        return response()->json(['message' => 'List attendance records'], 200);
    });

    Route::post('/clock-in', function (Request $request) {
        return response()->json(['message' => 'Clock in recorded'], 200);
    });

    Route::post('/clock-out', function (Request $request) {
        return response()->json(['message' => 'Clock out recorded'], 200);
    });
});
