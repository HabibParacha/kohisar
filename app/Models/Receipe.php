<?php

namespace App\Models;

use App\Models\ReceipeDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Receipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'is_active',
    ];
    public function receipeDetails()
    {
        return $this->hasMany(ReceipeDetail::class);
    }
}
