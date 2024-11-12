<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_code',
        'account_name',
        'description',
        'level',
        'parent_id',
        'type',
        'category',
        'is_lock',
        'is_active',
    ];

      // Define a relationship for the parent account
      public function parent()
      {
          return $this->belongsTo(ChartOfAccount::class, 'parent_id');
      }
  
      // Define a relationship for child accounts
      public function children()
      {
          return $this->hasMany(ChartOfAccount::class, 'parent_id');
      }
}
