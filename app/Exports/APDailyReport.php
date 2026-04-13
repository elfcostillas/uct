<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;

use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnWidths;


class APDailyReport implements ShouldAutoSize,WithColumnFormatting,FromView,WithEvents
{

    protected $ap_report;
    protected $monthly_ap_report;
    protected $monthly_ap_report_vendor;


    public function registerEvents(): array
    {   
        return [
            AfterSheet::class    => function(AfterSheet $event) {

            }
        ];    
    }


    public function setValues($ap_report,$monthly_ap_report,$monthly_ap_report_vendor)
    {
        $this->ap_report = $ap_report;
        $this->monthly_ap_report = $monthly_ap_report;
        $this->monthly_ap_report_vendor = $monthly_ap_report_vendor;    
    }

    public function view(): View
    {
        return view('reports.ap-daily', [ 
            'ap_report' => $this->ap_report,
            'monthly_ap_report' => $this->monthly_ap_report,
            'monthly_ap_report_vendor' => $this->monthly_ap_report_vendor,
        ]);
    }

    public function columnWidths(): array
    {
        return [
           
        ];
    }

    
    public function columnFormats(): array
    {
        $cols = [
           
           
        ];
    
        return $cols;
     
    }
}
