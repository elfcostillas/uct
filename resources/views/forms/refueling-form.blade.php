<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @page {
            margin: 16px 16px;
        }


        * {
            font-size : 8pt;
        }

        table tr td {
            padding: 2px;
        }

        
    </style>
</head>
<body >
    @for($ctr=1;$ctr<=5;$ctr++)
      
    <table style="width:100%">
        <tr>
            <td>
        <div style="border: 1px solid black;width:100%%">
            <table style="width : 100%;" border=0>
                <tr>
                    <td colspan=4 style="text-align:center;font-weight:bold;font-size:10pt" >Fuel Withdrawal Slip</td>
                </tr>
            
                <tr>
                    <td style="width:23%"></td>
                    <td style="width:22%"></td>
                    <td style="width:10%;text-align: right;">Date:</td>
                    <td style="width:25%;">_________________</td>
                </tr>
                <tr>
                    <td style="width:23%">Vehicle Code </td>
                    <td style="width:22%;">:___________________</td>
                    <td colspan=2 rowspan="4" style="width:10%;text-align: right;">
                        <div style="padding-left:12px;width:100%;">
                            <table>
                                <tr>
                                    <td> <div style="border: 1px solid black;height:12px;width:12px;"></div> </td> <td> Unleaded - (Regular)</td>
                                </tr>
                                <tr>
                                    <td> <div style="border: 1px solid black;height:12px;width:12px;"></div> </td> <td> Unleaded - (Premium)</td>
                                </tr>
                                <tr>
                                    <td> <div style="border: 1px solid black;height:12px;width:12px;"></div> </td> <td> Unleaded - (High-Performance)</td>
                                </tr>
                                <tr>
                                    <td> <div style="border: 1px solid black;height:12px;width:12px;"></div> </td> <td> Diesel </td>
                                </tr>
                            </table>
                        
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width:23%">Hour Meter Reading </td>
                    <td style="width:22%;">:___________________</td>
                    
                </tr>
                <tr>
                    <td style="width:23%">Odometer Reading </td>
                    <td style="width:22%;">:___________________</td>
                    
                </tr>
                <tr>
                    <td style="width:23%">No. of Liters </td>
                    <td style="width:22%;">:___________________</td>
                
                </tr>
                <tr>
                    <td colspan="4" style="height:40px;text-align:center;vertical-align:bottom;">
                        ___________________________________ <br>
                                Driver's Name / Signature
                    </td>
                </tr>
                
            </table>
        </div>
            </td>
            <td>
         <div style="border: 1px solid black;width:100%%">
            <table style="width : 100%;" border=0>
                <tr>
                    <td colspan=4 style="text-align:center;font-weight:bold;font-size:10pt" >Fuel Withdrawal Slip</td>
                </tr>           
            
                <tr>
                    <td style="width:23%"></td>
                    <td style="width:22%"></td>
                    <td style="width:10%;text-align: right;">Date:</td>
                    <td style="width:25%;">_________________</td>
                </tr>
                <tr>
                    <td style="width:23%">Vehicle Code </td>
                    <td style="width:22%;">:___________________</td>
                    <td colspan=2 rowspan="4" style="width:10%;text-align: right;">
                        <div style="padding-left:12px;width:100%;">
                            <table>
                                <tr>
                                    <td> <div style="border: 1px solid black;height:12px;width:12px;"></div> </td> <td> Unleaded - (Regular)</td>
                                </tr>
                                <tr>
                                    <td> <div style="border: 1px solid black;height:12px;width:12px;"></div> </td> <td> Unleaded - (Premium)</td>
                                </tr>
                                <tr>
                                    <td> <div style="border: 1px solid black;height:12px;width:12px;"></div> </td> <td> Unleaded - (High-Performance)</td>
                                </tr>
                                <tr>
                                    <td> <div style="border: 1px solid black;height:12px;width:12px;"></div> </td> <td> Diesel </td>
                                </tr>
                            </table>
                        
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width:23%">Hour Meter Reading </td>
                    <td style="width:22%;">:___________________</td>
                    
                </tr>
                <tr>
                    <td style="width:23%">Odometer Reading </td>
                    <td style="width:22%;">:___________________</td>
                    
                </tr>
                <tr>
                    <td style="width:23%">No. of Liters </td>
                    <td style="width:22%;">:___________________</td>
                
                </tr>
                <tr>
                    <td colspan="4" style="height:40px;text-align:center;vertical-align:bottom;">
                        ___________________________________ <br>
                                Driver's Name / Signature
                    </td>
                </tr>
                
            </table>
        </div>               
            </td>
        </tr>
    </table>
    
    @endfor
    
</body>
</html>