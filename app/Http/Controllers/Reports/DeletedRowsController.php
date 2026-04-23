<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Service\Reports\BIReportsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DeletedRowsController extends Controller
{
    public function __construct(protected BIReportsService $biReportsService)
    {
        
    
    }

    public function index(Request $request)
    {
        $year_filter = ($request->input('year_filter')) ? $request->input('year_filter') : null;
        $date_filter = ($request->input('date_filter')) ? $request->input('date_filter') : null;

        $years = $this->biReportsService->getYears();
        $dates = $this->biReportsService->getDatesBeforeUpload($year_filter);
        $data = $this->biReportsService->getDeletedRow($date_filter);

        return Inertia::render('MyApp/Reports/DeletedRow/MainPage',[
            'years' => $years,
            'dates' => $dates,
            'data' => $data

        ]);
    }
}
