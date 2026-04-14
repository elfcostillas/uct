<?php

namespace App\Service\DataSource;

use App\Models\UCT\PendingPo;
use Throwable;
use Carbon\Carbon;

class PendingReportService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createORUpdate($row,$ctr)
    {
        if( trim($row[0]) != "" ){
            try {
                $created_date =  Carbon::createFromFormat('n/j/Y',trim($row[1]));
            }catch(Throwable $e){
               
            }


            $po_row = [
                    'title' => trim($row[0]),
                    'created_date' => $created_date->format('Y-m-d'),
                    'po_no' => trim($row[2]),
                    'po_line_no' => trim($row[3]),
                    'po_status' => trim($row[4]),
                    'vendor' => trim($row[5]),
                    'invoice_link' => trim($row[6]),
                    'vendor_email' => trim($row[7]),
                    'ap_person' => trim($row[8]),
                    'invoice_name' => trim($row[9]),
                    'invoice_value' => trim($row[10]),
                    'currency' => trim($row[11]),
                    'buyer' => trim($row[12]),
                    'record_issue' => trim($row[13]),
                    'ba_group' => trim($row[14]),
                    'buyer_admin' => trim($row[15]),
                    'ba_record_status' => trim($row[16]),
                    'ba_comments' => $row[17],
                    'buyer_comments' => $row[18],
                    
                    'gr_comments' => trim($row[19]),
                    'ap_comments' => trim($row[20]),

                    'auto_update' => trim($row[21]),
                    'item_type' => trim($row[22]),
                    'path' => trim($row[23]),
                    'created_year' => $created_date->format('Y')

                ];

            // $po = PendingPo::where('title',trim($row[0]))->first();

           

            $found = PendingPo::where(['title' => $po_row['title']])->first();

            if ($found) {
                // dd("Its a scam");
                // return false;
                $found->update($po_row);
                return false;
            }
            else{
                
                PendingPo::create($po_row);

            }
            // $po = PendingPo::updateOrCreate(['title' => $po_row['title']],$po_row);


            unset($po_row);
        }else{
            // dd( $row);
        }
        
        return true;
    }
}


/*
// $format = 'Y-m-d\TH:i:s.u\Z'; 

                // $clean = strstr(trim($row[19]), 'Z', true) . 'Z';

                // $date = Carbon::createFromFormat($format, $clean);
                
               

                if( trim($row[0])!="" ){

                    try {
                        $created_date =  Carbon::createFromFormat('n/j/Y',trim($row[1]));
                    }catch(Throwable $e){
                        dd($row);
                    }

                    array_push($data,[
                    'title' => trim($row[0]),
                    'created_date' => $created_date->format('Y-m-d'),
                    'po_no' => trim($row[2]),
                    'po_line_no' => trim($row[3]),
                    'po_status' => trim($row[4]),
                    'vendor' => trim($row[5]),
                    'invoice_link' => trim($row[6]),
                    'vendor_email' => trim($row[7]),
                    'ap_person' => trim($row[8]),
                    'invoice_name' => trim($row[9]),
                    'invoice_value' => trim($row[10]),
                    'currency' => trim($row[11]),
                    'buyer' => trim($row[12]),
                    'record_issue' => trim($row[13]),
                    'ba_group' => trim($row[14]),
                    'buyer_admin' => trim($row[15]),
                    'ba_record_status' => trim($row[16]),
                    'ba_comments' => trim($row[17]),
                    'buyer_comments' => trim($row[18]),
                    'auto_update' => trim($row[19]),
                    'item_type' => trim($row[20]),
                    'path' => trim($row[21])

                    // 'date_reviewed_ba' => trim($row[18]),
                    // 'date_resolved_ba' => trim($row[19]),
                    // 'buyer_comments' => trim($row[20]),
                    // 'gr_comments' => trim($row[21]),
                    // 'ap_comments' => trim($row[22]),
                    // 'auto_update' => trim($row[23]),
                    // 'item_type' => trim($row[24]),
                    // 'path' => trim($row[25]),
                    // 'created_year' => trim($row[25])

                ]);
                }


                 fclose($handle);
            try {
                // DB::table('data_src')->insertOrIgnore($data);
                $chunks = array_chunk($data, 500); // 500 rows per batch

                foreach ($chunks as $chunk) {
                    DB::table('data_src')->insertOrIgnore($chunk);
                }
            } catch (Throwable $e){
                return response()->json($e->getMessage());
            }

                */