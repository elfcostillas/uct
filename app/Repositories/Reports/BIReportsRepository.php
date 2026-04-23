<?php

namespace App\Repositories\Reports;

use Illuminate\Support\Facades\DB;

class BIReportsRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function getAllVendor()
    {
        // return DB::table('data_src')->select('vendor')->distinct()->orderBy('vendor','asc')->get();

        $after = DB::table('data_src_after')->select(DB::raw("COALESCE(NULLIF(BINARY vendor, ''), 'Blanks')"))->groupBy(DB::raw("BINARY vendor"));
        $before = DB::table('data_src_before')->select(DB::raw("COALESCE(NULLIF(BINARY vendor, ''), 'Blanks')"))->groupBy(DB::raw("BINARY vendor"));
        // $before = DB::table('data_src_before')->select(DB::raw("COALESCE(NULLIF(BINARY vendor, '') as vendor"))->distinct();
        // $before = DB::table('data_src_before')->select('vendor')->distinct();

        
        // return DB::table('data_src')->select(DB::raw(" COALESCE(NULLIF(BINARY vendor, ''), 'Blanks') as BINARY vendor"))->groupBy('BINARY vendor')->orderBy('vendor','asc')->get();
        return DB::table('data_src')
                ->selectRaw("COALESCE(NULLIF(BINARY vendor, ''), 'Blanks') as vendor")
                ->groupByRaw("BINARY vendor")
                ->orderBy('vendor', 'asc')
                ->union($after)
                ->union($before)
                ->orderBy('vendor','asc')
                ->get();
    }

    public function getDatesBeforeUpload($year)
    {
        $result = DB::table('data_src_before')
            ->select('upload_date')
            ->distinct();

        if($year != null)
        {
          
            $result->whereRaw("year(upload_date) = ?",[$year]);
        }

        return $result->get();


    }

    public function getYears()
    {
        return DB::table('data_src_history')
                ->select(DB::raw("YEAR(created_date) AS fy_year"))
                ->distinct()
                ->orderBy('fy_year','DESC')
                ->get();
    }

    public function getDeletedRow($date_filter)
    {
        return  DB::table('data_src_after')
            ->where('upload_date', $date_filter)
            ->whereNotIn('title', function ($query) use ($date_filter) {
                $query->select('title')
                    ->distinct()
                    ->from('data_src_history')
                    ->where('upload_date', $date_filter);
            })
            ->get();
    }

    public function getDatesAfterUpload($year)
    {

    }

    public function getDailyChanges($date)
    {



        $pending = DB::table('data_src_after as a')
            ->selectRaw("COALESCE(NULLIF(a.vendor, ''),'Blanks') as vendor, COUNT(a.title) as pending,0 as ref_count")
            ->where('a.po_status', '2 - Pending')
            ->where('a.upload_date', $date)
            ->whereNotIn('a.title', function ($query) use ($date) {
                $query->select('title')
                    ->from('data_src_before')
                    ->where('upload_date', $date);
            })
            ->groupBy(DB::raw('BINARY a.vendor'));

        $processed =  DB::table('data_src_after as data_after')
            // ->selectRaw('data_after.vendor,0 as pending, COUNT(data_after.title) as ref_count')
            ->selectRaw("COALESCE(NULLIF(data_after.vendor, ''),'Blanks') as vendor,0 as pending, COUNT(data_after.title) as ref_count")
            ->leftJoin('data_src_before as data_before', function ($join) use ($date) {
                $join->on('data_after.title', '=', 'data_before.title')
                    ->where('data_before.upload_date', $date);
            })
            ->where('data_after.upload_date', $date)
            ->where('data_after.po_status', '3 - Processed')
            ->whereColumn('data_after.po_status', '!=', 'data_before.po_status')
            ->groupBy('data_after.vendor');

            return DB::query()
                ->fromSub(
                    $pending->unionAll($processed),
                    'x'
                )
                ->selectRaw("
                    vendor,
                    SUM(pending) as pending_count,
                    SUM(ref_count) as processed_changed_count
                ")
                ->groupBy(DB::raw("BINARY vendor"))
                ->orderBy('vendor', 'asc')
                ->get();

        // return DB::table('data_src_after as a')
        //     ->leftJoin('data_src_before as b', function ($join) use ($date) {
        //         $join->on('a.title', '=', 'b.title')
        //             ->where('b.upload_date', $date);
        //     })
        //     ->where('a.upload_date', $date)
        //     ->select(
        //         // 'a.vendor',
        //         DB::raw("COALESCE(NULLIF(a.vendor, ''), 'Blanks') as vendor"),
        //         DB::raw("
        //             SUM(
        //                 CASE 
        //                     WHEN a.po_status = '3 - Processed' 
        //                     AND a.po_status != b.po_status 
        //                     THEN 1 ELSE 0 
        //                 END
        //             ) as processed_changed_count
        //         "),

        //         DB::raw("
        //             SUM(
        //                 CASE 
        //                     WHEN a.po_status = '2 - Pending' 
        //                     THEN 1 ELSE 0 
        //                 END
        //             ) as pending_count
        //         ")
        //     )
        //     ->groupBy(DB::raw("BINARY a.vendor"))
        //     ->orderBy('a.vendor','asc')
        //     ->get();
    }
}


/*
SELECT DISTINCT YEAR(created_date) AS fy_year  FROM data_src_history ORDER BY fy_year DESC;
*/

