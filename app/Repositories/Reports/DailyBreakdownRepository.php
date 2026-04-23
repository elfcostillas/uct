<?php

namespace App\Repositories\Reports;

class DailyBreakdownRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getPOStatus($po_status,$query)
    {
        if(is_null($po_status)){
            return $query->select('po_status')
                ->distinct()
                ->get();
        }else{
            dd($query->toSql(),$query->getBindings());
            return $query->select('po_status')
                ->where('po_status',$po_status)
                ->distinct()
                ->get();
        }
    }
}
