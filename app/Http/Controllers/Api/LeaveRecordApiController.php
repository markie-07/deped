<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeaveRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LeaveRecordApiController extends Controller
{
    public function store(Request $request)
    {
        try {
            Log::info('Received Leave Record: ', $request->all());

            $userId = null;
            if ($request->encoder_id) {
                // Try matching by ID first
                $user = \App\Models\User::find($request->encoder_id);
                if ($user) {
                    $userId = $user->id;
                }
            }

            if (!$userId && $request->encoder_email) {
                // Fallback to email_hash if ID doesn't match or is missing
                $emailHash = hash('sha256', strtolower($request->encoder_email));
                $user = \App\Models\User::where('email_hash', $emailHash)->first();
                if ($user) {
                    $userId = $user->id;
                }
            }

            // Determine Forwarded and Assigned
            $assigned = $request->assigned ?? 'national';
            $forwarded = null; // Should be empty as requested

            // Automatic Batching
            $currentBatch = \App\Models\LeaveRecord::where('is_processed', false)->max('batch_id') 
                ?? (\App\Models\LeaveRecord::max('batch_id') ?? 0) + 1;

            // Check for duplicate to prevent "domodoble" (duplication)
            $existing = LeaveRecord::where('name', $request->full_name)
                ->where('type_of_leave', $request->leave_type)
                ->where('inclusive_dates', $request->inclusive_dates)
                ->where('is_processed', false)
                ->where('user_id', $userId)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => true,
                    'message' => 'Record already exists in registry',
                    'data'    => $existing
                ], 200);
            }

            $record = LeaveRecord::create([
                'name'              => $request->full_name,
                'forwarded'         => $forwarded,
                'position'          => $request->position,
                'school'            => $request->school,
                'type_of_leave'     => $request->leave_type,
                'inclusive_dates'   => $request->inclusive_dates,
                'remarks'           => $request->remarks,
                'date_of_action'    => $request->action_date,
                'deduction_remarks' => $request->deduction_remark,
                'incharge'          => $request->incharge,
                'assigned'          => $assigned,
                'is_processed'      => false,
                'batch_id'          => $currentBatch,
                'user_id'           => $userId,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Leave record created successfully',
                'data'    => $record
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error storing leave record: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to store leave record: ' . $e->getMessage()
            ], 500);
        }
    }
}
