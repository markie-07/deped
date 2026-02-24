<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\EmployeeController;

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
Route::prefix('employees')->group(function () {
    Route::get('/', [EmployeeController::class, 'getEmployees']);
    Route::get('/records', [EmployeeController::class, 'getRecordsByEmployee']);
});

// ─── Departments ───
Route::prefix('departments')->group(function () {
    Route::get('/', function () {
        return response()->json(['message' => 'List departments'], 200);
    });

    Route::get('/{id}', function ($id) {
        return response()->json(['message' => "Get department {$id}"], 200);
    });
});

// ─── Attendance ───
Route::prefix('attendance')->group(function () {
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
