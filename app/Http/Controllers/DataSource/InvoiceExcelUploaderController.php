<?php

namespace App\Http\Controllers\DataSource;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessInvoiceCsv;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Svg\Tag\Rect;
use Throwable;


class InvoiceExcelUploaderController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        
        return Inertia::render('MyApp/DataSource/ExcelUploaderInvoice/MainPage');
    }

    public function upload(Request $request)
    {
        // dd($request);
        ini_set('memory_limit', '512M');

        if (!Storage::disk('public')->exists('uploads/invoices')) {
            Storage::disk('public')->makeDirectory('uploads/invoices');
        }

        $originalName = $request->file('files')->getClientOriginalName();
        $extension = $request->file('files')->getClientOriginalExtension();

        try {
            $path = $request->file('files')->store('uploads/invoices','public');
        } catch (Throwable $e){
            dd($e->getMessage());
        }
        
        ProcessInvoiceCsv::dispatch($path);  
    }
}
