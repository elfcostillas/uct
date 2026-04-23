<?php

namespace App\Decorator\Report;

class BARecordStatusDecorator implements QueryContract
{
    public $value;

    public function __construct()
    {
        //
    }

    public function apply($query)
    {
        return $query->whereRaw('ba_record_status = ?',[$this->value]);
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
}