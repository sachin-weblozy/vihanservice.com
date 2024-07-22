<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory; use SoftDeletes;

    protected $fillable = [
        'type',
        'createdby_id',
        'ticket_id',
        'report_number',
        'machine_model',
        'machine_serialno',
        'cust_name',
        'invoice_number',
        'invoice_date',
        'purchase_order',
        'purchase_order_date',
        'service_mode',
        'asset_number',
        'installation_date',
        'location',
        'under_warranty',
        'warranty_period',
        'amc_required',
        'installation_notes',
        'spare_parts',
        'customer_notes',
        'eng1_name',
        'eng1_phone',
        'eng1_sign',
        'eng2_name',
        'eng2_phone',
        'eng2_sign',
        'eng3_name',
        'eng3_phone',
        'eng3_sign',
        'eng4_name',
        'eng4_phone',
        'eng4_sign',
        'cust1_name',
        'cust1_phone',
        'cust1_sign',
        'cust2_name',
        'cust2_phone',
        'cust2_sign',
        'cust3_name',
        'cust3_phone',
        'cust3_sign',
        'cust4_name',
        'cust4_phone',
        'cust4_sign',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'id');
    }
}
