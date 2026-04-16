<?php

namespace App\Models\UCT;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use LogsActivity;

    protected $table = 'invoice_data_src';

    protected $primaryKey = 'line_id';

    protected $fillable = [
        'customer',
        'part_number',
        'ship_date',
        'description',
        'shipped_qty',
        'unit_price',
        'total_price',
        'plant',
        'po_number',
        'po_line',
        'packing_slip',
        'tracking_no',
        'invoice_no',
        'remarks',
    ];

    public $timestamps = false;
}
