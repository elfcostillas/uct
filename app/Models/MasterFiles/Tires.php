<?php

namespace App\Models\MasterFiles;

use App\Observers\TireObserver;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

// #[ObservedBy(TireObserver::class)]
class Tires extends Model
{
    use LogsActivity;

    protected $table = 'tires';

    protected $primaryKey = 'id';

    protected $fillable = [
        'locations_id',
        'tire_brand_id',
        'purchase_date',
        'supplier_code',
        'tire_type_id',
        'tire_size',
        'vehicle_type_id',
        'vehicle_id',
        'remarks',
        'encoded_on',
        'encoded_by',
        'branding_no',
        'tire_status_id'
    ];


    public $timestamps = false;

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'locations_id');
    }

    public function brand()
    {
        return $this->belongsTo(TireBrand::class, 'tire_brand_id');
    }

    public function tireType()
    {
        return $this->belongsTo(TireTypes::class, 'tire_type_id');
    }
    
    public function tireStatus()
    {
        return $this->belongsTo(TireStatus::class, 'tire_status_id');
    }       
}
