<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            font-size: 10pt;
            font-family: Arial, Helvetica, sans-serif;
        }

        table tr td {
            padding : 2px 4px;
        }
    </style>
</head>
<body>

    @foreach($data as $year)
        <table border=1 style="border-collapse : collapse;">
            <tr>
                <td>YEAR</td>
                <td>BI STATUS</td>
                <td>BUYER</td>
                <td>BUYER ADMIN</td>
                <td>BA RECORD STATUS</td>
            </tr>
            <tr>
                <td> {{ $year->doc_year }} - {{ $year->count }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @foreach($year->bi_status as $bi_status)
                <tr>
                    <td></td>
                    <td> {{$bi_status->po_status }} - {{ $bi_status->count }} </td>
                    <td>  </td>
                    <td>  </td>
                    <td>  </td>
                </tr>
                @foreach($bi_status->buyer as $buyer)
                    <tr>
                        <td></td>
                        <td></td>
                        <td>{{ $buyer->buyer_label }} - {{ $buyer->count }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    @foreach($buyer->buyer_admins as $buyer_admin)
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td> {{ $buyer_admin->buyer_admin_label }} -  {{ $buyer_admin->count }} </td>
                            <td></td>
                        </tr>
                        @foreach($buyer_admin->ba_rec_staus as $rec_status)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td> {{ $rec_status->ba_record_status_label }} - {{ $rec_status->count }} </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        </table>
    @endforeach
</body>
</html>