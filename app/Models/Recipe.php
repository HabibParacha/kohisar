<?php

namespace App\Models;

use App\Models\Item;
use App\Models\RecipeDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'name',
        'start_date',
        'start_time',
       
        'description',
        'total_quantity',
        'end_date',
        'end_time',
        'is_active',
        'created_by',
    ];

   

   



    public function recipeDetails()
    {
        return $this->hasMany(RecipeDetail::class);
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }

}
