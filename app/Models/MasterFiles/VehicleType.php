<?php

namespace App\Models\MasterFiles;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    protected $table = 'vehicle_types';

    protected $primaryKey = 'id';

    public function tires()
    {
        return $this->hasMany(Tires::class, 'vehicle_type_id');
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicles::class, 'veh_type');
    }
}
