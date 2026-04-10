<?php

namespace App\Service\TireManagement;

use App\Models\TireManagement\WheelPosition\VehicleWheelPosition;
use App\Repositories\TireManagement\TireOptionsRepository;
use App\Repositories\TireManagement\WheelPositionRepository;
use App\Service\BaseService;

class TirePositionService extends BaseService
{
    /**
     * Create a new class instance.
     */

    public $model;
    public $primaryKey;
    

    public function __construct(protected TireOptionsRepository $tireOptionsRepository, protected WheelPositionRepository $wheelPositionRepository)
    {
        $this->model = new VehicleWheelPosition();
        $this->primaryKey = $this->model->getKeyName();
    }

    public function getAvailableTires($vehicle_id = null,$veh_type = null)
    {
        return $this->tireOptionsRepository->getAvailableTires($vehicle_id,$veh_type);
    }

    public function getAllVehicles($type = 0)
    {
        return $this->wheelPositionRepository->getAllVehicles($type);
    }

    public function update($data)
    {
        // dd();
        $usedWheelIds = $this->tireOptionsRepository->getInstalledTires($data['vehicle_id'])->toArray();

        foreach($data as $key => $value){
            if(str_contains($key, 'wheel_id')){
                if (!empty($value) && in_array($value, $usedWheelIds)) {
                    return [
                        'success' => false,
                        'message' => 'Tire is already installed on another vehicle.'
                    ];
                }
            }
        }

        $result = parent::update($data);

        if ($result instanceof \Throwable) {
            return  [
                'success' => false,
                'message' => $result->getMessage()
            ];
        }

        return [
            'success' => true,
            'message' => 'Tire position updated successfully.'
        ];
        
    }
}