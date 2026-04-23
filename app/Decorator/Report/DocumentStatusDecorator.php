<?php

namespace App\Decorator\Report;

class DocumentStatusDecorator implements QueryContract
{

    public $value;

    public function __construct()
    {
        //
    }

    public function apply($query)
    {
        return $query->where('po_status',$this->value);
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
}
