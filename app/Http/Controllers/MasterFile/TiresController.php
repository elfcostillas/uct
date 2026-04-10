<?php

namespace App\Http\Controllers\MasterFile;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterFiles\Tires\CreateRequest;
use App\Http\Requests\MasterFiles\Tires\UpdateRequest;
use App\Repositories\MasterFiles\CommonRepository;
use App\Service\MasterFile\TireService;
use App\Service\MasterFile\VehicleService;
use App\Service\MasterFile\VehicleTypeService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class TiresController extends Controller
{
      public function __construct(protected VehicleService $vehicleService,protected VehicleTypeService $vehicleTypeService,protected TireService $tireService, protected CommonRepository $commonRepository)
      {

      }

    public function index(Request $request)
    {
        $type = ($request->input('search')) ? $request->input('search') : 0;
        // $vehicleTypes = $this->commonRepository->getVehicleTypes();
        $vehicleTypes = $this->vehicleTypeService->getAllVehicleTypes();
       
        $tires = $this->tireService->getAllTires($type);

        $locations = $this->commonRepository->getLocations();
        $tireTypes = $this->commonRepository->getTireTypes();
        $tireStatus = $this->commonRepository->getTireStatus();  
        $tireBrands = $this->commonRepository->getTireBrands();

        // return response()->json([
        //     'tires' => $tires
        // ]);

        return Inertia::render('MyApp/MasterFiles/Tires/MainPage',[
            'vehicleTypes' => $vehicleTypes,
            'tires' => $tires,
            'locations' => $locations,
            'tireTypes' => $tireTypes,
            'tireStatus' => $tireStatus,
            'tireBrands' => $tireBrands
        ]);
    }

    public function create(CreateRequest $request)
    {
        $validated = $request->validated();

        $result = $this->tireService->create($validated);

        if ($result instanceof \Throwable) {
            return response()->json([
                'message' => $result->getMessage()
            ], 500);
        }

        return response()->json(['message' => 'Tire created successfully']); 
    }
    
    public function update(UpdateRequest $request)
    {
       $validated = $request->validated();

        $result = $this->tireService->update($validated);

        if ($result instanceof \Throwable) {
            return response()->json([
                'message' => $result->getMessage()
            ], 500);
        }

        return response()->json(['message' => 'Tire updated successfully']); 
    }
}


/*
{
  "tires": [
    {
      "id": 1,
      "locations_id": 1,
      "tire_brand_id": 2,
      "purchase_date": "2026-03-23",
      "supplier_code": null,
      "tire_type": {
        "id": 1,
        "type_desc": "Tubed"
      },
      "tire_size": "70/90",
      "vehicle_type_id": 2,
      "vehicle_id": 3,
      "remarks": "test",
      "encoded_on": "2026-03-23 10:33:49",
      "encoded_by": 1,
      "branding_no": 2603,
      "vehicle_type": {
        "id": 2,
        "veh_code": "tm",
        "veh_description": "Transit Mixers"
      },
      "location": {
        "id": 1,
        "location_name": "RMC (North)",
        "location_address": "JLR Compound B. Suico Street Tingub Mandaue City, Cebu",
        "location_altername": "BPN (Mandaue)",
        "location_altername2": "North"
      },
      "brand": {
        "id": 2,
        "brand_name": "Michelin"
      }
    }
  ]
}
*/