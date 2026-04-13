<?php

namespace App\Repositories\Reports;

use Illuminate\Support\Facades\DB;

class PendingPORepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getDates()
    {
        return DB::table('data_src')
            ->select(DB::raw("created_date as value,DATE_FORMAT(created_date,'%m/%d/%Y') as label"))
            ->distinct()
            ->orderBy('created_date','desc')
            ->get();
    }

    public function getBaGroups($date)
    {
        $result = DB::table('data_src')
            ->select(DB::raw("distinct COALESCE(NULLIF(ba_group, ''), 'Blanks') AS ba_group"));
        if(!is_null($date)){
            return $result->where('created_date','=',$date)->get();
        }

        return $result->get();
    }

    public function getPOStatus()
    {
        return DB::table('data_src')->distinct()->select('po_status')->get();
    }

    public function getData($date)
    {
        $result = DB::table('data_src')->select();

        if(!is_null($date)){
            return $result->where('created_date',$date)->orderBy('created_date','desc')->get();
        }
        
        return null;
       
    }

    public function getBase($date)
    {
        $result = DB::table('data_src')->select();

        if(!is_null($date)){
            return $result->where('created_date',$date)->orderBy('created_date','desc');
        }
        
        return null;
       
    }

    public function getStatus($base,$po_status){

        if(!is_null($po_status) && $po_status != 'All'){
            return [$po_status];
        }

        $result = $base->select('po_status')
            ->distinct()
            ->get();

        $status_arr = [];

        foreach($result as $status){
            array_push($status_arr,$status->po_status);
        }

        return $status_arr;
    }
}


/*
SELECT distinct COALESCE(NULLIF(ba_group, ''), 'Blanks') AS ba_group FROM data_src;
*/