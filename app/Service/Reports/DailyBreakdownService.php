<?php

namespace App\Service\Reports;

use App\Decorator\Report\BARecordStatusDecorator;
use App\Decorator\Report\BuyerAdminDecorator;
use App\Decorator\Report\BuyerDecorator;
use App\Decorator\Report\DocumentStatusDecorator;
use App\Decorator\Report\YearDecorator;
use App\Repositories\Reports\DailyBreakdownRepository;
use Illuminate\Support\Facades\DB;

class DailyBreakdownService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected DailyBreakdownRepository $dailyBreakdownRepository)
    {
        //
    }

    public function build($year = null,$po_status = null)
    {
        $query = DB::table('data_src');

        if(!is_null($year))
        {
            /*
            $yearDeco = new YearDecorator();
            $yearDeco->setValue($year);
            
            $query = $yearDeco->apply($query);
            */

            $years = (clone $query)->select(DB::raw("YEAR(created_date) as doc_year"))->whereRaw('YEAR(created_date) = ? ',[$year])->distinct()->get();

        }else{
            $years =  (clone $query)->select(DB::raw("YEAR(created_date) as doc_year"))->distinct()->get();
        }

        foreach($years as $year)
        {
            // $year->doc_year
            // dd($year);
            $yearDeco = new YearDecorator();
            $yearDeco->setValue($year->doc_year);

          
            
            $queryYear = $yearDeco->apply(clone $query);

            $year->count = $queryYear->count();

            $po_status = $this->dailyBreakdownRepository->getPOStatus($po_status,clone $queryYear);

            foreach($po_status as $po_stat)
            {
                $statusDeco = new DocumentStatusDecorator();
                $statusDeco->setValue($po_stat->po_status);

                $queryYearStatus = $statusDeco->apply(clone $queryYear);

                $po_stat->count = ($queryYearStatus)->count();

                $buyers = (clone $queryYearStatus)->select(DB::raw("buyer,COALESCE(NULLIF(buyer, ''),'Blanks') as buyer_label "))->distinct()->orderby('buyer','asc')->get();

                foreach($buyers as $buyer)
                {
                    $buyerDeco = new BuyerDecorator();
                    $buyerDeco->setValue($buyer->buyer);

                    $queryYearStatusBuyer = $buyerDeco->apply(clone $queryYearStatus);

                    $buyer->count = $queryYearStatusBuyer->count();

                    $buyer_admins = (clone $queryYearStatusBuyer)->select(DB::raw("buyer_admin,COALESCE(NULLIF(buyer_admin, ''),'Blanks') as buyer_admin_label "))->distinct()->orderby('buyer_admin','asc')->get();

                    foreach($buyer_admins as $buyer_admin)
                    {
                        $buyerAdminDeco = new BuyerAdminDecorator();
                        $buyerAdminDeco->setValue($buyer_admin->buyer_admin);

                        $queryYearStatusBuyerAdmin = $buyerAdminDeco->apply(clone $queryYearStatusBuyer);

                        $buyer_admin->count = $queryYearStatusBuyerAdmin->count();

                        $ba_record_status = (clone $queryYearStatusBuyerAdmin)->select(DB::raw("ba_record_status,COALESCE(NULLIF(ba_record_status, ''),'Blanks') as ba_record_status_label "))->distinct()->orderby('buyer','asc')->get();

                        foreach($ba_record_status as $ba_rec_stat)
                        {
                            $baRecordStatusDeco = new BARecordStatusDecorator();
                            $baRecordStatusDeco->setValue($ba_rec_stat->ba_record_status);

                            $queryYearStatusBuyerAdminBARecStatus = $baRecordStatusDeco->apply(clone $queryYearStatusBuyerAdmin);

                            $ba_rec_stat->count = $queryYearStatusBuyerAdminBARecStatus->count();

                        }

                        $buyer_admin->ba_rec_staus = $ba_record_status;

                    }

                    $buyer->buyer_admins = $buyer_admins;
      
                }

                $po_stat->buyer = $buyers;

            }

            $year->bi_status = $po_status;
        }

        return $years;
    }

    public function getPOStatus($po_status = null,$query)
    {
        if(!is_null($po_status)){
            
        }else{

        }
    }
}
