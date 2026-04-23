<?php

namespace App\Service\Reports;

use App\Repositories\Reports\BIReportsRepository;

class BIReportsService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected BIReportsRepository $biRepository )
    {
      
    }

    public function getDatesBeforeUpload($year = null)
    {
        return $this->biRepository->getDatesBeforeUpload($year);
    }

    public function getYears()
    {
        return $this->biRepository->getYears();
    }

    public function getDeletedRow($date_filter = null)
    {
        if(is_null($date_filter)){
            return null;
        }else{
            return $this->biRepository->getDeletedRow($date_filter);
        }
    }

    public function buildDailyChanges($year = null)
    {
        $dates = $this->biRepository->getDatesBeforeUpload($year);

        $vendors = $this->biRepository->getAllVendor();

        $pending = [];
        $processed = [];

        /* make blank */
        foreach($vendors as $vendor)
        {
            foreach($dates as $date)
            {
                $pending[$vendor->vendor][$date->upload_date] = 0;
                $processed[$vendor->vendor][$date->upload_date] = 0;
            }
        }
        /* end of make blank */

        foreach($dates as $date)
        {
            $data = $this->biRepository->getDailyChanges($date->upload_date);

           
            foreach($data as $row) 
            {
                $pending[$row->vendor][$date->upload_date] += $row->pending_count;
                $processed[$row->vendor][$date->upload_date] += $row->processed_changed_count;
                
    
            } 
        }

       return [
            'dates' => $dates,
            'vendors' => $vendors,
            'pending' => $pending,
            'processed' => $processed,
       ];
    }
}

/*
      +"vendor": "101691 HYTRON MANUFACTURING COMPANY INC"
      +"processed_changed_count": "0"
      +"pending_count": "1"
      */