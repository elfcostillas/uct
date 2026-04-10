<?php

namespace App\Http\Controllers\DataSource;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ExcelUploaderController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        
        return Inertia::render('MyApp/DataSource/ExcelUploader/MainPage');
    }

    public function upload(Request $request)
    {
        // dd($request->file('files'));

        if (!Storage::disk('public')->exists('uploads')) {
            Storage::disk('public')->makeDirectory('uploads');
        }

        $originalName = $request->file('files')->getClientOriginalName();
        $extension = $request->file('files')->getClientOriginalExtension();

        try {
            $path = $request->file('files')->store('uploads','public');
        } catch (Throwable $e){
            dd($e->getMessage());
        }
       
        $filename = basename($path);

        $fullPath = storage_path('app/public/' . $path);

        if (($handle = fopen($fullPath, 'r')) !== false) {
            $header = fgetcsv($handle, 1000, ',');
            $data = array();

            while (($row = fgetcsv($handle, 0, ',')) !== false) {

                $row = array_map(fn($v) => mb_convert_encoding(trim($v), 'UTF-8', 'auto'), $row);

                // $format = 'Y-m-d\TH:i:s.u\Z'; 

                // $clean = strstr(trim($row[19]), 'Z', true) . 'Z';

                // $date = Carbon::createFromFormat($format, $clean);

                array_push($data,[
                    'title' => trim($row[0]),
                    'created_date' => Carbon::createFromFormat('n/j/Y',trim($row[1]))->format('Y-m-d'),
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
        }

    }

}
