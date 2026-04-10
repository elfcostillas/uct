<?php

namespace App\Http\Controllers\TireManagement;

use App\Http\Controllers\Controller;
use App\Repositories\TireManagement\TireOptionsRepository;
use App\Service\MasterFile\VehicleService;
use App\Service\MasterFile\VehicleTypeService;
use App\Service\TireManagement\TirePositionService;
// use App\TireManagement\WheelPositionService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InstallationController extends Controller
{
    public function __construct(
        protected VehicleTypeService $vehicleTypeService, 
        protected VehicleService $vehicleService,
        protected TireOptionsRepository $tireOptionsRepository,
        protected TirePositionService $tirePositionService
    )
    {

    }

    public function index(Request $request)
    {
        $type = ($request->input('search')) ? $request->input('search') : 0;
        $vehicle_id =  ($request->input('vehicle_id')) ? $request->input('vehicle_id') : null;
        $veh_type =  ($request->input('veh_type')) ? $request->input('veh_type') : null;


        $vehicleTypes = $this->vehicleTypeService->getAllVehicleTypes();
        $vehicles = $this->tirePositionService->getAllVehicles($type);
        $availableTires = $this->tirePositionService->getAvailableTires($vehicle_id,$veh_type);

        // $tireCounts = $this->vehicleService->getTireCounts();

        // return response()->json([
          
        //     'vehicles' => $vehicles
        // ]);

        return Inertia::render('MyApp/TireManagement/Installation/MainPage', [
            'vehicleTypes' => $vehicleTypes,
            'vehicles' => $vehicles,
            'availableTires' => $availableTires,
            // 'tireCounts' => $tireCounts
        ]);
    }

    public function update(Request $request)
    {
       
        $data = $request->all();

        $result = $this->tirePositionService->update($data);
       
        if(!$result['success']){
            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? 'An error occurred while updating tire position.'
            ],500);
        }

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'] ?? null
        ]);
    }
}
