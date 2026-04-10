<?php

namespace App\Http\Controllers;

use App\Repositories\MasterFiles\VehicleRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function __construct(protected VehicleRepository $vehicleRepository)
    {
       
    }

    public function index()
    {
    
        // return inertia('MyApp/DataSource/ExcelUploader/MainPage');
        return inertia('Dashboard');
    }
}
