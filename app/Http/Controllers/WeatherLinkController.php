<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\WeatherStation;


class WeatherLinkController extends Controller
{
    public function __construct()
    {

    }

    public function getData()
    {   
       
        $quarry_station = new WeatherStation();
        $quarry_station->set_stationId(231656);
        $quarry_station->getData();

        $plant_station = new WeatherStation();
        $plant_station->set_stationId(231657);
        $plant_station->getData();
       
       

    }
}
