<?php

namespace App\Repositories\MasterFiles;

use App\Models\MasterFiles\Vehicles;
use Illuminate\Support\Facades\DB;

class VehicleRepository
{
    /**
     * Create a new class instance.
     */

    // protected $table = 'vehicles';
    protected $model;

    public function __construct()
    {
        $this->model = new Vehicles();
    }

    public function getAllVehicles($type = 0)
    {
        // $query = DB::table('vehicles')
        //         ->leftJoin('employees', 'vehicles.assigned_to', '=', 'employees.emp_id')
        //         ->leftJoin('manufacturers', 'vehicles.manufacturer_id', '=', 'manufacturers.id')
        //         ->select(DB::raw("vehicles.*,employees.emp_id,employees.employee_name,employees.job_title,manufacturers.name as manufacturer_name"));

        // if ($type !== 0) {
        //     $query->where('vehicles.veh_type', $type);
        // }

        // return $query->get();   
        $this->model = $this->model->with('vehicleType')
                ->with('manufacturer')
                ->with('assignedEmployee')
                ->with('tiresCount');
        if($type !== 0){
            return $this->model->where('veh_type', $type)->get();
        }
        return $this->model->get();

    }

    public function create($data)
    {
        // return DB::table($this->table)->insertGetId($data);
        return Vehicles::create($data);
    }

    public function update($data)   
    {   
        
        /*
        $id = $data['id'];
        unset($data['id']);

        return DB::table($this->table)->where('id', $id)->update($data);
        */

        $id = $data['id'];
        unset($data['id']);

        $vehicle = Vehicles::find($id);

        if (!$vehicle) {
            throw new \Exception('Vehicle not found');
        }   

        return $vehicle->update($data);

    }

    public function dashboardCountByType()
    {
        return DB::table('vehicle_types')
            ->leftJoin('vehicles', 'vehicle_types.id', '=', 'vehicles.veh_type')
            ->select(DB::raw('vehicle_types.id ,UPPER(vehicle_types.veh_code) as veh_code'), DB::raw('count(vehicles.id) as no_of_units'))
            ->groupBy('vehicle_types.id')
            ->groupBy('vehicle_types.veh_code')
            ->get();
    }
}
/*
select vehicle_types.veh_code,count(vehicles.id) no_of_units
from vehicle_types left join vehicles on vehicle_types.id = vehicles.veh_type group by vehicle_types.id;

*/