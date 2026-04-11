<?php

namespace App\Service\Reports;

use App\Entities\Reports\APDaily;
use App\Entities\Reports\APMonthly;
use App\Repositories\Reports\APDailyRepository;

class APDailyService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected APDailyRepository $repo)
    {
        
    }

    public function buildReport()
    {
        $report =  new APDaily();

        $count_by_vendor = $this->repo->countByVendor();

        $report->setCountByVendorData($count_by_vendor->get());

        return $report;
    }

    public function buildMonthlyAP()
    {
        $cols = [];

        $months = $this->repo->getMonths()->get();

        foreach($months as $key => $month)
        {
            $ap_months[$key] = new APMonthly($month->ap_month);
            $ap_months[$key]->setRepostory($this->repo);

            array_push($cols,[ 'label' => $ap_months[$key]->getLabel() , 'count' => $ap_months[$key]->getCount() ] );
        }

        return $cols;

    }
}
