<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php
      
        /*
         "dates" => 
Illuminate\Support
\
Collection
 {#2301 ▶}
  "vendors" => 
Illuminate\Support
\
Collection
 {#1915 ▶}
  "pending" => array:779 [▶]
  "processed" => array:779 [▶]
  */

    ?>

    <style>
        * {
            font-size: 10pt;
            font-family: Arial, Helvetica, sans-serif;
        
        }

        table tr td {
            padding: 2px;
        }
    </style>
</head>
<body>
    <table border=1 style="border-collapse:collapse;">
        <tr>
            <td>Vendor</td>
            @foreach($data['dates'] as $date)
                <td colspan="2" > {{ $date->upload_date }}</td>
            @endforeach
        </tr>
        @foreach($data['vendors'] as $vendor)
            <tr>
                <td >{{ $vendor->vendor }}</td>
                @foreach($data['dates'] as $iDate)
                    <td style="text-align:center;width: 80px;background-color: orange;"> {{ $data['pending'][$vendor->vendor][$iDate->upload_date] }} </td>
                    <td style="text-align:center;width: 80px;background-color: #03AC13;"> {{ $data['processed'][$vendor->vendor][$iDate->upload_date] }} </td>
                @endforeach
            </tr>
        @endforeach
    </table>
</body>
</html>