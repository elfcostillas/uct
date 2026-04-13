<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <table border=1>
        <tr>
            <td></td>
            <td></td>
            @foreach($monthly_ap_report as $label)
                <td>{{ $label['label'] }}</td>
            @endforeach
                <td> Grand Total </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            @foreach($monthly_ap_report as $count)
                <td>{{ $count['count'] }}</td> 
                @php $total['ap_monthly'] += $count['count'];  @endphp
            @endforeach
                <td>{{ $total['ap_monthly'] }}</td>
        </tr>
    </table> 
    <table>
        <tr>
            <td></td>
        </tr>
    </table>
   
    <table border=1>
        <tr>
            <td></td>
            <td>Vendor</td>
            @foreach($monthly_ap_report_vendor['months'] as $label)
                <td>{{ $monthly_ap_report_vendor['cols'][$label->ap_month] }}</td>
            @endforeach
                <td> Grand Total </td>
        </tr>

       @foreach($monthly_ap_report_vendor['vendors'] as $vendor)
            <tr>
                <td></td>
                <td> {{ $vendor->vendor_label }} </td>
                <?php
                    $total_per_vendor[$vendor->vendor] = 0;
                ?>
                @foreach($monthly_ap_report_vendor['months'] as $label)
                    <td>{{ setBlankOnZero($monthly_ap_report_vendor['data'][$vendor->vendor][$label->ap_month]) }}</td>
                    <?php
                        $total_per_vendor[$vendor->vendor] += $monthly_ap_report_vendor['data'][$vendor->vendor][$label->ap_month];
                        $total_by_month[$label->ap_month] += $monthly_ap_report_vendor['data'][$vendor->vendor][$label->ap_month];
                    ?>
                @endforeach
                <td> {{ $total_per_vendor[$vendor->vendor] }} </td>
            </tr>
       @endforeach
        <tr>
            <td></td>
            <td>Grand Total</td>
            @foreach($monthly_ap_report_vendor['months'] as $label)
                <td> {{ $total_by_month[$label->ap_month] }}</td>
                @php $total_by_month['g_total'] += $total_by_month[$label->ap_month]; @endphp
            @endforeach
            <td> {{ $total_by_month['g_total'] }} </td>
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

     <table>
        <tr>
            <td colspan="3" >(Sorted by Vendor Name)</td>
        </tr>
        <tr>
            <td></td>
            <td>Vendor</td>
            <td>Ref No. Count</td>
        </tr>
        @foreach($ap_report->getCountByVendorData() as $vendor)
        <tr>
            <td></td>
            <td> {{ $vendor->vendor }} </td>
            <td> {{ $vendor->ref_no_count }} </td>
            @php $total_ap_report1+=$vendor->ref_no_count;  @endphp
        </tr>
        @endforeach
        <tr>
            <td></td>
            <td>Grand Total</td>
            <td> {{ $total_ap_report1 }}</td>
        </tr>
    
    </table>

    <table>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="3" >(Sorted by Ref No. Count)</td>
        </tr>
        <tr>
            <td></td>
            <td>Vendor</td>
            <td>Ref No. Count</td>
        </tr>
        @foreach($ap_report->getCountByVendorDataSorted() as $vendor)
        <tr>
            <td></td>
            <td> {{ $vendor->vendor }} </td>
            <td> {{ $vendor->ref_no_count }} </td>
            @php $total_ap_report2+=$vendor->ref_no_count;  @endphp
        </tr>
        @endforeach
        <tr>
            <td></td>
            <td>Grand Total</td>
            <td> {{ $total_ap_report2 }}</td>
        </tr>
    
    </table>

    

</body>
</html>