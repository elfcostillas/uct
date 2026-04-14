<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
            font-size : 9pt;
        }
    </style>
</head>
<body>
   <?php
        $total['ap_monthly'] =0;

        foreach($monthly_ap_report_vendor['months'] as $label){
            $total_by_month[$label->ap_month] = 0;
        }

        $total_by_month['g_total'] = 0;

        function setBlankOnZero($n)
        {
            return ($n == 0) ? '' : $n;
        }
   ?>
    <table border=1 style="border-collapse:collapse;width:100%;">
        <tr>
           
            @foreach($monthly_ap_report as $label)
                <td style="padding: 4px;text-align:center;font-weight:bold;">{{ $label['label'] }}</td>
            @endforeach
                <td style="padding: 4px;text-align:center;font-weight:bold;"> Grand Total </td>
        </tr>
        <tr>
        
            @foreach($monthly_ap_report as $count)
                <td style="padding: 4px;text-align:right;">{{ $count['count'] }}</td> 
                @php $total['ap_monthly'] += $count['count'];  @endphp
            @endforeach
                <td style="padding: 4px;text-align:right;">{{ $total['ap_monthly'] }}</td>
        </tr>
    </table> 

 <table border=1 style="margin-top:12px;border-collapse:collapse;width:100%;">
        <tr>
           
            <td style="padding: 4px;text-align:center;font-weight:bold;"> Vendor</td>
            @foreach($monthly_ap_report_vendor['months'] as $label)
                <td style="padding: 6px;text-align:center;font-weight:bold;"> {{ $monthly_ap_report_vendor['cols'][$label->ap_month] }}</td>
            @endforeach
                <td style="padding: 6px;text-align:center;font-weight:bold;">  Grand Total </td>
        </tr>

       @foreach($monthly_ap_report_vendor['vendors'] as $vendor)
            <tr>
                
                <td> {{ $vendor->vendor_label }} </td>
                <?php
                    $total_per_vendor[$vendor->vendor] = 0;
                ?>
                @foreach($monthly_ap_report_vendor['months'] as $label)
                    <td style="padding: 4px;text-align:right;">{{ setBlankOnZero($monthly_ap_report_vendor['data'][$vendor->vendor][$label->ap_month]) }}</td>
                    <?php
                        $total_per_vendor[$vendor->vendor] += $monthly_ap_report_vendor['data'][$vendor->vendor][$label->ap_month];
                        $total_by_month[$label->ap_month] += $monthly_ap_report_vendor['data'][$vendor->vendor][$label->ap_month];
                    ?>
                @endforeach
                <td style="padding: 4px;text-align:right;"> {{ setBlankOnZero($total_per_vendor[$vendor->vendor]) }} </td>
            </tr>
       @endforeach
        <tr>
            
            <td>Grand Total</td>
            @foreach($monthly_ap_report_vendor['months'] as $label)
                 <td style="padding: 4px;text-align:right;font-weight:bold;"> {{ $total_by_month[$label->ap_month] }}</td>
                @php $total_by_month['g_total'] += $total_by_month[$label->ap_month]; @endphp
            @endforeach
             <td style="padding: 4px;text-align:right;font-weight:bold;">{{ $total_by_month['g_total'] }} </td>
        </tr>
    </table>

    <table>
        <tr>
            <td></td>
        </tr>
    </table>

    @php
        $total_ap_report1 = 0;
        $total_ap_report2 = 0;
    @endphp

  

    <table style="width: 100%;">
        <tr>
            <td style="width:50%">
                <table border=1 style="width:98%;border-collapse:collapse;">
                    <tr>
                        <td colspan="2" >(Sorted by Vendor Name)</td>
                    </tr>
                    <tr>
                        
                        <td style="padding:4px;">Vendor</td>
                        <td style="padding:4px;">Ref No. Count</td>
                    </tr>
                    @foreach($ap_report->getCountByVendorData() as $vendor)
                    <tr>
                        
                        <td style="padding:4px;"> {{ $vendor->vendor }} </td>
                        <td style="padding:4px;text-align:right;"> {{ $vendor->ref_no_count }} </td>
                        @php $total_ap_report1+=$vendor->ref_no_count;  @endphp
                    </tr>
                    @endforeach
                    <tr>
                        
                        <td style="padding:4px;font-weight:bold;">Grand Total</td>
                        <td style="padding:4px;text-align:right;font-weight:bold;"> {{ $total_ap_report1 }}</td>
                    </tr>
                
                </table>
            </td>
            <td style="width:50%">
                <table border=1 style="width:98%;border-collapse:collapse;">
                    <tr>
                        <td colspan="2" >(Sorted by Ref No. Count)</td>
                    </tr>
                    <tr>
                       
                        <td style="padding:4px;">Vendor</td>
                        <td style="padding:4px;">Ref No. Count</td>
                    </tr>
                    @foreach($ap_report->getCountByVendorDataSorted() as $vendor)
                    <tr>
                       
                        <td style="padding:4px;"> {{ $vendor->vendor }} </td>
                        <td style="padding:4px;text-align:right;"> {{ $vendor->ref_no_count }} </td>
                        @php $total_ap_report2+=$vendor->ref_no_count;  @endphp
                    </tr>
                    @endforeach
                    <tr>
                       
                        <td style="padding:4px;font-weight:bold;">Grand Total</td>
                        <td style="padding:4px;text-align:right;font-weight:bold;"> {{ $total_ap_report2 }}</td>
                    </tr>
                
                </table>

            </td>
        </tr>
    </table>

   

    

</body>
</html>