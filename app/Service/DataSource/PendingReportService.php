<?php

namespace App\Service\DataSource;

use App\Models\UCT\PendingPo;
use Throwable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PendingReportService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function copyToOtherTable($date,$target_table)
    {
        $selectQuery = DB::table('data_src')
            ->select(
                DB::raw("
                trim(title) as title,
                trim(created_date) as created_date,
                trim(po_no) as po_no,
                trim(po_line_no) as po_line_no,
                trim(po_status) as po_status,
                trim(vendor) as vendor,
                trim(invoice_link) as invoice_link,
                trim(vendor_email) as vendor_email,
                trim(ap_person) as ap_person,
                trim(invoice_name) as invoice_name,
                trim(invoice_value) as invoice_value,
                trim(currency) as currency,
                trim(buyer) as buyer,
                trim(record_issue) as record_issue,
                trim(ba_group) as ba_group,
                trim(buyer_admin) as buyer_admin,
                trim(ba_record_status) as ba_record_status,
                trim(ba_comments) as ba_comments,
                trim(date_reviewed_ba) as date_reviewed_ba,
                trim(date_resolved_ba) as date_resolved_ba,
                trim(buyer_comments) as buyer_comments,
                trim(gr_comments) as gr_comments,
                trim(auto_update) as auto_update,
                trim(item_type) as item_type,
                trim(path) as path,
                trim(created_year) as created_year,
                trim(ppv_var) as ppv_var,
                '".$date->format('Y-m-d')."' as upload_date")
            );


        DB::table($target_table)->insertUsing([
            'title',
            'created_date',
            'po_no',
            'po_line_no',
            'po_status',
            'vendor',
            'invoice_link',
            'vendor_email',
            'ap_person',
            'invoice_name',
            'invoice_value',
            'currency',
            'buyer',
            'record_issue',
            'ba_group',
            'buyer_admin',
            'ba_record_status',
            'ba_comments',
            'date_reviewed_ba',
            'date_resolved_ba',
            'buyer_comments',
            'gr_comments',
            'auto_update',
            'item_type',
            'path',
            'created_year',
            'ppv_var',
            'upload_date'
        ], $selectQuery);
    }

    public function createORUpdate($row,$upload_date)
    {
        $history = [];

        // $looper = array(
        //     'title' => 'row',
        //     'time_stamp' => now(),
        //     'event_type' => 'insert',
        //     'text_comment' => json_encode($row),

        // );   

        if( trim($row[0]) != "" ){

        // DB::table('looper')->insert($looper);

            try{
                // $format = $this->detectDateFormat($matches[0][0]);
                $created_date =  Carbon::createFromFormat('n/j/Y',trim($row[1]));

            }catch(Throwable $e){
                
                // Log::info($e->getMessage());
            }

            if(trim($row[17])!="")
            {
                preg_match_all(
                    '/\b(\d{1,2}[\/\.\-]\d{1,2}[\/\.\-]\d{2,4}|\d{1,2}[\/\.\-]\d{1,2})\b/',
                    $row[17],
                    $matches
                );

                // Log::info($row,$matches);

                if (!empty($matches[0][0])) {

                    try{
                        $format = $this->detectDateFormat($matches[0][0]);
                    }catch(Throwable $e){
                       
                    }

                    switch($format['format']){
                        case '' :
                                $date_reviewed_ba = Carbon::parse($format['value'].'/'.now()->format('Y'))->format('Y-m-d');
                            break;
                        
                        default :
                                $date_reviewed_ba = Carbon::createFromFormat($format['format'],$format['value'])->format('Y-m-d');
                            break;
                    }
                    
                    // switch($format)
                    // {
                    //     case 'm/d';
                    //     // $date_reviewed_ba = $format.' - '. $matches[0][0];
                    //             $date_reviewed_ba = Carbon::parse($matches[0][0].'/'.now()->format('Y'))->format('Y-m-d');
                    //         break;
                        
                    //     case 'm.d';
                        
                    //             $date_reviewed_ba = Carbon::parse($matches[0][0].'/'.now()->format('Y'))->format('Y-m-d');
                    //         break;

                    //     case 'm/d/Y';
                    //     case 'm/d/Y OR d/m/Y';
                    //     // $date_reviewed_ba = $format.' - '. $matches[0][0];
                    //             $date_reviewed_ba = Carbon::createFromFormat('n/j/Y',$matches[0][0])->format('Y-m-d');
                    //         break;

                    //     case 'm.d.Y';
                    //     case 'm.d.Y OR d/m/Y';
                    //             $date_reviewed_ba = Carbon::createFromFormat('n/j/Y',$matches[0][0])->format('Y-m-d');
                    //         break;
                        
                    //     default :
                    //         $date_reviewed_ba = null;
                    //         break;
                        
                    // }
                }else{
                    $date_reviewed_ba = null;
                }

              
            }else{
                $date_reviewed_ba = null;
            }


            // $date_reviewed_ba = ($matches[0][0] != "") ?  Carbon::createFromFormat($matches[0],'n/j/Y')->format('Y-m-d') : null;

            $po_row = [
                    'title' => trim($row[0]),
                    'created_date' => $created_date->format('Y-m-d'),
                    'po_no' => trim($row[2]),
                    'po_line_no' => trim($row[3]),
                    'po_status' => trim($row[4]),
                    'vendor' => str_replace(['?'],'',trim($row[5])),
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
                    'ppv_var' =>  (trim($row[21])=="") ? 0 : trim($row[21]),
                    'auto_update' => trim($row[22]),
                    'item_type' => trim($row[23]),
                    'path' => trim($row[24]),
                    'created_year' => $created_date->format('Y'),
                    'date_reviewed_ba' => $date_reviewed_ba

                ];

            $history_row = $po_row;
            $history_row['upload_date'] =  $upload_date->format('Y-m-d');

            array_push($history,$history_row);

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

            $chunks = array_chunk($history, 500); // 500 rows per batch

            foreach ($chunks as $chunk) {
                DB::table('data_src_history')->insertOrIgnore($chunk);
            }


            unset($po_row);
            unset($history);
        }else{
            // dd( $row);
        }
        
        return true;
    }

    function detectDateFormat($date)
    {
        $date_value = str_replace(['-','.'],'/',$date);

        $parts = preg_split('/[\/\-\.]/', $date);

        $d = [
            'format' => 'unknown',
            'value' => $date_value,
        ];

        if (count($parts) === 2) {
            // return 'm/d';
            return  [
                'format' => 'm/d',
                'value' => $date_value,
            ];
        }

        if (count($parts) === 3) {
            $first = (int) $parts[0];
            $second = (int) $parts[1];
            $third = (int) $parts[2];

            // year is usually 4 digits or > 31

               

            
                // if ($third > 31 ) {
                //     // return 'm/d/Y or d/m/Y';

                //     if($third < 1900){
                //         return  [
                //             'format' => 'm/d/y or d/m/y',
                //             'value' => $date_value,
                //         ]; 
                //     }

                //     return  [
                //         'format' => 'm/d/Y or d/m/Y',
                //         'value' => $date_value,
                //     ]; 
                // }

                if ($parts[0] > 12) {
                    // return 'd/m/Y';
                    if($third < 1900){
                        return  [
                            'format' => 'd/m/y',
                            'value' => $date_value,
                        ]; 
                    }

                    return  [
                            'format' => 'd/m/Y',
                            'value' => $date_value,
                        ]; 
                }

                if($third < 1900){
                    return  [
                        'format' => 'm/d/y',
                        'value' => $date_value,
                    ]; 
                }else{
                    return  [
                        'format' => 'm/d/Y',
                        'value' => $date_value,
                    ]; 
                }

           
        }

        return $d;
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