<?php

namespace App\Models;

use App\Models\InvoiceDetail;
use App\Models\RecipeDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type',
        'sell_price',
        'purchase_price',
        'stock_alert_qty',
        'unit_weight',

        'unit_id',
        'tax_id',
        'brand_id',
        'category_id',
        'warehouse_id',

        'sell_cart_of_account_id',
        'purchase_cart_of_account_id',

        'is_active',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // public function variation()
    // {
    //     return $this->belongsTo(Variation::class);
    // }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function invoiceDetails(){
        return $this->hasMany(InvoiceDetail::class);
    }
    public function recipeDetails(){
        return $this->hasMany(RecipeDetail::class);
    }

    
}
