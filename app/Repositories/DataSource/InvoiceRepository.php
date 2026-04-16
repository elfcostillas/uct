<?php

namespace App\Repositories\DataSource;

use App\Models\UCT\Invoice;

class InvoiceRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getInvoices()
    {
        return Invoice::select('invoice_no','ship_date','customer')
                    ->distinct()
                    ->orderBy('invoice_no','desc')
                    ->orderBy('ship_date','desc')
                    ->get();
    }

    public function getInvoice($invoice_no)
    {
        return Invoice::select()
                ->where('invoice_no' ,'=',$invoice_no)
                ->orderBy('invoice_no','desc')
                ->orderBy('ship_date','desc')
                ->get();
    }

public function getOneInvoice($invoice_no)
    {
        return Invoice::select('invoice_no','ship_date','customer')
                ->distinct()
                ->where('invoice_no' ,'=',$invoice_no)
                ->orderBy('invoice_no','desc')
                ->orderBy('ship_date','desc')
                ->first();
    }
}
