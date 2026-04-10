<?php

namespace App\Service\MasterFile;

use App\Repositories\MasterFiles\VehicleTypeRepository;

class VehicleTypeService
{
    public function __construct(protected VehicleTypeRepository $vehicleTypeRepo)
    {
        //
    }

    public function getAllVehicleTypes()
    {
        return $this->vehicleTypeRepo->getAllVehicleTypes();
    }
}
