<?php

namespace App\Models\TireManagement;

use Illuminate\Database\Eloquent\Model;

class TireMovementLog extends Model
{
    protected $table = 'tire_movement_log';

    protected $primaryKey = 'id';

    protected $fillable = [
        'vehicle_id',
        'action',
        'odo',
        'hmr',
        'tire_id',
        'log_timestamp',
        'user_id',
        'tire_position',
    ];

    public $timestamps = false;
}
