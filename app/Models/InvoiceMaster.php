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
        'party_id',
        'recipe_id',
        'saleman_id',
        'party_warehouse_id',
        'item_total',
        'shipping',
        'sub_total',
        'discount_type',
        'discount_value',
        'discount_amount',
        'total',
        'production_material_tons',
        'tax_type',
        'tax_rate',
        'grand_total',

        'production_qty',
        'output_qty',
        'surplus_qty',
        
        'description',
        'attachment',
        'creator_id'
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
    public static function generateInvoiceNo($prefix,$type){
        
        $max_invoice_no = DB::table('invoice_master')
        ->where('type',$type)
        ->max('invoice_no');
        
        
        //if record exist
        if($max_invoice_no)
        {
            // Split by '-' and get the second part (the numeric part) +1
            $get_invoice_digits = (int)  explode('-', $max_invoice_no)[1] + 1;

            $new_invoice_no =  $prefix.'-'.$get_invoice_digits;

            return $new_invoice_no;
        }
        else{ 
            $new_invoice_no = $prefix.'-'.'1';
            return $new_invoice_no;// first invoice no
        }  
    }
}
