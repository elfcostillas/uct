<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Service\Reports\BIReportsService;
use Illuminate\Http\Request;
use Inertia\Inertia;


class DailyChangesController extends Controller
{    
    public function __construct(protected BIReportsService $biReportsService)
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
        $data = $this->biReportsService->buildDailyChanges($year);

        return view('reports.daily-changes',[ 'data' => $data]);
    }
}