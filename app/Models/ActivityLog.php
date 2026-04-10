<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_log';
    protected $primaryKey = 'log_id';

    protected $fillable = [
    'log_timestamp',
    'log_module',
    'log_user',
    'log_action',
    'log_data',
    'record_id',

    ];  

    public $timestamps = false;
}