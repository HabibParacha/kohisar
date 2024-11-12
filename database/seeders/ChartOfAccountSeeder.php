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
       $assets = DB::table('chart_of_accounts')->insertGetId(['account_code' => '100000', 'account_name' => 'Assets', 'level' => 1, 'type' => 'asset']);

       // Subcategory under Assets
       $currentAssets = DB::table('chart_of_accounts')->insertGetId(['account_code' => '110000', 'account_name' => 'Current Assets', 'level' => 2, 'parent_id' => $assets, 'type' => 'asset']);

            // Subcategories under Current Assets
            $cash = DB::table('chart_of_accounts')->insertGetId(['account_code' => '111000', 'account_name' => 'Cash', 'level' => 3, 'parent_id' => $currentAssets, 'type' => 'asset']);
       
            // Cash subaccounts
            DB::table('chart_of_accounts')->insert([
                ['account_code' => '111100', 'account_name' => 'Cash in Hand', 'level' => 4, 'parent_id' => $cash, 'type' => 'asset'],
                ['account_code' => '111200', 'account_name' => 'Petty Cash', 'level' => 4, 'parent_id' => $cash, 'type' => 'asset']
            ]);

       // Accounts Receivable
       $accountsReceivable = DB::table('chart_of_accounts')->insertGetId(['account_code' => '112000', 'account_name' => 'Accounts Receivable', 'level' => 3, 'parent_id' => $currentAssets, 'type' => 'asset']);
       
            // Accounts Receivable subaccount
            DB::table('chart_of_accounts')->insert([
                ['account_code' => '112100', 'account_name' => 'Accounts Receivable - Customers', 'level' => 4, 'parent_id' => $accountsReceivable, 'type' => 'asset']
            ]);

       // Other subaccounts under Current Assets
       DB::table('chart_of_accounts')->insert([
           ['account_code' => '113000', 'account_name' => 'Inventory', 'level' => 3, 'parent_id' => $currentAssets, 'type' => 'asset'],
           ['account_code' => '114000', 'account_name' => 'Bank', 'level' => 3, 'parent_id' => $currentAssets, 'type' => 'asset']
       ]);
   
        
        $fixedAssets = DB::table('chart_of_accounts')->insertGetId(['account_code' => '120000', 'account_name' => 'Fixed Assets', 'level' => 2, 'parent_id' => $assets, 'type' => 'asset']);
        $otherAssets = DB::table('chart_of_accounts')->insertGetId(['account_code' => '130000', 'account_name' => 'Other Assets', 'level' => 2, 'parent_id' => $assets, 'type' => 'asset']);



        //200000
        // Main liabilities account
        $liabilities = DB::table('chart_of_accounts')->insertGetId(['account_code' => '200000', 'account_name' => 'Liabilities', 'level' => 1, 'type' => 'liability']);

        // Subcategory under Liabilities
        $currentLiabilities = DB::table('chart_of_accounts')->insertGetId(['account_code' => '210000', 'account_name' => 'Current Liabilities', 'level' => 2, 'parent_id' => $liabilities, 'type' => 'liability']);

            // Subcategories under Current Liabilities
            $accountsPayable = DB::table('chart_of_accounts')->insertGetId(['account_code' => '211000', 'account_name' => 'Accounts Payable', 'level' => 3, 'parent_id' => $currentLiabilities, 'type' => 'liability']);

            // Accounts Payable subaccount
            DB::table('chart_of_accounts')->insert([
                ['account_code' => '211100', 'account_name' => 'Accounts Payable - Suppliers', 'level' => 4, 'parent_id' => $accountsPayable, 'type' => 'liability']
            ]);

        // Other subaccounts under Current Liabilities
        DB::table('chart_of_accounts')->insert([
            ['account_code' => '212000', 'account_name' => 'Short-term Loans', 'level' => 3, 'parent_id' => $currentLiabilities, 'type' => 'liability']
        ]);

        // Long-term Liabilities
        $longTermLiabilities = DB::table('chart_of_accounts')->insertGetId(['account_code' => '220000', 'account_name' => 'Long-term Liabilities', 'level' => 2, 'parent_id' => $liabilities, 'type' => 'liability']);

        // Subaccounts under Long-term Liabilities
        DB::table('chart_of_accounts')->insert([
            ['account_code' => '221000', 'account_name' => 'Long-term Loans', 'level' => 3, 'parent_id' => $longTermLiabilities, 'type' => 'liability']
        ]);
    
        
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
