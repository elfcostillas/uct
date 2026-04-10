<?php

namespace App\Service\MasterFile;

use App\Models\MasterFiles\Tires;
use App\Repositories\MasterFiles\TireRepository;
use App\Service\BaseService;

class TireService extends BaseService
{
    /**
     * Create a new class instance.
     */
    public $model;
    public $primaryKey;
    
    public function __construct(protected TireRepository $tireRepository)
    {
        // $this->model = app()->make(Tires::class);
        $this->model = new Tires();
        $this->primaryKey = $this->model->getKeyName();
    }

    public function getAllTires($type = 0)
    {
        return $this->tireRepository->getAllTires($type);
    }

    // public function create($request)
    // {
    //     return Tires::create($request);
    // }

    // public function update($request)
    // {
    //     $record = Tires::find($request[$this->primaryKey]);

    //     if (!$record) {
    //         return null; // or throw an exception
    //     }

    //     $record->update($request);

    //     return $record;
    // }   
    

}
