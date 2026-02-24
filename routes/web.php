<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\LeaveRecordController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/form', function () {
    return view('form');
});

Route::get('/employee', [EmployeeController::class, 'index']);

// Leave Record API routes
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


Route::get('/incharge', function () {
    return view('incharge');
});

Route::get('/school', function () {
    return view('school');
});

Route::get('/position', function () {
    return view('position');
});

Route::get('/types-of-leave', function () {
    return view('types-of-leave');
});

Route::get('/remarks', function () {
    return view('remarks');
});

// ═══════════════════════════════════════════
//  Logout
// ═══════════════════════════════════════════
Route::post('/logout', function (Request $request) {
    $request->session()->flush();
    return redirect('/');
});

// ═══════════════════════════════════════════
//  Login: Validate credentials & send OTP
// ═══════════════════════════════════════════
Route::post('/login', function (Request $request) {
    try {
        $email = $request->input('email');
        $password = $request->input('password');

        // Look up user in database
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.'
            ], 401);
        }

        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store OTP in session (expires in 5 minutes)
        session([
            'otp_code' => $otp,
            'otp_email' => $email,
            'otp_user_id' => $user->id,
            'otp_user_name' => $user->name,
            'otp_expires' => now()->addMinutes(5),
        ]);

        // Try to send OTP email (non-blocking — OTP shows on screen regardless)
        $emailSent = false;
        try {
            Mail::html('
                <div style="font-family: Inter, Arial, sans-serif; max-width: 480px; margin: 0 auto; padding: 32px; background: #ffffff;">
                    <div style="text-align: center; margin-bottom: 24px;">
                        <div style="display: inline-block; padding: 12px 20px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 14px;">
                            <span style="color: #fff; font-size: 18px; font-weight: 700;">DepEd Manager</span>
                        </div>
                    </div>
                    <h2 style="text-align: center; color: #1a1a2e; font-size: 22px; margin-bottom: 8px;">Verification Code</h2>
                    <p style="text-align: center; color: #8892a4; font-size: 14px; margin-bottom: 28px;">
                        Hello, <strong>' . htmlspecialchars($user->name) . '</strong>! Use the code below to complete your login.
                    </p>
                    <div style="text-align: center; margin-bottom: 28px;">
                        <div style="display: inline-block; padding: 16px 40px; background: #f0f2f8; border-radius: 14px; letter-spacing: 8px; font-size: 32px; font-weight: 800; color: #667eea;">
                            ' . $otp . '
                        </div>
                    </div>
                    <p style="text-align: center; color: #b0b9c8; font-size: 12px;">This code expires in 5 minutes.</p>
                    <hr style="border: none; border-top: 1px solid #e8ecf4; margin: 24px 0;">
                    <p style="text-align: center; color: #c0c7d6; font-size: 11px;">
                        &copy; ' . date('Y') . ' Department of Education. All rights reserved.
                    </p>
                </div>
            ', function ($message) use ($email) {
                $message->to($email)
                        ->subject('Your Login OTP - DepEd Manager');
            });
            $emailSent = true;
        } catch (\Exception $e) {
            Log::warning('OTP email failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => $emailSent ? 'OTP sent to your email.' : 'OTP generated. Check your verification screen.',
            'user_name' => $user->name,
            'otp_code' => $otp,
            'email_sent' => $emailSent,
        ]);
        
    } catch (\Throwable $e) {
        Log::error('Login error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
});

// ═══════════════════════════════════════════
//  Verify OTP
// ═══════════════════════════════════════════
Route::post('/verify-otp', function (Request $request) {
    $otp = $request->input('otp');

    $storedOtp = session('otp_code');
    $expiresAt = session('otp_expires');

    if (!$storedOtp || !$expiresAt) {
        return response()->json([
            'success' => false,
            'message' => 'No OTP found. Please login again.'
        ], 400);
    }

    if (now()->greaterThan($expiresAt)) {
        session()->forget(['otp_code', 'otp_email', 'otp_user_id', 'otp_user_name', 'otp_expires']);
        return response()->json([
            'success' => false,
            'message' => 'OTP has expired. Please login again.'
        ], 400);
    }

    if ($otp !== $storedOtp) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid OTP code. Please try again.'
        ], 400);
    }

    // OTP verified! Clear OTP data and set authenticated session
    session()->forget(['otp_code', 'otp_email', 'otp_expires']);
    session(['authenticated' => true, 'user_id' => session('otp_user_id')]);
    session()->forget(['otp_user_id', 'otp_user_name']);

    return response()->json([
        'success' => true,
        'message' => 'OTP verified! Redirecting...',
        'redirect' => '/dashboard'
    ]);
});

// ═══════════════════════════════════════════
//  Resend OTP
// ═══════════════════════════════════════════
Route::post('/resend-otp', function (Request $request) {
    $email = session('otp_email');
    $userName = session('otp_user_name', 'User');

    if (!$email) {
        return response()->json([
            'success' => false,
            'message' => 'Session expired. Please login again.'
        ], 400);
    }

    // Generate new OTP
    $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

    session([
        'otp_code' => $otp,
        'otp_expires' => now()->addMinutes(5),
    ]);

    $emailSent = false;
    try {
        Mail::html('
            <div style="font-family: Inter, Arial, sans-serif; max-width: 480px; margin: 0 auto; padding: 32px; background: #ffffff;">
                <div style="text-align: center; margin-bottom: 24px;">
                    <div style="display: inline-block; padding: 12px 20px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 14px;">
                        <span style="color: #fff; font-size: 18px; font-weight: 700;">DepEd Manager</span>
                    </div>
                </div>
                <h2 style="text-align: center; color: #1a1a2e; font-size: 22px; margin-bottom: 8px;">New Verification Code</h2>
                <p style="text-align: center; color: #8892a4; font-size: 14px; margin-bottom: 28px;">
                    Hello, <strong>' . htmlspecialchars($userName) . '</strong>! Here is your new verification code.
                </p>
                <div style="text-align: center; margin-bottom: 28px;">
                    <div style="display: inline-block; padding: 16px 40px; background: #f0f2f8; border-radius: 14px; letter-spacing: 8px; font-size: 32px; font-weight: 800; color: #667eea;">
                        ' . $otp . '
                    </div>
                </div>
                <p style="text-align: center; color: #b0b9c8; font-size: 12px;">This code expires in 5 minutes.</p>
            </div>
        ', function ($message) use ($email) {
            $message->to($email)
                    ->subject('Your New OTP - DepEd Manager');
        });
        $emailSent = true;
    } catch (\Exception $e) {
        Log::warning('Resend OTP email failed: ' . $e->getMessage());
    }

    return response()->json([
        'success' => true,
        'message' => $emailSent ? 'New OTP sent to your email.' : 'New OTP generated.',
        'otp_code' => $otp,
        'email_sent' => $emailSent,
    ]);
});

// ═══════════════════════════════════════════
//  Forgot Password: Send Reset Link
// ═══════════════════════════════════════════
Route::post('/forgot-password', function (Request $request) {
    try {
        $email = $request->input('email');

        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter your email address.'
            ], 400);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            // Don't reveal if email exists — always show success
            return response()->json([
                'success' => true,
                'message' => 'If that email exists, a reset link has been sent.'
            ]);
        }

        // Generate a unique token
        $token = Str::random(64);

        // Store in password_reset_tokens table
        \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => Hash::make($token), 'created_at' => now()]
        );

        // Build the reset link
        $resetLink = url('/reset-password/' . $token . '?email=' . urlencode($email));

        // Send reset email
        $emailSent = false;
        try {
            Mail::html('
                <div style="font-family: Inter, Arial, sans-serif; max-width: 480px; margin: 0 auto; padding: 32px; background: #ffffff;">
                    <div style="text-align: center; margin-bottom: 24px;">
                        <div style="display: inline-block; padding: 12px 20px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 14px;">
                            <span style="color: #fff; font-size: 18px; font-weight: 700;">DepEd Manager</span>
                        </div>
                    </div>
                    <h2 style="text-align: center; color: #1a1a2e; font-size: 22px; margin-bottom: 8px;">Reset Your Password</h2>
                    <p style="text-align: center; color: #8892a4; font-size: 14px; margin-bottom: 28px;">
                        Hello, <strong>' . htmlspecialchars($user->name) . '</strong>! Click the button below to reset your password.
                    </p>
                    <div style="text-align: center; margin-bottom: 28px;">
                        <a href="' . $resetLink . '" style="display: inline-block; padding: 14px 40px; background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; text-decoration: none; border-radius: 12px; font-size: 16px; font-weight: 600;">
                            Reset Password
                        </a>
                    </div>
                    <p style="text-align: center; color: #b0b9c8; font-size: 12px; margin-bottom: 12px;">This link expires in 60 minutes.</p>
                    <p style="text-align: center; color: #b0b9c8; font-size: 12px;">If you didn\'t request this, just ignore this email.</p>
                    <hr style="border: none; border-top: 1px solid #e8ecf4; margin: 24px 0;">
                    <p style="text-align: center; color: #c0c7d6; font-size: 11px;">
                        &copy; ' . date('Y') . ' Department of Education. All rights reserved.
                    </p>
                </div>
            ', function ($message) use ($email) {
                $message->to($email)
                        ->subject('Reset Your Password - DepEd Manager');
            });
            $emailSent = true;
        } catch (\Exception $e) {
            Log::warning('Password reset email failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => $emailSent,
            'message' => $emailSent
                ? 'Password reset link sent to your email!'
                : 'Failed to send email. Please check your email configuration.',
        ]);

    } catch (\Throwable $e) {
        Log::error('Forgot password error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
});

// ═══════════════════════════════════════════
//  Reset Password: Show Form
// ═══════════════════════════════════════════
Route::get('/reset-password/{token}', function (string $token, Request $request) {
    return view('login', [
        'resetToken' => $token,
        'resetEmail' => $request->query('email', '')
    ]);
});

// ═══════════════════════════════════════════
//  Reset Password: Process
// ═══════════════════════════════════════════
Route::post('/reset-password', function (Request $request) {
    try {
        $email = $request->input('email');
        $token = $request->input('token');
        $password = $request->input('password');
        $passwordConfirm = $request->input('password_confirmation');

        if (!$email || !$token || !$password) {
            return response()->json([
                'success' => false,
                'message' => 'All fields are required.'
            ], 400);
        }

        if (strlen($password) < 8) {
            return response()->json([
                'success' => false,
                'message' => 'Password must be at least 8 characters.'
            ], 400);
        }

        if ($password !== $passwordConfirm) {
            return response()->json([
                'success' => false,
                'message' => 'Passwords do not match.'
            ], 400);
        }

        // Find the reset record
        $record = \DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired reset link.'
            ], 400);
        }

        // Check token
        if (!Hash::check($token, $record->token)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid reset token.'
            ], 400);
        }

        // Check expiry (60 minutes)
        if (now()->diffInMinutes($record->created_at) > 60) {
            \DB::table('password_reset_tokens')->where('email', $email)->delete();
            return response()->json([
                'success' => false,
                'message' => 'Reset link has expired. Please request a new one.'
            ], 400);
        }

        // Update password
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 400);
        }

        $user->password = Hash::make($password);
        $user->save();

        // Delete the reset token
        \DB::table('password_reset_tokens')->where('email', $email)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully! You can now log in.',
            'redirect' => '/'
        ]);

    } catch (\Throwable $e) {
        Log::error('Reset password error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
});
