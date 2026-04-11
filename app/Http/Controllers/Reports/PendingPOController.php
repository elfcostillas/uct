<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Service\Reports\PendingPOService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PendingPOController extends Controller
{
    public function __construct(protected PendingPOService $pendingPOService)
    {
        
    }

    public function index(Request $request)
    {
        $created_date_filter = ($request->input('created_date')) ? $request->input('created_date') : null;

        $po_dates = $this->pendingPOService->getDates();
        $ba_groups = $this->pendingPOService->getBaGroups($created_date_filter);
        $po_status = $this->pendingPOService->getPOStatus();
        $data =  $this->pendingPOService->getData($created_date_filter);

        return Inertia::render('MyApp/Reports/PendingPO/MainPage',[
            'po_dates' => $po_dates,
            'ba_groups' => $ba_groups,
            'po_status' => $po_status,
            'data' => $data
        ]);
    }

    public function download(Request $request)
    {
        $created_at = $request->input('created_at');
        $po_status = $request->input('po_status');
        $ba_group = $request->input('ba_group');

        $data = $this->pendingPOService->processData( $created_at, $po_status, $ba_group);

        return view('reports.po-by-status', [ 'data' => $data]);
    }
}
