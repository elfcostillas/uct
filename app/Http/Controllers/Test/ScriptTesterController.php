<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScriptTesterController extends Controller
{
    //

    public function test()
    {
       $dates =  DB::table('data_src_history')->select('upload_date')->distinct()->get();

        foreach($dates as $date){
             /*
            $count = DB::table('data_src_history')->where('upload_date',$date->upload_date)->count();
           
            if($count == 0){
                echo "No data for date: " . $date->upload_date . "\n";
            }else{
                echo "Data exists for date: " . $date->upload_date . "\n";
            }
            */
           
    $uploadDate = $date->upload_date;

    $queries = [];

    // Base builder
    $buildQuery = function ($table, $label) use ($uploadDate) {
        return DB::table($table)
            ->select(DB::raw("CONCAT('$label ', upload_date, ' upload') AS remarks, COUNT(title) AS bi_count"))
            ->where('upload_date', $uploadDate)
            ->where('po_status', '2 - Pending')
            ->whereYear('created_date', 2025);
    };

    if ($uploadDate === '2026-04-02') {

        // only AFTER
        $queries[] = $buildQuery('data_src_after', 'after');

    } else {

        $queries[] = $buildQuery('data_src_before', 'before');
        $queries[] = $buildQuery('data_src_after', 'after');
    }

    // 👉 UNION AFTER IF/ELSE
    $finalQuery = array_shift($queries); // first query

    foreach ($queries as $q) {
        $finalQuery->unionAll($q);
    }

    $result = $finalQuery->get();

    // debug
    foreach ($result as $row) {
        echo $row->remarks . ' - ' . $row->bi_count  . "<br>";
    }
        }
    }
}
