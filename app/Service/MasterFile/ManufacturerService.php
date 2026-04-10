<?php

namespace App\Service\MasterFile;

use App\Repositories\MasterFiles\ManufacturerRepository;

class ManufacturerService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected ManufacturerRepository $manufacturerRepo)
    {
        //
    }

    public function getAllManufacturer()
    {
        return $this->manufacturerRepo->getAllManufacturer();
    }
}
