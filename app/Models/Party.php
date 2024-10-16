<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;

    protected $fillable = [
        'party_type',
        'type',
        'business_name',
        'name',
        'prefix',
        'first_name',
        'middle_name',
        'last_name',
        'mobile',
        'alternate_number',
        'landline',
        'email',
        'tax_number',
        'opening_balance',
        'pay_term_type',
        'credit_limit',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'country',
        'zip_code',
        'shipping_address',
        'is_active',
        'is_default'
    ];
    
}
