<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChartOfAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

         //100000
        // Main asset account
        $assets = DB::table('chart_of_accounts')->insertGetId([ 'account_code' => '100000', 'account_name' => 'Assets', 'level' => 1, 'type' => 'asset']);
        // Subcategories under Assets
        $currentAssets = DB::table('chart_of_accounts')->insertGetId(['account_code' => '110000', 'account_name' => 'Current Assets', 'level' => 2, 'parent_id' => $assets, 'type' => 'asset']);
        $fixedAssets = DB::table('chart_of_accounts')->insertGetId(['account_code' => '120000', 'account_name' => 'Fixed Assets', 'level' => 2, 'parent_id' => $assets, 'type' => 'asset']);
        $otherAssets = DB::table('chart_of_accounts')->insertGetId(['account_code' => '130000', 'account_name' => 'Other Assets', 'level' => 2, 'parent_id' => $assets, 'type' => 'asset']);



        //200000
        // Main liabilities account
        $liabilities = DB::table('chart_of_accounts')->insertGetId(['account_code' => '200000', 'account_name' => 'Liabilities', 'level' => 1, 'type' => 'liability']);
        // Subcategories under Liabilities
        $currentLiabilities = DB::table('chart_of_accounts')->insertGetId(['account_code' => '210000', 'account_name' => 'Current Liabilities', 'level' => 2, 'parent_id' => $liabilities, 'type' => 'liability']);
        $longTermLiabilities = DB::table('chart_of_accounts')->insertGetId(['account_code' => '220000', 'account_name' => 'Long-term Liabilities', 'level' => 2, 'parent_id' => $liabilities, 'type' => 'liability']);
        
        //300000
        // Main equity account
        $equity = DB::table('chart_of_accounts')->insertGetId(['account_code' => '300000', 'account_name' => 'Equity', 'level' => 1, 'type' => 'equity']);
        // Subcategories under Equity
        $ownersEquity = DB::table('chart_of_accounts')->insertGetId(['account_code' => '310000', 'account_name' => "Owner's Equity", 'level' => 2, 'parent_id' => $equity, 'type' => 'equity']);
        $retainedEarnings = DB::table('chart_of_accounts')->insertGetId(['account_code' => '320000', 'account_name' => 'Retained Earnings', 'level' => 2, 'parent_id' => $equity, 'type' => 'equity']);


        //400000
        // Main revenue account
        $revenue = DB::table('chart_of_accounts')->insertGetId(['account_code' => '400000', 'account_name' => 'Revenue', 'level' => 1, 'type' => 'revenue']);
        // Subcategories under Revenue
        $salesRevenue = DB::table('chart_of_accounts')->insertGetId(['account_code' => '410000', 'account_name' => 'Sales Revenue', 'level' => 2, 'parent_id' => $revenue, 'type' => 'revenue']);
        $serviceRevenue = DB::table('chart_of_accounts')->insertGetId(['account_code' => '420000', 'account_name' => 'Service Revenue', 'level' => 2, 'parent_id' => $revenue, 'type' => 'revenue']);
        $otherRevenue = DB::table('chart_of_accounts')->insertGetId(['account_code' => '430000', 'account_name' => 'Other Revenue', 'level' => 2, 'parent_id' => $revenue, 'type' => 'revenue']);



        //500000
        // Main expenses account
        $expenses = DB::table('chart_of_accounts')->insertGetId(['account_code' => '500000', 'account_name' => 'Expenses', 'level' => 1, 'type' => 'expense']);
        // Subcategories under Expenses
        $cogs = DB::table('chart_of_accounts')->insertGetId(['account_code' => '510000', 'account_name' => 'Cost of Goods Sold (COGS)', 'level' => 2, 'parent_id' => $expenses, 'type' => 'expense']);
        $operatingExpenses = DB::table('chart_of_accounts')->insertGetId(['account_code' => '520000', 'account_name' => 'Operating Expenses', 'level' => 2, 'parent_id' => $expenses, 'type' => 'expense']);
        $otherExpenses = DB::table('chart_of_accounts')->insertGetId(['account_code' => '530000', 'account_name' => 'Other Expenses', 'level' => 2, 'parent_id' => $expenses, 'type' => 'expense']);

    
    }
    
}
