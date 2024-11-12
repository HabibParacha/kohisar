<?php

namespace App\Models;

use App\Models\Expense;
use App\Models\ChartOfAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_id',
        'date',
        'expense_no',
        'chart_of_account_id',
        'description',
        'amount_exclusive_tax',
        'tax_percentage',
        'calculated_tax_amount',
        'amount_inclusive_tax',
    ];

    public function expense(){
        return $this->belongsTo(Expense::class);
    }

    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccount::class);
    }
}
