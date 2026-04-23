<?php

namespace App\Models\UCT;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class PendingPo extends Model
{
    use LogsActivity;
    
    protected $table = 'data_src';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'created_date',
        'po_no',
        'po_line_no',
        'po_status',
        'vendor',
        'invoice_link',
        'vendor_email',
        'ap_person',
        'invoice_name',
        'invoice_value',
        'currency',
        'buyer',
        'record_issue',
        'ba_group',
        'buyer_admin',
        'ba_record_status',
        'ba_comments',
        'date_reviewed_ba',
        'date_resolved_ba',
        'buyer_comments',
        'ap_comments',
        'auto_update',
        'item_type',
        'path',
        'created_year',
        'ppv_var'
    ];

    public $timestamps = false;

}
