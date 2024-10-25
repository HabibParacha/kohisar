<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Unit;
use App\Models\Receipe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReceipeDetail extends Model
{
    use HasFactory;
    protected $table = 'receipe_detail';

    protected $fillable = [
        'receipe_master_id',
        'item_id',
        'unit_id',
        'quantity',
    ];

    public function receipe()
    {
        return $this->belongsTo(Receipe::class);
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
