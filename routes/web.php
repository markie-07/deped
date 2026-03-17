<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\LeaveRecordController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\AuditLog;
use Illuminate\Support\Str;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect(Auth::user()->role === 'admin' ? '/admin/dashboard' : '/user/dashboard');
    }
    return view('login');
});

// Role-based route protection groups
Route::middleware(['auth'])->group(function () {
    // Admin Routes
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            if (Auth::user()->role !== 'admin') return redirect('/user/dashboard');
            return view('admin.dashboard');
        });
        Route::get('/form', function () {
            if (Auth::user()->role !== 'admin') return redirect('/user/dashboard');
            return view('admin.form');
        });
        Route::get('/employee', [EmployeeController::class, 'index']);
        Route::get('/leave-records', [LeaveRecordController::class, 'index']);
        Route::get('/incharge', function () {
            if (Auth::user()->role !== 'admin') return redirect('/user/dashboard');
            return view('admin.incharge');
        });
        Route::get('/school', function () {
            if (Auth::user()->role !== 'admin') return redirect('/user/dashboard');
            return view('admin.school');
        });
        Route::get('/position', function () {
            if (Auth::user()->role !== 'admin') return redirect('/user/dashboard');
            return view('admin.position');
        });
        Route::get('/types-of-leave', function () {
            if (Auth::user()->role !== 'admin') return redirect('/user/dashboard');
            return view('admin.types-of-leave');
        });
        Route::get('/remarks', function () {
            if (Auth::user()->role !== 'admin') return redirect('/user/dashboard');
            return view('admin.remarks');
        });
        Route::get('/employee-management', function () {
            if (Auth::user()->role !== 'admin') return redirect('/user/dashboard');
            return view('admin.employee-management');
        });
        Route::get('/profile', function () {
            if (Auth::user()->role !== 'admin') return redirect('/user/profile');
            return view('admin.profile');
        });
    });

    // User Routes
    Route::prefix('user')->group(function () {
        Route::get('/dashboard', function () {
            if (Auth::user()->role === 'admin') return redirect('/admin/dashboard');
            return view('user.dashboard');
        });
        Route::get('/form', function () {
            if (Auth::user()->role === 'admin') return redirect('/admin/dashboard');
            return view('user.form');
        });
        Route::get('/employee', [EmployeeController::class, 'index']);
        Route::get('/leave-records', function () {
            if (Auth::user()->role === 'admin') return redirect('/admin/dashboard');
            return view('user.leave-records');
        });
        Route::get('/school', function () {
            if (Auth::user()->role === 'admin') return redirect('/admin/dashboard');
            return view('user.school');
        });
        Route::get('/position', function () {
            if (Auth::user()->role === 'admin') return redirect('/admin/dashboard');
            return view('user.position');
        });
        Route::get('/types-of-leave', function () {
            if (Auth::user()->role === 'admin') return redirect('/admin/dashboard');
            return view('user.types-of-leave');
        });
        Route::get('/remarks', function () {
            if (Auth::user()->role === 'admin') return redirect('/admin/dashboard');
            return view('user.remarks');
        });
        Route::get('/profile', function () {
            if (Auth::user()->role === 'admin') return redirect('/admin/profile');
            return view('user.profile');
        });
    });
});

// Shared API and other routes
Route::get('/api/employees', [EmployeeController::class, 'getEmployees']);
Route::get('/api/employees/records', [EmployeeController::class, 'getRecordsByEmployee']);

Route::post('/leave-records', [LeaveRecordController::class, 'store']);
Route::post('/leave-records/bulk', [LeaveRecordController::class, 'bulkStore']);
Route::post('/leave-records/bulk-process', [LeaveRecordController::class, 'bulkProcess']);
Route::get('/leave-records', [LeaveRecordController::class, 'index']);
Route::get('/api/leave-records/{id}', [LeaveRecordController::class, 'show']);
Route::put('/leave-records/{id}', [LeaveRecordController::class, 'update']);
Route::delete('/leave-records/{id}', [LeaveRecordController::class, 'destroy']);
Route::get('/leave-records/dropdown-data', [LeaveRecordController::class, 'dropdownData']);
Route::get('/leave-records/count', [LeaveRecordController::class, 'count']);
Route::get('/leave-records/schools', [LeaveRecordController::class, 'getSchools']);
Route::get('/leave-records/by-school', [LeaveRecordController::class, 'getBySchool']);
Route::get('/leave-records/positions', [LeaveRecordController::class, 'getPositions']);
Route::get('/leave-records/by-position', [LeaveRecordController::class, 'getByPosition']);
Route::get('/leave-records/types', [LeaveRecordController::class, 'getLeaveTypes']);
Route::get('/leave-records/by-type', [LeaveRecordController::class, 'getByLeaveType']);
Route::get('/leave-records/remarks-list', [LeaveRecordController::class, 'getRemarksList']);
Route::get('/leave-records/by-remark', [LeaveRecordController::class, 'getByRemark']);
Route::get('/leave-records/incharges', [LeaveRecordController::class, 'getIncharges']);
Route::get('/leave-records/by-incharge', [LeaveRecordController::class, 'getByIncharge']);
Route::get('/api/dashboard/stats', [LeaveRecordController::class, 'getDashboardStats']);
Route::get('/api/dashboard/incharge-stats', [LeaveRecordController::class, 'getInchargeStats']);
Route::get('/api/dashboard/module-usage', [LeaveRecordController::class, 'getModuleUsageStats']);
Route::get('/api/dashboard/remark-stats', [LeaveRecordController::class, 'getRemarkStats']);
Route::get('/api/dashboard/audit-logs', function(Request $request) {
    if (!Auth::check()) return response()->json([], 401);
    
    $user = Auth::user();
    $limit = $request->query('limit', 15);
    $query = AuditLog::with('user')->orderBy('created_at', 'desc');
    
    // Non-admins can only see their own logs
    if ($user->role !== 'admin') {
        $query->where('user_id', $user->id);
    }
    
    if ($request->has('today')) {
        $query->whereDate('created_at', now()->toDateString());
    }
    
    return response()->json($query->limit($limit)->get());
});

Route::get('/profile', function () {
    if (!Auth::check() && !session('authenticated')) {
        return redirect('/');
    }
    $role = auth()->user()->role;
    return redirect($role === 'admin' ? '/admin/profile' : '/user/profile');
});

// Employee Account Management API
Route::get('/api/user-accounts', function () {
    return response()->json(User::orderBy('created_at', 'desc')->get([
        'id', 'name', 'username', 'last_name', 'first_name', 'middle_name',
        'suffix', 'position', 'profile_image', 'email', 'is_active', 'is_approved', 'role', 'created_at'
    ]));
});

Route::post('/api/user-accounts', function (Request $request) {
    if (!Auth::check() || auth()->user()->role !== 'admin') {
        return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
    }
    
    $request->validate([
        'username' => 'required|string|max:255|unique:users,username',
        'last_name' => 'required|string|max:255',
        'first_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
        'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
    ]);

    $fullName = trim($request->first_name . ' ' . ($request->middle_name ? $request->middle_name . ' ' : '') . $request->last_name . ($request->suffix ? ' ' . $request->suffix : ''));

    $data = [
        'name' => $fullName,
        'username' => $request->username,
        'last_name' => $request->last_name,
        'first_name' => $request->first_name,
        'middle_name' => $request->middle_name,
        'suffix' => $request->suffix,
        'position' => $request->position,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role ?? 'user',
        'is_active' => $request->has('is_active') ? ($request->is_active == '1') : true,
        'is_approved' => $request->has('is_approved') ? ($request->is_approved == '1') : true,
    ];

    if ($request->hasFile('profile_image')) {
        $path = $request->file('profile_image')->store('profile-images', 'public');
        $data['profile_image'] = $path;
    }
    
    $user = User::create($data);
    AuditLog::logAction('Created user account', $user);
    return response()->json(['success' => true, 'message' => 'Account created successfully.', 'user' => $user]);
});

// Self-Registration API
Route::post('/api/register', function (Request $request) {
    $request->validate([
        'username' => 'required|string|max:255|unique:users,username',
        'last_name' => 'required|string|max:255',
        'first_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|string',
        'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
    ]);

    $fullName = trim($request->first_name . ' ' . ($request->middle_name ? $request->middle_name . ' ' : '') . $request->last_name . ($request->suffix ? ' ' . $request->suffix : ''));

    $data = [
        'name' => $fullName,
        'username' => $request->username,
        'last_name' => $request->last_name,
        'first_name' => $request->first_name,
        'middle_name' => $request->middle_name,
        'suffix' => $request->suffix,
        'position' => $request->position,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'is_active' => true,
        'is_approved' => false, // Requires admin approval
    ];

    if ($request->hasFile('profile_image')) {
        $path = $request->file('profile_image')->store('profile-images', 'public');
        $data['profile_image'] = $path;
    }

    $user = User::create($data);
    AuditLog::logAction('Self-registered account (Pending Approval)', $user);
    return response()->json(['success' => true, 'message' => 'Registration submitted. Please wait for admin approval.']);
});

Route::put('/api/user-accounts/{id}/toggle', function ($id) {
    if (!Auth::check() || auth()->user()->role !== 'admin') {
        return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
    }
    $user = User::findOrFail($id);
    $user->is_active = !$user->is_active;
    $user->save();
    AuditLog::logAction($user->is_active ? 'Activated user account' : 'Deactivated user account', $user);
    return response()->json(['success' => true, 'message' => $user->is_active ? 'Account activated.' : 'Account deactivated.', 'user' => $user]);
});

Route::put('/api/user-accounts/{id}/approve', function ($id) {
    if (!Auth::check() || auth()->user()->role !== 'admin') {
        return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
    }
    $user = User::findOrFail($id);
    $user->is_approved = true;
    $user->save();
    AuditLog::logAction('Approved user account', $user);
    return response()->json(['success' => true, 'message' => 'Account approved.', 'user' => $user]);
});

Route::delete('/api/user-accounts/{id}', function ($id) {
    if (!Auth::check() || auth()->user()->role !== 'admin') {
        return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
    }
    $user = User::findOrFail($id);
    
    // Optional: Delete profile image if exists
    if ($user->profile_image && \Storage::disk('public')->exists($user->profile_image)) {
        \Storage::disk('public')->delete($user->profile_image);
    }
    
    AuditLog::logAction('Deleted user account (Rejected request)', $user);
    $user->delete();
    return response()->json(['success' => true, 'message' => 'Account deleted.']);
});

Route::post('/api/user-accounts/{id}/update', function (Request $request, $id) {
    if (!Auth::check() || auth()->user()->role !== 'admin') {
        return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
    }
    $user = User::findOrFail($id);
    $request->validate([
        'username' => 'required|string|max:255|unique:users,username,' . $id,
        'last_name' => 'required|string|max:255',
        'first_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
    ]);

    $fullName = trim($request->first_name . ' ' . ($request->middle_name ? $request->middle_name . ' ' : '') . $request->last_name . ($request->suffix ? ' ' . $request->suffix : ''));

    $user->name = $fullName;
    $user->username = $request->username;
    $user->last_name = $request->last_name;
    $user->first_name = $request->first_name;
    $user->middle_name = $request->middle_name;
    $user->suffix = $request->suffix;
    $user->position = $request->position;
    $user->email = $request->email;
    $user->role = $request->role ?? 'user';
    $user->is_active = $request->has('is_active') ? ($request->is_active == '1') : $user->is_active;
    $user->is_approved = $request->has('is_approved') ? ($request->is_approved == '1') : $user->is_approved;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    if ($request->hasFile('profile_image')) {
        if ($user->profile_image && \Storage::disk('public')->exists($user->profile_image)) {
            \Storage::disk('public')->delete($user->profile_image);
        }
        $path = $request->file('profile_image')->store('profile-images', 'public');
        $user->profile_image = $path;
    }

    $user->save();
    AuditLog::logAction('Updated user account', $user);
    return response()->json(['success' => true, 'message' => 'Account updated successfully.', 'user' => $user]);
});

Route::post('/api/profile/update', function (Request $request) {
    if (!auth()->check()) {
        return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
    }
    
    $user = auth()->user();
    $id = $user->id;
    
    try {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|string|min:8|confirmed',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'profile_offset_x' => 'nullable|numeric',
            'profile_offset_y' => 'nullable|numeric',
            'profile_zoom' => 'nullable|numeric',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:4096',
            'cover_offset_x' => 'nullable|numeric',
            'cover_offset_y' => 'nullable|numeric',
            'cover_zoom' => 'nullable|numeric',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'errors' => $e->errors(),
        ], 422);
    }

    $fullName = trim($request->first_name . ' ' . ($request->middle_name ? $request->middle_name . ' ' : '') . $request->last_name . ($request->suffix ? ' ' . $request->suffix : ''));

    $user->name = $fullName;
    $user->username = $request->username;
    $user->last_name = $request->last_name;
    $user->first_name = $request->first_name;
    $user->middle_name = $request->middle_name;
    $user->suffix = $request->suffix;
    $user->position = $request->position;
    $user->email = $request->email;

    if ($request->filled('password')) {
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'The provided current password does not match our records.',
                'errors' => ['current_password' => ['Incorrect current password.']]
            ], 422);
        }
        $user->password = Hash::make($request->password);
    }

    // Repositioning data
    if ($request->has('profile_offset_x')) $user->profile_offset_x = $request->profile_offset_x;
    if ($request->has('profile_offset_y')) $user->profile_offset_y = $request->profile_offset_y;
    if ($request->has('profile_zoom')) $user->profile_zoom = $request->profile_zoom;
    if ($request->has('cover_offset_x')) $user->cover_offset_x = $request->cover_offset_x;
    if ($request->has('cover_offset_y')) $user->cover_offset_y = $request->cover_offset_y;
    if ($request->has('cover_zoom')) $user->cover_zoom = $request->cover_zoom;

    if ($request->hasFile('profile_image')) {
        if ($user->profile_image && \Storage::disk('public')->exists($user->profile_image)) {
            \Storage::disk('public')->delete($user->profile_image);
        }
        $path = $request->file('profile_image')->store('profile-images', 'public');
        $user->profile_image = $path;
    }

    if ($request->hasFile('cover_image')) {
        if ($user->cover_image && \Storage::disk('public')->exists($user->cover_image)) {
            \Storage::disk('public')->delete($user->cover_image);
        }
        $path = $request->file('cover_image')->store('cover-images', 'public');
        $user->cover_image = $path;
    }

    $user->save();
    AuditLog::logAction('Updated own profile', $user);
    return response()->json(['success' => true, 'message' => 'Profile updated successfully.', 'user' => $user]);
});

Route::post('/api/profile/verify-password', function (Request $request) {
    if (!session('authenticated') || !session('user_id')) {
        return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
    }
    $user = User::findOrFail(session('user_id'));
    if ($request->password && Hash::check($request->password, $user->password)) {
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false, 'message' => 'Incorrect password.']);
});

/*
Route::delete('/api/user-accounts/{id}', function ($id) {
    if (!Auth::check() || auth()->user()->role !== 'admin') {
        return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
    }
    $user = User::findOrFail($id);
    if ($user->profile_image && \Storage::disk('public')->exists($user->profile_image)) {
        \Storage::disk('public')->delete($user->profile_image);
    }
    $user->delete();
    AuditLog::logAction('Deleted user account', $user);
    return response()->json(['success' => true, 'message' => 'Account deleted successfully.']);
});
*/

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
});

Route::post('/login', function (Request $request) {
    try {
        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', $email)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Invalid email or password.'], 401);
        }
        
        if (!$user->is_active) {
            return response()->json(['success' => false, 'message' => 'Your account has been deactivated. Please contact an administrator.'], 403);
        }
        if (!$user->is_approved) {
            return response()->json(['success' => false, 'message' => 'Your account is pending approval. Please contact an administrator.'], 403);
        }
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        session([
            'otp_code' => $otp,
            'otp_email' => $email,
            'otp_user_id' => $user->id,
            'otp_user_name' => $user->name,
            'otp_expires' => now()->addMinutes(5),
        ]);
        $emailSent = false;
        try {
            Mail::send('emails.otp', ['otp' => $otp, 'userName' => $user->name], function ($message) use ($email) {
                $message->to($email)->subject('Login OTP - DepEd Manager');
            });
            $emailSent = true;
        } catch (\Exception $e) {
            Log::warning('OTP email failed: ' . $e->getMessage());
        }
        return response()->json(['success' => true, 'otp_code' => $otp, 'user_name' => $user->name]);
    } catch (\Throwable $e) {
        return response()->json(['success' => false, 'message' => 'Server error.'], 500);
    }
});

Route::post('/verify-otp', function (Request $request) {
    $otp = $request->input('otp');
    if ($otp !== session('otp_code') || now()->greaterThan(session('otp_expires'))) {
        return response()->json(['success' => false, 'message' => 'Invalid or expired OTP.'], 400);
    }
    $user = User::find(session('otp_user_id'));
    if (!$user || !$user->is_active) {
        return response()->json(['success' => false, 'message' => 'Your account has been deactivated. Please contact an administrator.'], 403);
    }
    if (!$user->is_approved) {
        return response()->json(['success' => false, 'message' => 'Your account is pending approval. Please contact an administrator.'], 403);
    }
    Auth::login($user);
    session(['authenticated' => true, 'user_id' => $user->id]);
    session()->forget(['otp_code', 'otp_expires', 'otp_user_id']);
    
    // Log login action
    AuditLog::logAction('Logged in', $user);

    return response()->json(['success' => true, 'redirect' => $user->role === 'admin' ? '/admin/dashboard' : '/user/dashboard']);
});

Route::post('/resend-otp', function (Request $request) {
    $email = session('otp_email');
    if (!$email) return response()->json(['success' => false], 400);
    $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    session(['otp_code' => $otp, 'otp_expires' => now()->addMinutes(5)]);
    
    try {
        Mail::html('Verification code: ' . $otp, function ($message) use ($email) {
            $message->to($email)->subject('Login OTP (Resend)');
        });
    } catch (\Exception $e) {
        Log::warning('Resend OTP email failed: ' . $e->getMessage());
    }

    return response()->json(['success' => true, 'otp_code' => $otp]);
});

Route::post('/forgot-password', function (Request $request) {
    $email = $request->input('email');
    $user = User::where('email', $email)->first();
    if (!$user) return response()->json(['success' => true, 'message' => 'Email sent if exists.']);
    
    $token = Str::random(64);
    \DB::table('password_reset_tokens')->updateOrInsert(
        ['email' => $email],
        ['token' => Hash::make($token), 'created_at' => now()]
    );

    $resetUrl = url('/reset-password/' . $token . '?email=' . urlencode($email));

    try {
        Mail::send('emails.password-reset', ['resetUrl' => $resetUrl], function ($message) use ($email) {
            $message->to($email)->subject('Password Reset Link - DepEd Manager');
        });
    } catch (\Exception $e) {
        Log::error('Forgot password email failed: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Failed to send email. Please check configuration.']);
    }

    return response()->json(['success' => true, 'message' => 'Reset link sent.']);
});

Route::get('/reset-password/{token}', function (string $token, Request $request) {
    return view('login', ['resetToken' => $token, 'resetEmail' => $request->query('email', '')]);
});

Route::post('/reset-password', function (Request $request) {
    $user = User::where('email', $request->email)->first();
    if (!$user) return response()->json(['success' => false], 400);
    $user->password = Hash::make($request->password);
    $user->save();
    return response()->json(['success' => true, 'redirect' => '/']);
});
