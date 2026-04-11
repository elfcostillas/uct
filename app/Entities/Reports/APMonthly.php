<?php

namespace App\Entities\Reports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class APMonthly
{

    protected $first_day;

    protected $last_day;

    protected $label;

    protected $repository;

    public function __construct($param)
    {
        //
        $param_date =  Carbon::createFromFormat('Y-m',$param);

        $this->first_day = $param_date->startOfMonth()->format('Y-m-d');
        $this->last_day = $param_date->format('Y-m-t');
        $this->label = $param_date->format('M-Y');

    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getFirstDay()
    {
        return $this->first_day;
    }

    public function getLasttDay()
    {
        return $this->last_day;        
    }

    public function setRepostory($repository)
    {
        $this->repository = $repository;
    }

    public function getCount()
    {
        return $this->repository->getCount($this->first_day,$this->last_day)?->ref_no_count;
    }


}
