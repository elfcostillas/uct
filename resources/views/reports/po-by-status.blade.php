<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   

    @foreach($data as $po_status)
        <table border=1 style="border-collapse: collapse; width : 400px;margin-bottom: 12px;">
            <tr>
                <td colspan="3"> {{ $po_status->getPOStatus() }} : {{ $po_status->getCount() }} </td>
            </tr>
            
            @foreach($po_status->getBAGroup() as $key =>$value)
                <tr>
                    <td style="width:32px"></td>
                    <td> BA Group > {{ ($value->ba_group =='' ? 'Blanks' : $value->ba_group ) }} : {{ $po_status->getPOByStatusAndBAGroupCount($value->ba_group) }} </td>
                </tr>
                @foreach($po_status->getBaGroupsBuyerAdmin($value->ba_group) as $admins)
                    <tr>
                        <td></td>
                        <td></td>
                        <td> Buyer Admin > {{ ($admins->buyer_admin=='') ? 'Blanks': $admins->buyer_admin }} : {{ $po_status->getBuyerAdminCount($admins->buyer_admin)->count() }}</td>
                        
                    </tr>
                @endforeach
            @endforeach
        </table>
    @endforeach
</body>
</html>