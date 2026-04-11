<?php

namespace App\Service\Reports;

use App\Entities\Reports\POWithStatus;
use App\Repositories\Reports\PendingPORepository;

class PendingPOService
{

    public function __construct(protected PendingPORepository $pendingPORepostory )
    {
        //
    }

    public function getDates()
    {
        return $this->pendingPORepostory->getDates();
    }

    public function getBaGroups($date = null)
    {
        return $this->pendingPORepostory->getBaGroups($date);
    }

    public function getPOStatus()
    {
        return $this->pendingPORepostory->getPOStatus();
    }

    public function getData($date = null)
    {
        return $this->pendingPORepostory->getData($date);
    }

    public function processData( $created_at = null, $po_status = null, $ba_group = null)
    {
        $base = $this->pendingPORepostory->getBase($created_at);

        $statuses = $this->pendingPORepostory->getStatus(clone $base,$po_status);

        $data = [];

        foreach($statuses as $key => $value)
        {
            // dd($key,$value); use value
            // $data[$value] = new POWithStatus($value,clone $base);
            $po_by_status = new POWithStatus($value,clone $base);

            $po_by_status->buildBaGroup();
            $po_by_status->buildByBAGroup();

            $po_by_status->buildByBAGroupAndBuyerAdmin();

            array_push($data,$po_by_status);
        }

        return $data;
    }


}
