<?php

namespace App\Entities\Reports;

class APDaily
{
    /**
     * Create a new class instance.
     */
    protected $countByVendorData;

    protected $ap_months;

    public function __construct()
    {
        //
    }

    public function setCountByVendorData($data)
    {
        $this->countByVendorData = $data;
    }

    public function getCountByVendorData()
    {
        // return (clone $this->countByVendorData)->get();
        return (clone $this->countByVendorData)->orderBy('vendor','ASC')->get();
    }

    public function getCountByVendorDataSorted()
    {
        return (clone $this->countByVendorData)->orderBy('ref_no_count','DESC')->get();
    }


    public function setMonths($data)
    {
        $this->ap_months = $data;
    }
}
