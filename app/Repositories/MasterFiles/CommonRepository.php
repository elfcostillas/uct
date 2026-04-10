<?php

namespace App\Repositories\MasterFiles;

class CommonRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    
    public function getTireStatus()
    {
        return \App\Models\MasterFiles\TireStatus::all();
    }   

    public function getVehicleTypes()
    {
        return \App\Models\MasterFiles\VehicleType::all();
    }   

    public function getTireBrands()
    {
        return \App\Models\MasterFiles\TireBrand::all();
    }

    public function getLocations()
    {
        return \App\Models\MasterFiles\Location::all();
    }   

    public function getTireTypes()
    {
        return \App\Models\MasterFiles\TireTypes::all();
    }
}
