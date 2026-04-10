<?php

namespace App\Service\MasterFile;

use App\Models\MasterFiles\TireCount;
use App\Repositories\MasterFiles\VehicleRepository;
use App\Repositories\MasterFiles\VehicleTypeRepository;
use App\Service\BaseService;

class VehicleService extends BaseService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected VehicleRepository $vehicleRepo,protected VehicleTypeRepository $vehicleTypeRepo)
    {
        //
    }

    public function createVehicle($data)
    {
        try{
            $result = $this->vehicleRepo->create($data);

        }catch(\Exception $e){
            // Log the error or handle it as needed
            return $e;
        }   
        

        return $result;
    }

    public function updateVehicle($data)
    {
        try{
            $result = $this->vehicleRepo->update($data);

        }catch(\Exception $e){
            // Log the error or handle it as needed
            return $e;
        }   

        return $result;
    }
    
    public function getAllVehicles($type = 0)
    {
        return $this->vehicleRepo->getAllVehicles($type);
    }

    public function getTireCounts()
    {
        return TireCount::with('tirePositions')->get();
    }


}


/*
log_timestamp
log_module
log_user
log_action
log_data
record_id
*/