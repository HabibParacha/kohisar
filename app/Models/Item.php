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


    public static function averageCost($item_id)
    {
        $transactions = InvoiceDetail::select('id','item_id','date','type','net_weight','total_price_stock')
        ->where('item_id',$item_id)
        ->whereIn('type',['receipt','production'])
        ->orderBy('date','asc')
        ->orderBy('id','asc')
        ->get();

        $stock_weight = 0;
        $stock_value = 0;
        $avg_cost = 0;


        if($transactions->sum('net_weight') > 0)
        {
            foreach($transactions as $transaction)
            {

                if($transaction->type == 'receipt')
                {
                    $stock_value += $transaction->total_price_stock;
                    $stock_weight += $transaction->net_weight;

                    if($stock_weight > 0)
                        $avg_cost = $stock_value / $stock_weight;
                    
                }
                else if($transaction->type == 'production')
                {           
                    $stock_value -= $transaction->net_weight * $avg_cost;
                    $stock_weight -= $transaction->net_weight;
     
                }

            }
        }
       
        $data = [
            'qty_in' => $transactions->where('type', 'receipt')->sum('net_weight'),
            'qty_out' => $transactions->where('type', 'production')->sum('net_weight'),
            'balance' => $stock_weight,
            'avg_cost' => round($avg_cost,2),
            'stock_value' => round($stock_weight * $avg_cost,2),
        ];
        

        return $data;


    }

    
}
