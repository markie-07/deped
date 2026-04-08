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
        // Map external field names to internal ones
        if ($request->has('avatar')) {
            $request->merge(['profile_image' => $request->avatar]);
        }
        if ($request->has('assign')) {
            $request->merge(['assigned' => $request->assign]);
        }
        if ($request->has('email_searchable')) {
            $request->merge(['email_hash' => $request->email_searchable]);
        }

        // --- DEBUG LOG ---
        \Illuminate\Support\Facades\Log::info('Incoming Data Payload:', $request->all());

        $validator = Validator::make($request->all(), [
            'id' => 'nullable|integer',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:20',
            'email' => 'required|email',
            'password' => 'nullable|string|min:8',
            'role' => 'nullable|string',
            'assigned' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'profile_image' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            \Illuminate\Support\Facades\Log::error('Validation Failed:', $validator->errors()->toArray());
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only([
            'first_name', 'last_name', 'middle_name', 'suffix', 
            'email', 'role', 'assigned', 'is_active', 'profile_image', 'email_hash'
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Check if user exists by ID or Email
        $user = null;
        if ($request->has('id')) {
            $user = User::find($request->id);
        }
        
        if (!$user) {
            // Find by email hash (since email is encrypted, we use the blind index)
            $emailHash = hash('sha256', strtolower($request->email));
            $user = User::where('email_hash', $emailHash)->first();
        }

        DB::beginTransaction();
        try {
            // Set flag to prevent outgoing sync for this incoming request
            SyncService::$isSyncing = true;

            if ($user) {
                // Update existing
                $user->update($data);
                $status = 'updated';
            } else {
                // Create new
                if ($request->has('id')) {
                    $data['id'] = $request->id;
                }
                // Default values if not provided
                $data['is_active'] = $data['is_active'] ?? true;
                $data['role'] = $data['role'] ?? 'user';
                
                if (!isset($data['password'])) {
                    $data['password'] = Hash::make('password123'); // Default password
                }

                $user = User::create($data);
                $status = 'created';
            }

            DB::commit();
            SyncService::$isSyncing = false;

            return response()->json([
                'message' => "User successfully {$status}",
                'user' => $user
            ], $status === 'created' ? 201 : 200);

        } catch (\Exception $e) {
            DB::rollBack();
            SyncService::$isSyncing = false;
            return response()->json(['error' => 'Failed to save user: ' . $e->getMessage()], 500);
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
