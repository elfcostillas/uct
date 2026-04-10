<?php

namespace App\Models\TireManagement\WheelPosition;

use App\Models\MasterFiles\Vehicles;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class VehicleWheelPosition extends Model
{
    use LogsActivity;

    protected $table = 'tire_positioning';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'vehicle_id',
        'spare_wheel_id',
        'front_wheel_id',
        'rear_wheel_id',
        'front_left_wheel_id',
        'front_right_wheel_id',
        'rear_left_wheel_id',
        'rear_right_wheel_id',
        'front2_left_wheel_id',
        'front2_right_wheel_id',
        'center_left_inner_wheel_id',
        'center_right_inner_wheel_id',
        'center_left_outer_wheel_id',
        'center_right_outer_wheel_id',
        'rear_left_inner_wheel_id',
        'rear_right_inner_wheel_id',
        'rear_left_outer_wheel_id',
        'rear_right_outer_wheel_id',
        'odometer_reading',
        'hour_meter_reading',
    ];

    public $timestamps = false;

    public function vehicle()
    {
        return $this->belongsTo(Vehicles::class, 'vehicle_id');
    }   
}
