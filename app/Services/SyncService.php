<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncService
{
    /**
     * Prevents infinite loops during synchronization.
     */
    public static $isSyncing = false;

    /**
     * Sync user data to an external system.
     *
     * @param \App\Models\User $user
     * @param string $action 'created', 'updated', or 'deleted'
     * @return void
     */
    public static function syncUser($user, $action = 'updated')
    {
        if (self::$isSyncing) {
            return;
        }

        $url = env('EXTERNAL_SYNC_URL');
        $token = env('EXTERNAL_SYNC_TOKEN');

        if (!$url) {
            return;
        }

        try {
            $profileImageBase64 = null;
            if ($user->profile_image) {
                $path = storage_path('app/public/' . $user->profile_image);
                Log::info('SyncService: Checking profile image at ' . $path);
                if (file_exists($path)) {
                    $profileImageBase64 = base64_encode(file_get_contents($path));
                    Log::info('SyncService: Profile image encoded. Length: ' . strlen($profileImageBase64));
                } else {
                    Log::warning('SyncService: Profile image file not found at ' . $path);
                }
            }

            $data = [
                'id' => $user->id,
                'lastname' => $user->last_name,
                'middle_name' => $user->middle_name,
                'first_name' => $user->first_name,
                'suffix' => $user->suffix,
                'email' => $user->email,
                'email_hash' => $user->email_hash, // maps to email_searchable on the other side
                'profile_image' => $user->profile_image, // relative path
                'profile_image_base64' => $profileImageBase64,
                'password' => $user->password,
                'role' => $user->role,
                'assigned' => $user->assigned, // maps to assign on the other side
                'is_active' => $user->is_active ? 1 : 0,
                'email_verified_at' => $user->email_verified_at ? $user->email_verified_at->toDateTimeString() : null,
                'action' => $action,
            ];
            
            Log::info('SyncService: Sending payload for User ID: ' . $user->id . ' has_image: ' . ($profileImageBase64 ? 'Yes' : 'No'));

            // If deleted, we might only need the ID and email_hash for identification
            if ($action === 'deleted') {
                $data = [
                    'id' => $user->id,
                    'email_hash' => $user->email_hash,
                    'action' => 'deleted'
                ];
            }

            $response = Http::withHeaders([
                'X-Sync-Source' => 'deped',
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->post($url, $data);

            if (!$response->successful()) {
                Log::error('External Sync Failed from deped to ' . $url . '. Status: ' . $response->status() . ' Body: ' . $response->body());
            } else {
                Log::info('External Sync Success for User ID: ' . $user->id . ' Action: ' . $action);
            }

        } catch (\Exception $e) {
            Log::error('External Sync Connection Error in deped: ' . $e->getMessage());
        }
    }
}
