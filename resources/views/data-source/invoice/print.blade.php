<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    
    <style>
        @page {
            margin : 144px 28px;
        }
        
        * {
            font-size : 8pt;
            font-family: Arial, Helvetica, sans-serif;
        }

        .dpad {
            padding : 4px;
        }

        .b {
            font-weight: bold;
        }

        .c {
            text-align: center;
        }

        .r {
            text-align: right;
        }

        .l {
            text-align: left;
        }

        .header {
            background-color: #DCE9F1;
        }
    </style>

    <?php
        use Carbon\Carbon;

        $invoice_total = 0;
    
    ?>
</head>
<body>
    <table border=0 style="border-collapse:collapse;width:100%">
        <tr>
            <td style="width:35%;"></td>
          
            <td style="font-size:32px;color:#4F90BB;text-align:center">INVOICE</td>
         
            <td style="width:35%;"></td>
        </tr>
    </table>
    <table border=0 style="margin:32px 0px;border-collapse:collapse;width:100%">
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="b r" style="width:112px">INVOICE # :</td>
            <td class="l" style="width:112px;padding-left:14px"> {{ $header['invoice_no'] }}</td>
        </tr>
        <tr>
            <td class="" >BILL TO: </td>
            <td></td>
            <td></td>
            <td></td>
            <td class="b r" style="width:112px">DATE :</td>
            <td class="l" style="width:112px;padding-left:14px"> {{ $header['date'] }}</td>
        </tr>
        <tr>
            <td colspan="3" style="padding-left: 24px;" class="b">Ultra Clean Technology Systems and</td>
          
            <td></td>
            <td class="b r" style="width:112px">DUE DATE :</td>
            <td class="l" style="width:112px;padding-left:14px"> {{ $header['due_date'] }}</td>
        </tr>
        <tr>
            <td colspan="3" style="padding-left: 38px " class="">
                26462 Corporate Ave Hayward CA 94545 USA
            </td>
            <td></td>
            <td class="b r" style="width:112px">TERMS :</td>
            <td class="l" style="width:112px;padding-left:14px"> {{ $header['terms'] }}</td>
        </tr>
    </table>
    <table border=0 style="margin : 32px 0px;width: 100%;">
        <tr>
            <td>SHIP TO :</td>
            <td></td>
            <td style="width:5%" ></td>
            <td>FROM :</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left:24px" class="b">Ultra Clean Technology Systems and </td>
           
            <td></td>
            <td colspan="2" style="padding-left:24px" class="b">Integrated Flow System LLC</td>
        </tr>
        <tr>
            <td style="padding-left:38px" colspan="2">600 Center Ridge Drive, Suite 150 Austin TX,</td>
            <td></td>
            <td colspan="2" style="padding-left:38px" class=""> KH Compound, MEPZ 1, Ibo, Lapu-Lapu City, Cebu, </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left:38px" >78753, USA</td>
            <td></td>
            <td colspan="2" style="padding-left:38px" class=""> Philippines, +63 (032) 494-0662</td>
        </tr>
       
    </table>
    <table border="1" style="border-collapse:collapse;width:100%">
        <tr>
            <td style="width:56px;" class="dpad c b header">DATE</td>
            <td style="width:66px;" class="dpad c b header">PART #</td>
            <td class="dpad c b header">DESCRIPTION</td>
            <td class="dpad c b header">DMS PO #</td>
            <td class="dpad c b header">PO LINE</td>
            <td class="dpad c b header">PACKINGSLIP #</td>
            <td style="width:42px;" class="dpad c b header">QTY</td>
            <td style="width:56px;" class="dpad c b header">UNIT PRICE</td>
            <td style="width:56px;" class="dpad c b header">TOTAL PRICE</td>
        </tr>

        @foreach($data as $row)
        <tr>
            <td class="dpad c">{{ Carbon::createFromFormat('Y-m-d',$row->ship_date)->format('Y-m-d') }}</td>
            <td class="dpad c">{{ $row->part_number }}</td>
            <td class="dpad l">{{ $row->description }}</td>
            <td class="dpad r">{{ $row->po_number }}</td>
            <td class="dpad r">{{ $row->po_line }}</td>
            <td class="dpad c">{{ $row->packing_slip }}</td>
            <td class="dpad r">{{ number_format($row->shipped_qty,2) }}</td>
            <td class="dpad r"><span class="margin-right:24px;" >$ </span> {{ number_format($row->unit_price ,2)}}</td>
            <td class="dpad r"><span class="margin-right:24px;" >$ </span> {{ number_format($row->total_price,2) }}</td>
            <?php
                $invoice_total += $row->total_price;
            ?>
        </tr>
        @endforeach
    </table>
    <table border="0" style="border-collapse:collapse;width:100%">
        <tr>
            <td colspan="3" style="height : 42px"> </td>
        </tr>
        <tr>
            <td style="width: 472px;"></td>
            <td style="width: 142px;font-size:13px;" class="dpad b r">TOTAL AMOUNT : </td>
            <td class="dpad r b" style="border-bottom:4px double black;font-size:13px !important;">$ {{ number_format($invoice_total,2) }}</td>
        </tr>
    </table>
</body>
</html>