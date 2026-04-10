<?php

namespace App\Repositories\MasterFiles;

use Illuminate\Support\Facades\DB;

class ManufacturerRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAllManufacturer()
    {
        return DB::table('manufacturers')
                ->select(DB::raw('id as value, `name` as `name`'))
                ->get();
    }
}

