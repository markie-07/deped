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
            $data = [
                'action' => $action,
                'user' => [
                    'id' => $user->id,
                    'last_name' => $user->last_name,
                    'first_name' => $user->first_name,
                    'middle_name' => $user->middle_name,
                    'suffix' => $user->suffix,
                    'avatar' => $user->profile_image, // Mapped from profile_image
                    'email' => $user->email,
                    'email_searchable' => $user->email_hash, // Mapped from email_hash
                    'email_verified_at' => $user->email_verified_at ? $user->email_verified_at->toDateTimeString() : null,
                    'is_active' => $user->is_active,
                    'role' => $user->role,
                    'assign' => $user->assigned, // Mapped from assigned
                ]
            ];

            // If deleted, we might only need the ID
            if ($action === 'deleted') {
                $data['user'] = ['id' => $user->id];
            }

            $response = Http::withHeaders([
                'X-Sync-Source' => 'deped-system',
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->post($url, $data);

            if (!$response->successful()) {
                Log::error('External Sync Failed. Status: ' . $response->status() . ' Body: ' . $response->body());
            } else {
                Log::info('External Sync Success for User ID: ' . $user->id);
            }

        } catch (\Exception $e) {
            Log::error('External Sync Connection Error: ' . $e->getMessage());
        }
    }
}
