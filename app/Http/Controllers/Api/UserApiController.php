<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserApiController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        return response()->json(User::all());
    }

    /**
     * Store or Update a user received from an external system.
     */
    public function store(Request $request)
    {
        // ─── Mapping Incoming Standardized JSON to Internal Model ───
        // Determine role mapping
        $incomingRole = $request->role;
        $mappedRole = $incomingRole;
        if ($incomingRole === 'system_admin') {
            $mappedRole = 'admin';
        } elseif (in_array($incomingRole, ['coordinator', 'ojt'])) {
            $mappedRole = 'user';
        }

        // Handle Profile Image Sync
        $profileImagePath = $request->profile_image;
        if ($request->filled('profile_image_base64')) {
            $base64String = $request->profile_image_base64;
            
            // Remove base64 prefix if present (e.g., data:image/jpeg;base64,)
            if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
                $base64String = substr($base64String, strpos($base64String, ',') + 1);
            }
            
            $imageData = base64_decode($base64String);
            if ($imageData) {
                // Ensure the relative path is used. If not provided, generate one.
                $fileName = $request->profile_image ?: ('profile-images/' . uniqid() . '.jpg');
                
                // Make sure the filename is clean
                $fileName = ltrim($fileName, '/');
                
                \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $imageData);
                $profileImagePath = $fileName;
                \Illuminate\Support\Facades\Log::info("DepEd: Profile image synced: {$fileName}");
            }
        }

        $mappedData = [
            'last_name'         => $request->lastname,
            'first_name'        => $request->first_name,
            'middle_name'       => $request->middle_name,
            'suffix'            => $request->suffix,
            'email'             => $request->email,
            'email_hash'        => $request->email_hash,
            'profile_image'     => $profileImagePath,
            'role'              => $mappedRole,
            'assigned'          => $request->assigned,
            'is_active'         => $request->has('is_active') ? (bool)$request->is_active : true,
            'email_verified_at' => $request->email_verified_at,
        ];

        if ($request->filled('password')) {
            $mappedData['password'] = $request->password;
        }

        // --- DEBUG LOG ---
        \Illuminate\Support\Facades\Log::info('DepEd Incoming Sync Data:', $request->all());

        if ($request->action === 'deleted') {
            return $this->destroy($request->id);
        }

        $validator = Validator::make($mappedData, [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if user exists by ID or Email Hash
        $user = null;
        if ($request->has('id')) {
            $user = User::find($request->id);
        }
        
        if (!$user) {
            $emailHash = $mappedData['email_hash'] ?? hash('sha256', strtolower($mappedData['email']));
            $user = User::where('email_hash', $emailHash)->first();
        }

        DB::beginTransaction();
        try {
            // Set flag to prevent outgoing sync for this incoming request
            SyncService::$isSyncing = true;

            if ($user) {
                $user->update($mappedData);
                $status = 'updated';
            } else {
                if ($request->has('id')) {
                    $mappedData['id'] = $request->id;
                }
                $mappedData['is_approved'] = true;
                if (!isset($mappedData['password'])) {
                    $mappedData['password'] = Hash::make('password123');
                }
                $user = User::create($mappedData);
                $status = 'created';
            }

            DB::commit();
            SyncService::$isSyncing = false;

            return response()->json([
                'message' => "User successfully {$status} in DepEd",
                'user' => $user
            ], $status === 'created' ? 201 : 200);

        } catch (\Exception $e) {
            DB::rollBack();
            SyncService::$isSyncing = false;
            \Illuminate\Support\Facades\Log::error('Failed to save user in DepEd: ' . $e->getMessage(), [
                'exception' => $e,
                'data' => $mappedData
            ]);
            return response()->json(['error' => 'Failed to save user in DepEd: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified user.
     */
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json($user);
    }

    /**
     * Update the specified user (RESTful PUT/PATCH).
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // We can reuse the store logic or implement similar
        return $this->store($request->merge(['id' => $id]));
    }

    /**
     * Remove the specified user.
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Set flag to prevent outgoing sync if desired (or allow it if deletion should propagate)
        // Usually deletion SHOULD propagate unless specifically skipped.
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
