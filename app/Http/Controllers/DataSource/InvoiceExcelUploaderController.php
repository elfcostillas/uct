<?php

namespace App\Http\Controllers\DataSource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Throwable;


class InvoiceExcelUploaderController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        
        return Inertia::render('MyApp/DataSource/ExcelUploader/MainPage');
    }
}
