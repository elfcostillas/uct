<?php

namespace App\Repositories\TireManagement;

use App\Models\MasterFiles\Tires;
use App\Models\TireManagement\WheelPosition\VehicleWheelPosition;

class TireOptionsRepository
{
    /**
     * Create a new class instance.
     */

    protected $model;

    public function __construct()
    {
        $this->model = new VehicleWheelPosition();
    }

    public function getAvailableTires($vehicle_id = null,$veh_type = null)
    {
        $installedTires = $this->getInstalledTires($vehicle_id);

        // return Tires::whereNotIn('id', $intstalledTires)->get();

        return Tires::whereNotIn('id', $installedTires)
            ->when($veh_type !== null, function ($query) use ($veh_type) {
                $query->where('vehicle_type_id', $veh_type);
            })->get();
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

    public function getInstalledTires($vehicleId = null)
    {
        $query = VehicleWheelPosition::select('spare_wheel_id as wheel_id')
            ->whereNotNull('spare_wheel_id');

        if ($vehicleId !== null) {
            $query->where('vehicle_id','!=', $vehicleId);
        }

        return $query->unionAll(
                VehicleWheelPosition::select('front_wheel_id as wheel_id')
                    ->whereNotNull('front_wheel_id')->where('vehicle_id','!=', $vehicleId)
            )
            ->unionAll(
                VehicleWheelPosition::select('rear_wheel_id as wheel_id')
                    ->whereNotNull('rear_wheel_id')->where('vehicle_id','!=', $vehicleId)
            )
            ->unionAll(
                VehicleWheelPosition::select('front_left_wheel_id as wheel_id')
                    ->whereNotNull('front_left_wheel_id')->where('vehicle_id','!=', $vehicleId)
            )
            ->unionAll(
                VehicleWheelPosition::select('front_right_wheel_id as wheel_id')
                    ->whereNotNull('front_right_wheel_id')->where('vehicle_id','!=', $vehicleId)
            )
            ->unionAll(
                VehicleWheelPosition::select('rear_left_wheel_id as wheel_id')
                    ->whereNotNull('rear_left_wheel_id')->where('vehicle_id','!=', $vehicleId)
            )
            ->unionAll(
                VehicleWheelPosition::select('rear_right_wheel_id as wheel_id')
                    ->whereNotNull('rear_right_wheel_id')->where('vehicle_id','!=', $vehicleId)
            )
            ->unionAll(
                VehicleWheelPosition::select('front2_left_wheel_id as wheel_id')
                    ->whereNotNull('front2_left_wheel_id')->where('vehicle_id','!=', $vehicleId)
            )
            ->unionAll(
                VehicleWheelPosition::select('front2_right_wheel_id as wheel_id')
                    ->whereNotNull('front2_right_wheel_id')->where('vehicle_id','!=', $vehicleId)
            )
            ->unionAll(
                VehicleWheelPosition::select('center_left_inner_wheel_id as wheel_id')
                    ->whereNotNull('center_left_inner_wheel_id')->where('vehicle_id','!=', $vehicleId)
            )
            ->unionAll(
                VehicleWheelPosition::select('center_right_inner_wheel_id as wheel_id')
                    ->whereNotNull('center_right_inner_wheel_id')->where('vehicle_id','!=', $vehicleId)
            )
            ->unionAll(
                VehicleWheelPosition::select('center_left_outer_wheel_id as wheel_id')
                    ->whereNotNull('center_left_outer_wheel_id')->where('vehicle_id','!=', $vehicleId)
            )
            ->unionAll(
                VehicleWheelPosition::select('center_right_outer_wheel_id as wheel_id')
                    ->whereNotNull('center_right_outer_wheel_id')->where('vehicle_id','!=', $vehicleId)
            )
            ->unionAll(
                VehicleWheelPosition::select('rear_left_inner_wheel_id as wheel_id')
                    ->whereNotNull('rear_left_inner_wheel_id')->where('vehicle_id','!=', $vehicleId)
            )
            ->unionAll(
                VehicleWheelPosition::select('rear_right_inner_wheel_id as wheel_id')
                    ->whereNotNull('rear_right_inner_wheel_id')->where('vehicle_id','!=', $vehicleId)
            )
            ->unionAll(
                VehicleWheelPosition::select('rear_left_outer_wheel_id as wheel_id')
                    ->whereNotNull('rear_left_outer_wheel_id')->where('vehicle_id','!=', $vehicleId)
            )
            ->unionAll(
                VehicleWheelPosition::select('rear_right_outer_wheel_id as wheel_id')
                    ->whereNotNull('rear_right_outer_wheel_id')->where('vehicle_id','!=', $vehicleId)
            )
            ->pluck('wheel_id');
    }
}
