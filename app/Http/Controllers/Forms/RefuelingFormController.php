<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RefuelingFormController extends Controller
{
    public function index()
    {
        $pdf = PDF::loadView('forms.refueling-form');
        return $pdf->stream('RefuelingForm.pdf');
    }
}
