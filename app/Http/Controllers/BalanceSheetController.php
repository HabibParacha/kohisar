<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Models\Journal;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use PDF;

class BalanceSheetController extends Controller
{
    public function show(Request $request)
    {
        
        $date = $request->date ?? today('Y-m-d');


        $level_one = ChartOfAccount::where('level', 1)
        ->whereIn('type', ['asset', 'liability', 'equity'])
        ->get();

        foreach ($level_one as $account) {
            $level_two = ChartOfAccount::where('parent_id', $account->id)->get();

            $topData = [
                'first' => $account->name,
                'second' => []
            ];

            foreach ($level_two as $account) {
                $level_three = ChartOfAccount::where('parent_id', $account->id)->get();

                $secondData = [
                    'second' => $account->name,
                    'third' => []
                ];
                
                $sum_of_level_3 = 0;
                foreach ($level_three as $account) {
                    $level_four = ChartOfAccount::where('parent_id', $account->id)->get();

                    $thirdData = [
                        'third' => $account->name,
                        'fourth' => [] // Initialize fourth level
                    ];

                    $sum_of_level_4 = 0;

                    
                    foreach ($level_four as $account) {


                        // if($account->id == "112100" ) 
                        if($account->id == "112100" ) 
                        {
                            $customers = Party::where('party_type','customer')->get();

                           

                            foreach($customers as $customer){

                                $totalDebit = Journal::where('customer_id', $customer->id)
                                ->where('date','<=',$date)
                                ->where('chart_of_account_id', "112100")
                                ->sum('debit');

                                $totalCredit = Journal::where('customer_id', $customer->id)
                                ->where('date','<=',$date)
                                ->where('chart_of_account_id', "112100")
                                ->sum('credit');


                                $balance = $totalDebit - $totalCredit;


                                if($balance != 0){
                                    $thirdData['fourth'][] = [
                                        'name' => $customer->business_name,
                                        'total_debit' => $totalDebit,
                                        'total_credit' => $totalCredit,
                                        'balance' => $balance
                                    ];
                                }


                                $sum_of_level_4 += $balance;       
                            }

                            $totalDebit = Journal::where('customer_id',null)
                            ->where('date','<=',$date)
                            ->where('chart_of_account_id', "112100")
                            ->sum('debit');

                            $totalCredit = Journal::where('customer_id', null)
                            ->where('date','<=',$date)
                            ->where('chart_of_account_id', "112100")
                            ->sum('credit');


                            $balance = $totalDebit - $totalCredit;

                            $thirdData['fourth'][] = [
                                'name' => 'N/A',
                                'total_debit' => $totalDebit,
                                'total_credit' => $totalCredit,
                                'balance' => $balance
                            ];

                            $sum_of_level_4 += $balance;  
                            
                        } 

                        // elseif($account->id == "211100")
                        elseif($account->id == "211100")
                        {
                            $suppliers = Party::where('party_type','supplier')->get();


                            foreach($suppliers as $supplier){

                                $totalDebit = Journal::where('supplier_id', $supplier->id)
                                ->where('date','<=',$date)
                                ->where('chart_of_account_id', "211100")
                                ->sum('debit');

                                $totalCredit = Journal::where('supplier_id', $supplier->id)
                                ->where('date','<=',$date)
                                ->where('chart_of_account_id', "211100")
                                ->sum('credit');

                                $balance = $totalDebit - $totalCredit;


                                if($balance != 0){
                                    $thirdData['fourth'][] = [
                                        'name' => $supplier->business_name,
                                        'total_debit' => $totalDebit,
                                        'total_credit' => $totalCredit,
                                        'balance' => $balance
                                    ];
                                }


                                $sum_of_level_4 += $balance;       
                            }

                            $totalDebit = Journal::where('supplier_id',null)
                            ->where('date','<=',$date)
                            ->where('chart_of_account_id', "211100")
                            ->sum('debit');

                            $totalCredit = Journal::where('supplier_id', null)
                            ->where('date','<=',$date)
                            ->where('chart_of_account_id', "211100")
                            ->sum('credit');


                            $balance = $totalDebit - $totalCredit;

                            $thirdData['fourth'][] = [
                                'name' => 'N/A',
                                'total_debit' => $totalDebit,
                                'total_credit' => $totalCredit,
                                'balance' => $balance
                            ];

                            $sum_of_level_4 += $balance;
                        }
                        
                        else{
                            $totalDebit = Journal::where('chart_of_account_id', $account->id)->where('date','<=',$date)->sum('debit');
                            $totalCredit = Journal::where('chart_of_account_id', $account->id)->where('date','<=',$date)->sum('credit');
                            $balance = $totalDebit - $totalCredit;

                            if($balance != 0){
                                $thirdData['fourth'][] = [
                                    'name' => $account->name.$account->id,
                                    'total_debit' => $totalDebit,
                                    'total_credit' => $totalCredit,
                                    'balance' => $totalDebit - $totalCredit
                                ];
                            }
                        }
                        
                        
                        $sum_of_level_4 += $balance;       
                    }
                    
                    if($sum_of_level_4 != 0){
                        $secondData['third'][] = $thirdData;
                    }
                    $sum_of_level_3 += $sum_of_level_4;

                }
                if($sum_of_level_3 != 0){
                    $topData['second'][] = $secondData;
                }
            }

            $data[] = $topData;
        }




        $leftLoop = $data[0];

        $rightLoop =array_slice($data, 1);
        
        $expense_coa = ChartOfAccount::where('level', 4)
        ->where('type', 'expense')
        ->get()
        ->pluck('id');

        $exp_totalDebit = Journal::whereIn('chart_of_account_id', $expense_coa)->where('date','<=',$date)->sum('debit');
        $exp_totalCredit = Journal::whereIn('chart_of_account_id', $expense_coa)->where('date','<=',$date)->sum('credit');
        $exp_blance = $exp_totalDebit - $exp_totalCredit;



        $revenue_coa = ChartOfAccount::where('level', 4)
        ->where('type', 'revenue')
        ->get()
        ->pluck('id');

        $rev_totalDebit = Journal::whereIn('chart_of_account_id', $revenue_coa)->where('date','<=',$date)->sum('debit');
        $rev_totalCredit = Journal::whereIn('chart_of_account_id', $revenue_coa)->where('date','<=',$date)->sum('credit');
        $rev_blance = $rev_totalCredit - $rev_totalDebit;

        $profit = $rev_blance - $exp_blance;
        
        // dd($profit);

        // return response()->json([$leftLoop]);

        return view('balance_sheet.show', compact('leftLoop', 'rightLoop','profit'));

        // $pdf = PDF::loadView('balance_sheet.pdf', compact('leftLoop', 'rightLoop','profit'));  
        // $pdf->setPaper('A4', 'landscape');
        // return $pdf->stream();
    }

    public function request()
    {
        return view('balance_sheet.request');
    }
  

}
