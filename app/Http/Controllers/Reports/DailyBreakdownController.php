<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Service\Reports\BIReportsService;
use App\Service\Reports\DailyBreakdownService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DailyBreakdownController extends Controller
{
    public function __construct(protected BIReportsService $biReportsService,protected DailyBreakdownService $dailyBreakdownService)
    {
        
    }

    public function index()
    {
      
        $years = $this->biReportsService->getYears();
      
        return Inertia::render('MyApp/Reports/Breakdown/MainPage',[
            'years' => $years,
          

        ]);
    }

    // public function download(Request $request)
    public function download(Request $request)
    {
        $year = $request->year;

        $result = $this->dailyBreakdownService->build($year);

        return view('reports.daily-breakdown',[ 'data' => $result ]);
    }
}
