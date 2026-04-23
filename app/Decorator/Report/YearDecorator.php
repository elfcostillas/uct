<?php

namespace App\Decorator\Report;

class YearDecorator implements QueryContract
{
    public $value;

    public function __construct()
    {
        //
    }

    public function apply($query)
    {
        return $query->whereRaw('year(created_date) = ?',[$this->value]);
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
}
