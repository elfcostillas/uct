<?php

namespace App\Http\Controllers\DataSource;

use App\Http\Controllers\Controller;
use App\Service\DataSource\InvoiceService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function __construct(protected InvoiceService $invoiceService)
    {
        
    }

    public function index()
    {
        $invoices = $this->invoiceService->getInvoices();

        return Inertia::render('MyApp/DataSource/Invoice/MainPage',[
            'invoices' => $invoices
        ]);
    }

    public function print(Request $request)
    {
        // dd($request->invoice_no);

        // return view('data-source.invoice.print');
        $data = $this->invoiceService->getInvoice($request->invoice_no);
        $header = $this->invoiceService->makeHeader($request->invoice_no);
        $pdf = Pdf::loadView('data-source.invoice.print',[
            'data' => $data,
            'header' => $header
        ]);

        return $pdf->stream('invoice.pdf');
    }
}
