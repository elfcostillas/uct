<?php

namespace App\Models\MasterFiles;

use App\Models\TireManagement\WheelPosition\VehicleWheelPosition;
use App\Observers\VehicleObserver;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

// #[ObservedBy(VehicleObserver::class)]
class Vehicles extends Model
{
    //
    use LogsActivity;
    
    protected $table = 'vehicles';
    protected $primaryKey = 'id';

    protected $fillable = [
        'encoded_on',
        'encoded_by',
        'veh_photo',
        'manufacturer_id',
        'model',
        'manufacture_year',
        'plate_no',
        'veh_identification_no',
        'veh_color',
        'assigned_to',
        'veh_type',
        'veh_code',
        'purchase_date',
        'supplier_id',
        'veh_remarks',
        'veh_status',
        'encoded_on',
        'encoded_by',
        'tire_count_id',
        'location_id',
        'mixer_drum_no',
        'engine_no'
    ];  
    
    public $timestamps = false;

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class, 'veh_type');
    }  
    
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
    }   

    public function assignedEmployee()
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }

    public function tiresCount()
    {
        return $this->belongsTo(TireCount::class, 'tire_count_id');
    }

    public function vehicleWheelPosition()
    {
        return $this->hasOne(VehicleWheelPosition::class, 'vehicle_id');
    }
}
