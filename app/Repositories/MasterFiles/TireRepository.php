<?php

namespace App\Repositories\MasterFiles;

class TireRepository
{
    /**
     * Create a new class instance.
     */
    protected $model;

    public function __construct()
    {
        $this->model = new \App\Models\MasterFiles\Tires();
    }

    public function getAllTires($type = 0)
    {
        return $this->model->with('vehicleType')
                ->with('location')
                ->with('brand')
                ->with('tireType')
                ->with('tireStatus')
                ->get();
        
    }
}
