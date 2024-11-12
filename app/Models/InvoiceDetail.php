<?php

namespace App\Models;

use App\Models\Item;
use App\Models\InvoiceMaster;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceDetail extends Model
{
    use HasFactory;

    protected $table = 'invoice_detail';

    protected $fillable = [
        'invoice_master_id',
        'date',
        'invoice_no',
        'type',
        'item_id',
        'unit_weight',
        'gross_weight',
        'cut_percentage',
        'cut_value',
        'after_cut_total_weight',
        'total_quantity',
        'per_package_weight',
        'total_package_weight',
        'net_weight',
        'is_surplus',

        'per_unit_price',
        'per_unit_price_old_value',
        'per_unit_price_new_value',
        
        'total_price',
        'discount_type',
        'discount_value',
        'discount_amount',
        'after_discount_total_price',
        'tax_rate',
        'tax_value',
        'grand_total'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function invoiceMaster()
    {
        return $this->belongsTo(InvoiceMaster::class);
    }
  
}
