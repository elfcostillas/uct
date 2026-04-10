<?php

namespace App\Repositories\MasterFiles;

use Illuminate\Support\Facades\DB;

class EmployeeRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
       
    }

    public function getAllEmployees()
    {
        return DB::table('employees')->get();
    }
}
