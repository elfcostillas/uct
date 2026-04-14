<?php

namespace App\Http\Controllers\Reports;

use App\Entities\Reports\APDaily;
use App\Http\Controllers\Controller;
use App\Service\Reports\APDailyService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\APDailyReport;

class APDailyController extends Controller
{
    public function __construct(protected APDailyService $service,protected APDailyReport $excel)
    {
        
    }

    public function index()
    {
        $ap_report = $this->service->buildReport();

        $monthly_ap_report = $this->service->buildMonthlyAP();

        return Inertia::render('MyApp/Reports/APDaily/MainPage',[
            'count_by_vendor' => $ap_report->getCountByVendorData(),
            'monthly_ap_report' => $monthly_ap_report
        ]);
    }

    public function download()
    {
        $ap_report = $this->service->buildReport();
        $monthly_ap_report = $this->service->buildMonthlyAP();
        $monthly_ap_report_vendor = $this->service->buildMonthlyAPByVendor();

        $this->excel->setValues($ap_report,$monthly_ap_report,$monthly_ap_report_vendor);

        return Excel::download($this->excel,'AP Daily Report.xlsx');

        // return view('reports.ap-daily', [ 
        //     'ap_report' => $ap_report,
        //     'monthly_ap_report' => $monthly_ap_report,
        //     'monthly_ap_report_vendor' => $monthly_ap_report_vendor,
        // ]);


    }

    public function webview()
    {
        $ap_report = $this->service->buildReport();
        $monthly_ap_report = $this->service->buildMonthlyAP();
        $monthly_ap_report_vendor = $this->service->buildMonthlyAPByVendor();

        return view('reports.ap-daily-webview', [ 
            'ap_report' => $ap_report,
            'monthly_ap_report' => $monthly_ap_report,
            'monthly_ap_report_vendor' => $monthly_ap_report_vendor,
        ]);
    }
}
