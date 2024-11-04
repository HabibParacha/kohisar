<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Unit;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecipeDetail extends Model
{
    use HasFactory;
    protected $table = 'recipe_detail';

    protected $fillable = [
        'recipe_master_id',
        'item_id',
        'unit_id',
        'quantity',
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

}
