<?php

namespace App\Decorator\Report;

class BuyerAdminDecorator implements QueryContract
{
    public $value;

    public function __construct()
    {
        //
    }

    public function apply($query)
    {
        return $query->whereRaw('buyer_admin = ?',[$this->value]);
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
}
