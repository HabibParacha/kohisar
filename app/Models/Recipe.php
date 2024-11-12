<?php

namespace App\Models;

use App\Models\RecipeDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'total_quantity',
        'creator_id',
        'is_active',
    ];
    public function recipeDetails()
    {
        return $this->hasMany(RecipeDetail::class);
    }
}
