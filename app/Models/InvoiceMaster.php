<?php

namespace App\Models;

use App\Models\Party;
use App\Models\InvoiceDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceMaster extends Model
{
    use HasFactory;

    protected $table = "invoice_master";

    protected $fillable = [
        'date',
        'due_date',
        'invoice_no',
        'vehicle_no',
        'status',
        'type',
        'party_id',
        'item_total',
        'shipping',
        'sub_total',
        'discount_type',
        'discount_value',
        'discount_amount',
        'total',
        'tax_type',
        'tax_rate',
        'grand_total',
        'description',
        'attachment'
    ];


    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function invoiceDetails(){
        return $this->hasMany(InvoiceDetail::class);
    }
}
