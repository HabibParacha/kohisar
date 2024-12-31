<?php

namespace App\Models;

use App\Models\Party;
use App\Models\Recipe;
use App\Models\InvoiceDetail;
use App\Models\PartyWarehouse;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceMaster extends Model
{
    use HasFactory;

    protected $table = "invoice_master";

    protected $fillable = [
        'date',
        'due_date',
        'expiry_date',
        'invoice_no',
        'reference_no',
        'batch_no',
        'vehicle_no',
        'status',
        'type',
        'recipe_id',
        'party_id',
        'saleman_id',
        'party_warehouse_id',
        'item_total',
        'total',
        'total_bags',

        'empty_bag_weight',
        'bag_type_id',
        'bag_type_name',
        'total_net_weight',
        'total_gross_weight',


        'production_material_tons',
        
        'sub_total_stock',
        'sub_total',
        
        'discount_type',
        'discount_value',
        'discount_amount',
        
        'tax_type',
        'tax_rate',
        'tax_amount',
        
        'wth_tax_rate',
        'wth_tax_amount',
        
        'commission_rate',
        'commission_amount',
        
        'is_x_freight',
        'shipping_type',
        'shipping',
        
        'grand_total',
        
        'production_qty',
        'output_qty',
        'surplus_qty',
        
        'output_bags',
        'surplus_bags',

        'created_by',
        
        'description',
        'attachment',

        'is_lock',
    ];


    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function invoiceDetails(){
        return $this->hasMany(InvoiceDetail::class);
    }

    public function productionDetails(){
        return $this->hasMany(InvoiceDetail::class)->where('type','production');
    }
    public function outputDetails(){
        return $this->hasMany(InvoiceDetail::class)->where('type','output');
    }
   
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
    public function saleman()
    {
        // Define a relationship indicating that this model belongs to a User
        //using 'saleman_id' as the foreign key referencing the User's 'id'.
        return $this->belongsTo(User::class,'saleman_id');
    }
    
    public function partyWarehouse()
    {
        return $this->belongsTo(PartyWarehouse::class);
    }

    



    // $newInvoiceNo = InvoiceMaster::generateInvoiceNo('PRO','production');
    public static function generateInvoiceNo($prefix, $type)
    {
        // Fetch the maximum numeric part of the invoice_no, increment it by 1
        // SUBSTRING_INDEX extracts the numeric part after the last '-'
        // CAST converts it to an integer for comparison
        $max_invoice_no = DB::table('invoice_master')
            ->select(DB::raw("MAX(CAST(SUBSTRING_INDEX(invoice_no, '-', -1) AS UNSIGNED) + 1) as maximum"))
            ->where('type', $type) // Filter by type (e.g., 'receipt')
            ->value('maximum');
    
        // Check if there is an existing invoice number
        if ($max_invoice_no != null) {
            // If a maximum exists, create the new invoice number by appending the incremented value to the prefix
            $new_invoice_no = $prefix . '-' . $max_invoice_no;
            return $new_invoice_no;
        } else {
            // If no existing invoice, create the first invoice number with the prefix and start from '1'
            $new_invoice_no = $prefix . '-' . '1';
            return $new_invoice_no;
        }
    }
    

}
