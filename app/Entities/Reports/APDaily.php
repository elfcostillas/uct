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
        return $this->countByVendorData;
    }

    public function setMonths($data)
    {
        $this->ap_months = $data;
    }
}
