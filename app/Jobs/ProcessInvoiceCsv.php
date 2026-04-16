<?php

namespace App\Jobs;

use App\Service\DataSource\InvoiceService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessInvoiceCsv implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    protected $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fullPath = storage_path('app/public/' . $this->path);

        if (($handle = fopen($fullPath, 'r')) !== false) {
            $header = fgetcsv($handle, 1000, ',');
            $data = array();

            $ctr =0;

            while (($row = fgetcsv($handle, 0, ',')) !== false) {
                $ctr++;
                if(count($row)==14)
                {
                    $row = array_map(fn($v) => mb_convert_encoding(trim($v), 'UTF-8', 'auto'), $row);
                
                    $result =  app(InvoiceService::class)->createORUpdate($row,$ctr);
                        
                    unset($row);
                }
            }

            fclose($handle);
           
        }
    }
}
