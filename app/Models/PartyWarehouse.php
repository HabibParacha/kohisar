<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyWarehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'party_id',
        'name',
        'location',
        'city',
    ];
}
