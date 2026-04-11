<?php

namespace App\Service\Reports;

use App\Entities\Reports\APDaily;
use App\Entities\Reports\APMonthly;
use App\Repositories\Reports\APDailyRepository;
use Throwable;

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

    public function buildMonthlyAPByVendor()
    {
        $cols = [];

        $months = $this->repo->getMonths()->get();
        $vendors = $this->repo->getVendors()->get();

        $data = $this->makeBlank($vendors,$months);

        foreach( $months as $months_key => $month)
        {


            $ap_months = new APMonthly($month->ap_month);
            $ap_months->setRepostory($this->repo);

            $counts = $ap_months->getCountByVendor();

            // array_push($cols,[ $month->ap_month => $ap_months->getLabel() ] );
            $cols[$month->ap_month] = $ap_months->getLabel();

            foreach($counts as $count)
            {
                $data[$count->vendor][$month->ap_month] += $count->ref_no_count;
                // try{
                    
                // }catch(Throwable $e){
                //     dd($count->vendor,$month->ap_month,$count->ref_no_count);
                // }


                // if( $count->vendor =='Ham-Let Singapore Valves & Fittings PTE LTD' && $month->ap_month == '2025-07'){
                //     dd($data[$count->vendor]);
                // }
            }
            
        }

        return [
            'months' => $months,
            'vendors' => $vendors,
            'data' => $data,
            'cols' => $cols,
        ];
    }

    public function makeBlank($vendor,$months)
    {
        $data = []; 

        foreach($vendor as $v)
        {
            foreach($months as $m){
                $data[$v->vendor][$m->ap_month] = 0;
            }
        }

        return $data;
    }
}
