<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeaveRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LeaveRecordApiController extends Controller
{
    public function store(Request $request)
    {
        try {
            Log::info('Received Leave Record: ', $request->all());

            $userId = null;
            $applicantUser = null;
            $encoderUser = null;

            // 1. Look up the Applicant
            if ($request->applicant_email) {
                $emailHash = hash('sha256', strtolower($request->applicant_email));
                $applicantUser = User::where('email_hash', $emailHash)->first();
            }

            // 2. Look up the Encoder/Approver
            if ($request->encoder_email) {
                $emailHash = hash('sha256', strtolower($request->encoder_email));
                $encoderUser = User::where('email_hash', $emailHash)->first();
            }

            // DECISION LOGIC:
            // - If Applicant is a Staff (OJT/Coordinator), they see it.
            // - If Applicant is an Admin, they DON'T see it (falls to Encoder).
            if ($applicantUser && $applicantUser->role !== 'admin') {
                $userId = $applicantUser->id;
            } elseif ($encoderUser) {
                $userId = $encoderUser->id;
            } elseif ($applicantUser) {
                // Last resort fallback
                $userId = $applicantUser->id;
            }

            // Determine Forwarded and Assigned
            $assigned = $request->assigned ?? 'national';
            $forwarded = null; // Should be empty as requested

            // Automatic Batching
            $currentBatch = LeaveRecord::where('is_processed', false)->max('batch_id') 
                ?? (LeaveRecord::max('batch_id') ?? 0) + 1;


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

            // Automatic Batching
            $currentBatch = LeaveRecord::where('is_processed', false)->max('batch_id') 
                ?? (LeaveRecord::max('batch_id') ?? 0) + 1;

            $record = LeaveRecord::create([
                'name'              => $request->full_name ?? $request->name ?? 'Unknown Employee',
                'forwarded'         => $forwarded,
                'position'          => $request->position,
                'school'            => $request->school,
                'type_of_leave'     => $request->leave_type,
                'inclusive_dates'   => $request->inclusive_dates,
                'remarks'           => $request->remarks,
                'date_of_action'    => $request->action_date,
                'deduction_remarks' => $request->deduction_remark,
                'incharge'          => $request->incharge ?: 'System',
                'assigned'          => $assigned ?: 'national',
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
