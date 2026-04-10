<?php

namespace App\Repositories\MasterFiles;

use Illuminate\Support\Facades\DB;

class VehicleTypeRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAllVehicleTypes()
    {
        return DB::table('vehicle_types')
                ->select(DB::raw('id as value, veh_description as name'))
                ->get();
    }
}
