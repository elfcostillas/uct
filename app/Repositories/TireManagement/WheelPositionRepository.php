<?php

namespace App\Repositories\TireManagement;

use App\Models\TireManagement\WheelPosition\VehicleWheelPosition;

class WheelPositionRepository
{
    
    protected $model;

    public function __construct()
    {
        $this->model = new VehicleWheelPosition();
    }

    public function getAllVehicles($type = 0)
    {

        $this->model = $this->model
        // ->with('vehicle')
        ->when($type != 0, function ($query) use ($type) {
            $query->whereHas('vehicle', function ($q) use ($type) {
                $q->where('veh_type', $type);
            });
        })
        ->with('vehicle.vehicleType')
        ->with('vehicle.manufacturer')
        ->with('vehicle.assignedEmployee')
        ->with('vehicle.tiresCount');

        return $this->model->get();

    }
}
