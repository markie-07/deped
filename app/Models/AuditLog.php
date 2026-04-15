<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'details',
        'ip_address',
        'user_agent'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper to log an action.
     */
    public static function logAction($action, $model = null, $details = null)
    {
        // Don't log login/logout related actions as per policy
        $forbidden = ['Logged in', 'Logged out', 'Login'];
        foreach ($forbidden as $word) {
            if (stripos($action, $word) !== false) {
                return null;
            }
        }

        return self::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model_type' => $model ? class_basename($model) : null,
            'model_id' => $model ? $model->id : null,
            'details' => $details,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }
}

