<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ScriptController extends Controller
{
    //

    public function copyEmployees()
    {
        $employees = DB::connection('mariadb_hris')
                ->table('employees')
                ->select(DB::raw("employees.id as emp_id,biometric_id,concat(lastname,', ',firstname ,' ',if(trim(middlename)!='',concat(SUBSTR(IFNULL(middlename,''),1,1),'.'),''),' ',IFNULL(suffixname,'') ) as employee_name,job_titles.job_title_name"))
                ->leftJoin('job_titles','employees.job_title_id','=','job_titles.id')
                ->get();

        foreach($employees as $employee){
            DB::table('employees')->upsert(
                $employee->toArray(),
                ['emp_id'],
                ['biometric_id','employee_name','job_title_name']
            );
        }
    }

    public function copySuppliers()
    {
        // $suppliers = DB::connection('sqlsrv')
        //         ->table('OCRD')
        //         ->get();
        
        // foreach($suppliers as $supplier){
        //     dd($supplier);
        // }

        // http://172.17.56.111/sap_api/api/master-files/business-partners/bplist/S

        $response = Http::get('http://172.17.56.111/sap_api/api/master-files/business-partners/bplist/S');

        $data = $response->json();

        foreach($data as $supplier){
            DB::table('suppliers')->upsert(
                [
                    'supplier_code' => $supplier['CardCode'],
                    'supplier_name' => $supplier['CardName'],
                    'supplier_address' => $supplier['Address'],
                ],
                ['supplier_code'],
                ['supplier_name'],
                ['supplier_address'],
            );
        }

    }

    public function copyItems() {
        $response = Http::get('http://172.17.56.111/sap_api/api/master-files/items/all');

        $data = $response->json();

        $arr = [];

        foreach($data as $item){
            array_push($arr,['item_code' => trim($item['ItemCode']), 'item_name' => trim($item['ItemName'])]) ;
        }

        DB::table('sap_oitm')->insert($arr);

    }
}

/*
   // DB::table('sap_oitm')->upsert(
            //     [
            //         'item_code' => trim($item['ItemCode']),
            //         'item_name' => trim($item['ItemName']),
            //     ],
            //     ['item_code'],
            //     ['item_name']
            // );*/