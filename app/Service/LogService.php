<?php

namespace App\Service;

use App\Models\ActivityLog;

class LogService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function log($module, $action, $data = null, $recordId = null,$user)
    {
        ActivityLog::create([
            'log_timestamp' => now(),
            'log_module' => $module,
            'log_user' => (property_exists($user,'id')) ? $user->id : $user->id ,
            'log_action' => $action,
            'log_data' => json_encode($data),
            'record_id' => $recordId
        ]);
    }
}
