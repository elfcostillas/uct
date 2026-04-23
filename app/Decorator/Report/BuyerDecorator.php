<?php

namespace App\Decorator\Report;

class BuyerDecorator implements QueryContract
{
    public $value;

    public function __construct()
    {
        //
    }

    public function apply($query)
    {
        return $query->whereRaw('buyer = ?',[$this->value]);
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
}
