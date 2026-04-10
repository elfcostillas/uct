<?php

namespace App\Service\Reports;

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


}
