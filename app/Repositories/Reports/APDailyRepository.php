<?php

namespace App\Repositories\Reports;

use Illuminate\Support\Facades\DB;

class APDailyRepository
{
    /**
     * Create a new class instance.
     */

    protected $base_query;
    protected $doc_status = '2 - Pending';
    
    public function __construct()
    {
        $this->base_query = DB::table('data_src');

    }

    public function countByVendor()
    {
        if(in_array($this->doc_status,$this->getAllStatus())){
            return (clone $this->base_query)->where('po_status',$this->doc_status)
                ->select(DB::raw(" COALESCE(NULLIF(vendor, ''), 'Blanks') as vendor, COUNT(title) as ref_no_count"))
                ->groupBy('vendor');
        }
    }

    public function getAllStatus()
    {
        return (clone $this->base_query)->groupBy('po_status')->pluck('po_status')->toArray();;
    }

    public function getMonths()
    {
        if(in_array($this->doc_status,$this->getAllStatus())){
            return (clone $this->base_query)->where('po_status',$this->doc_status)
                ->select(DB::raw("DATE_FORMAT(created_date,'%Y-%m') ap_month"))
                ->distinct()
                ->orderBy('created_date','ASC');
        }
    }

    public function getVendors()
    {
        if(in_array($this->doc_status,$this->getAllStatus())){
        return (clone $this->base_query)
            ->where('po_status', $this->doc_status)
            ->select(
                DB::raw('BINARY vendor as vendor'),
                DB::raw("COALESCE(NULLIF(TRIM(BINARY vendor), ''), '-Blanks') as vendor_label")
            )
            ->groupBy(DB::raw('BINARY vendor'))
            ->orderBy('vendor', 'ASC');
        }
    }

    public function getCount($first_day,$last_day)
    {
        if(in_array($this->doc_status,$this->getAllStatus())){
            return (clone $this->base_query)->where('po_status',$this->doc_status)
                ->select(DB::raw("COUNT(title) as ref_no_count"))
                ->whereBetween('created_date',[$first_day,$last_day])
                ->first();
        }

        return null;
    }

    public function getCountByVendor($first_day,$last_day)
    {
         if(in_array($this->doc_status,$this->getAllStatus())){
            return (clone $this->base_query)->where('po_status',$this->doc_status)
                ->select(DB::raw("vendor,COUNT(title) as ref_no_count"))
                ->whereBetween('created_date',[$first_day,$last_day])
                ->groupBy('vendor')
                ->get();
        }
    }
}
