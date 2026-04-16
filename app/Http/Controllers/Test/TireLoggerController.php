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


    public function test()
    {
        preg_match_all(
                '/\b(\d{1,2}[\/\-]\d{1,2}[\/\-]\d{2,4}|\d{1,2}[\/\-]\d{1,2})\b/',
                "3/09 
                INVOICE ISSUE:
        PPV_PO PRICE 1.32 / INV. PRICE 2.67

        ACTION TO BE TAKEN:
        CONTACT BUYER TO CONFIRM PRICE",
                $matches
            );
            // $date = Carbon::createFromDate('n/j/Y',$matches[0][0]) || Carbon::createFromDate('n/j',$matches[0][0]);

        $format = $this->detectDateFormat($matches[0][0]);

        dd($format);
        

    }

    function detectDateFormat($date)
    {
        $parts = preg_split('/[\/\-]/', $date);

        if (count($parts) === 2) {
            return 'm/d';
        }

        if (count($parts) === 3) {
            $first = (int) $parts[0];
            $second = (int) $parts[1];
            $third = (int) $parts[2];

            // year is usually 4 digits or > 31
            if ($third > 31) {
                return 'm/d/Y or d/m/Y';
            }

            if ($parts[0] > 12) {
                return 'd/m/Y';
            }

            return 'm/d/Y';
        }

        return 'unknown';
    }
}

// update tire_positioning set front_left_wheel_id = null,front_right_wheel_id = null,rear_right_outer_wheel_id = null,odometer_reading = null,hour_meter_reading = null;
