<?php

namespace App\Http\Controllers\Reports;

use App\Exports\DailyChanges;
use App\Http\Controllers\Controller;
use App\Service\Reports\BIReportsService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class DailyChangesController extends Controller
{    
    public function __construct(protected BIReportsService $biReportsService,protected DailyChanges $excel)
    {
        
    
    }

    public function index()
    {
      
        $years = $this->biReportsService->getYears();
       

        return Inertia::render('MyApp/Reports/DailyChanges/MainPage',[
            'years' => $years,
          

        ]);
    }

    public function download(Request $request)
    {
        // dd($request->year);
        $year = $request->year;
        $bi_year = $request->bi_year;
        $data = $this->biReportsService->buildDailyChanges($year,$bi_year);

        // return view('reports.daily-changes',[ 'data' => $data]);

        $this->excel->setValues($data);

        return Excel::download($this->excel,'BI Daily Changes.xlsx');


    }
}