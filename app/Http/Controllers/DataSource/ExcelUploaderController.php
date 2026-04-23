<?php

namespace App\Http\Controllers\DataSource;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessPOCsv;
use App\Service\DataSource\PendingReportService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ExcelUploaderController extends Controller
{
    public function __construct(protected PendingReportService $service)
    {
        
    }

    public function index()
    {
        
        return Inertia::render('MyApp/DataSource/ExcelUploader/MainPage');
    }

    public function upload(Request $request)
    {
        // dd($request->file('files'));
       
        ini_set('memory_limit', '512M');

        $upload_date = Carbon::createFromFormat('m-d-Y',$request->upload_date);

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

        ProcessPOCsv::dispatch($path,$upload_date);

        /*
        $filename = basename($path);

        $fullPath = storage_path('app/public/' . $path);

        if (($handle = fopen($fullPath, 'r')) !== false) {
            $header = fgetcsv($handle, 1000, ',');
            $data = array();

            $ctr =0;

            while (($row = fgetcsv($handle, 0, ',')) !== false) {
                $ctr++;

                $row = array_map(fn($v) => mb_convert_encoding(trim($v), 'UTF-8', 'auto'), $row);
              
                $result =  $this->service->createORUpdate($row,$ctr);

                if(!$result){
                    var_dump($row,$ctr);
                }else{
                    var_dump($row[0]);
                }
                    
                unset($row);
            }

            fclose($handle);
           
        }
        */

    }

}
