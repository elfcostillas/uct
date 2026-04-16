<?php

namespace App\Service\DataSource;

use App\Models\UCT\PendingPo;
use Throwable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

            if(trim($row[17])!="")
            {
                preg_match_all(
                    '/\b(\d{1,2}[\/\-]\d{1,2}[\/\-]\d{2,4}|\d{1,2}[\/\-]\d{1,2})\b/',
                    $row[17],
                    $matches
                );

                if (!empty($matches[0][0])) {

                    $format = $this->detectDateFormat($matches[0][0]);

                    switch($format)
                    {
                        case 'm/d';
                        // $date_reviewed_ba = $format.' - '. $matches[0][0];
                                $date_reviewed_ba = Carbon::parse($matches[0][0].'/'.$created_date->format('Y'))->format('Y-m-d');
                            break;

                        case 'm/d/Y';
                        case 'm/d/Y or d/m/Y';
                        // $date_reviewed_ba = $format.' - '. $matches[0][0];
                                $date_reviewed_ba = Carbon::createFromFormat('n/j/Y',$matches[0][0])->format('Y-m-d');
                            break;
                        
                        default :
                            $date_reviewed_ba = null;
                            break;
                        
                    }
                }else{
                    $date_reviewed_ba = null;
                }

              
            }else{
                $date_reviewed_ba = null;
            }

            DB::table('looper')->insert([
                'title' => 1,
                'time_stamp' => now(),
                'event_type' => 'I',
                'text_comment' => $date_reviewed_ba
            ]);

            // $date_reviewed_ba = ($matches[0][0] != "") ?  Carbon::createFromFormat($matches[0],'n/j/Y')->format('Y-m-d') : null;

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
                    'invoice_value' => (trim($row[10])=="") ? 0 : trim($row[10]),
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
                    'created_year' => $created_date->format('Y'),
                    'date_reviewed_ba' => $date_reviewed_ba

                ];

            // $po = PendingPo::where('title',trim($row[0]))->first();

           

            $found = PendingPo::where(['title' => $po_row['title']])->first();

            if ($found) {
              
                foreach($po_row as $key => $value)
                {
                    if($found->$key == $value)
                    {
                        unset($po_row[$key]);
                    }
                }

                if(!empty($po_row)){
                    $found->update($po_row);
                }
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

    function detectDateFormat($date)
    {
        $parts = preg_split('/[\/\-]/', $date);

        if (count($parts) === 2) {
            return 'm/d';
        }

        if (count($parts) === 3) {
            $first = (int) $parts[0];
            $second = (int) $parts[1];
            $third = (int) $parts[2];

            // year is usually 4 digits or > 31
            if ($third > 31) {
                return 'm/d/Y or d/m/Y';
            }

            if ($parts[0] > 12) {
                return 'd/m/Y';
            }

            return 'm/d/Y';
        }

        return 'unknown';
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