<?php

namespace App\Service\DataSource;

use App\Models\UCT\Invoice;
use App\Repositories\DataSource\InvoiceRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class InvoiceService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected InvoiceRepository $invoiceRepository)
    {
        //
    }

    public function getInvoices()
    {
        return $this->invoiceRepository->getInvoices();
    }

    public  function getInvoice($invoice_no = null)
    {
        return $this->invoiceRepository->getInvoice($invoice_no);
    }

    public function makeHeader($invoice_no = null)
    {
        $invoice = $this->invoiceRepository->getOneInvoice($invoice_no);

        $date = Carbon::createFromFormat('Y-m-d',$invoice->ship_date);
        
        return [
            'invoice_no' => $invoice->invoice_no,
            'date' => $date->format('Y-m-d'),
            'due_date' => $date->addDays(30)->format('Y-m-d'),
            'terms' => 'Net 30 days'
        ];
    }

    public function createORUpdate($row)
    {
        $ship_date = null;

        if($row[2] != "")
        {
            $ship_date = Carbon::createFromFormat('n/j/Y',$row[2])->format('Y-m-d');
        }

        if( trim($row[0]) != "" ){
            $invoice_row = [
                'customer' => $row[0],
                'part_number' => $row[1],
                'ship_date' => $ship_date,
                'description' => $row[3],
                'shipped_qty' => $row[4],
                'unit_price' => $this->clean($row[5]),
                'total_price' => $this->clean($row[6]),
                'plant' => $row[7],
                'po_number' => $row[8],
                'po_line' => $row[9],
                'packing_slip' => $row[10],
                'tracking_no' => $row[11],
                'invoice_no' => $row[12],
                'remarks' => $row[13],
            ];

            Log::debug($invoice_row);

            $found = Invoice::where('part_number','=',$invoice_row['part_number'])
                    ->where('invoice_no','=',$invoice_row['invoice_no'])
                    ->first();

            if($found){
                foreach($invoice_row as $key => $value)
                {
                    if($found->$key == $value)
                    {
                        unset($invoice_row[$key]);
                    }
                }

                if(!empty($invoice_row)){
                    $result = $found->update($invoice_row);
                }

            }else{
                $result = Invoice::create($invoice_row);
            }

            unset($invoice_row);
        }

       

        return true;
    }

    public function clean($string){
        return str_replace(['$',','],'',$string); 
    }
}
