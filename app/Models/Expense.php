<?php

namespace App\Models;

use App\Models\Party;
use App\Models\ExpenseDetail;
use App\Models\ChartOfAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'expense_no',
        'chart_of_account_id',
        'party_id',
        'description',
        'amount_exclusive_tax',
        'tax_percentage',
        'calculated_tax_amount',
        'amount_inclusive_tax',
        'attachment',
        'creator_id'
    ];

    public function details(){
        return $this->hasMany(ExpenseDetail::class);
    }

    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccount::class);
    }
    
    public function party()
    {
        return $this->belongsTo(Party::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Party::class)->where('party_type','supplier');
    }
    
}
