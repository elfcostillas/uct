<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\TireManagement\WheelPosition\VehicleWheelPosition;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;

class TireLoggerController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        $vehicle = VehicleWheelPosition::find(3);

        // foreach($vehicle->getAttributes()  as $key => $value)
        // {
        //     echo $key .' : '. $value.'<br>';
        // }
        print_r($vehicle->getAttributes());
        echo '<hr>';
        try {
            $result = $vehicle->update(
            [
                'odometer_reading' => 100,
                'hour_meter_reading' => 100,
                'front_left_wheel_id' => 1,
                'front_right_wheel_id' => 2,

            ]
        );
        } catch (\Exception $e) {
            echo 'Update failed: ' . $e->getMessage();
        }
        
        $fresh = $vehicle->fresh();
        print_r($fresh->getAttributes());
        echo '<hr>';

         try {
            $result = $fresh->update(
            [
                'odometer_reading' => 101,
                'hour_meter_reading' => 101,
                'front_left_wheel_id' => 2,
                'front_right_wheel_id' => 1,

            ]
        );
        } catch (\Exception $e) {
            echo 'Update failed: ' . $e->getMessage();
        }
      
        // $vehicle->odometer_reading = 100;
        // $vehicle->hour_meter_reading = 110;

        // $vehicle->front_left_wheel_id  = 1;
        // $vehicle->front_right_wheel_id  = 2;

        // $vehicle->update();

        // $vehicle = VehicleWheelPosition::find(3);

        // foreach($vehicle->getAttributes()  as $key => $value)
        // {
        //     echo $key .' : '. $value.'<br>';
        // }
        // echo '===================================================================================2 <br>';

        $this->clear();
        
    }

    public function clear()
    {
        $vehicle = VehicleWheelPosition::find(3);

        $vehicle->odometer_reading = null;
        $vehicle->hour_meter_reading = null;

        $vehicle->front_left_wheel_id  = null;
        $vehicle->front_right_wheel_id  = null;

        $vehicle->save();
    }
}

// update tire_positioning set front_left_wheel_id = null,front_right_wheel_id = null,rear_right_outer_wheel_id = null,odometer_reading = null,hour_meter_reading = null;
