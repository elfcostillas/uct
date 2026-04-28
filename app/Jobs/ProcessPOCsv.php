<?php

namespace App\Jobs;

use App\Service\DataSource\PendingReportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class ProcessPOCsv implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    protected $path;
    protected $upload_date;

    public function __construct($path,$upload_date)
    {
        $this->path = $path;
        $this->upload_date = $upload_date;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fullPath = storage_path('app/public/' . $this->path);
        // $fullPath = storage_path($this->path);

        // count SELECT COUNT(title) FROM data_src_history WHERE upload_date = '2026-04-17'

        $count = DB::table('data_src_history')->where('upload_date',$this->upload_date);

        if($count->count() == 0){
            if (($handle = fopen($fullPath, 'r')) !== false) {
                $header = fgetcsv($handle, 1000, ',');
                $data = array();

                $ctr = 0;

                DB::transaction(function() use ($handle){

                    // copy to before table;
                    app(PendingReportService::class)->copyToOtherTable($this->upload_date,'data_src_before');

                    while (($row = fgetcsv($handle, 0, ',')) !== false) {
                    
                        if(count($row)==25)
                        {
                            $row = array_map(fn($v) => mb_convert_encoding(trim($v), 'UTF-8', 'auto'), $row);
                        
                            $result =  app(PendingReportService::class)->createORUpdate($row,$this->upload_date);
                                
                            unset($row);
                        }
                    }

                    fclose($handle);

                    // copy to after;
                    app(PendingReportService::class)->copyToOtherTable($this->upload_date,'data_src_after');
                });
            
            }
        }

        
    }
}
