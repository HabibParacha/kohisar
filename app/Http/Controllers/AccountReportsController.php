<?php

namespace App\Http\Controllers;

use DB;
use PDF;

use URL;
use File;
use Excel;
use Image;
use Session;
use DateTime;
// for excel export
use Carbon\Carbon;
use App\Models\Party;
use App\Mail\SendMail;
// end for excel export
use App\Models\Expense;

use App\Models\Journal;
use App\Models\Voucher;
use App\Models\VoucherType;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\InvoiceMaster;
use App\Models\ChartOfAccount;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Exports\SupplierLedgerExcel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class AccountReportsController extends Controller
{
   
    private function validateDateRange(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date',
        ], [
            'startDate.required' => 'Start date is required.',
            'endDate.required' => 'End date is required.',
            'startDate.date' => 'Start date must be a valid date.',
            'endDate.date' => 'End date must be a valid date.',
        ]);
    }

    public function request()
    {

        $voucherTypes = VoucherType::all();
        $currentAssetAccounts = ChartOfAccount::whereIn('category',['cash','bank','card'])->get();
        $chartOfAccounts = ChartOfAccount::where('level',4)->get();
        $topLevelAccounts = ChartOfAccount::where('level',1)->get();
        $customers = Party::where('party_type','customer')->get();
        $suppliers = Party::where('party_type','supplier')->get();
        
        return view('account_reports.request', 
        compact('voucherTypes','currentAssetAccounts','chartOfAccounts','topLevelAccounts','customers','suppliers'));
    }

    public function voucherPDF(Request $request)
    {
      
        $this->validateDateRange($request);

        $query = Voucher::query()
                ->when($request->voucher_type_code, function ($query, $voucherTypeCode) {

                    if($voucherTypeCode == "0" ){
                        return $query->whereIn('code', ['BR','BP','CR','CP','JV']);
                    }else{
                        return $query->where('code', $voucherTypeCode);
                    }

                })
                ->when($request->startDate, function ($query, $startDate) {
                    return $query->where('date', '>=', $startDate);
                })
                ->when($request->endDate, function ($query, $endDate) {
                    return $query->where('date', '<=', $endDate);
                })
                ->orderByDesc('id')
                ->orderByDesc('date')
                ->with('details');  //relationship
                


                $vouchers = $query->get();      
        
        $pdf = PDF::loadView('account_reports.voucher_pdf', compact('vouchers'));
           
        return $pdf->stream();
            
        return view('account_reports.voucher_pdf',  compact('voucher'));
    }

    public function cashbookPDF(Request $request)
    {

        $this->validateDateRange($request);

        $broughtForward = DB::table('journals')
            ->select(DB::raw('SUM(COALESCE(debit, 0) - COALESCE(credit, 0)) AS amount'))
            ->where('date', '<', $request->startDate)
            ->when($request->current_coa_id, function ($query, $currentAssetAccountId) {
                if ($currentAssetAccountId == "0") {

                    $levelFourAccounts = ChartOfAccount::select('id')
                        ->whereIn('category', ['cash','bank','card'])
                        ->where('level', 4)
                        ->pluck('id')  // This will return the 'id' values as an array
                        ->toArray();  // Convert the collection to an array
    
                    return $query->whereIn('chart_of_account_id',$levelFourAccounts);

                } else {
                    return $query->where('chart_of_account_id', $currentAssetAccountId);
                }
            })
            ->get();



        $query = Journal::query()
                ->when($request->current_coa_id, function ($query, $currentAssetAccountId) {

                    if($currentAssetAccountId == "0") {

                        $levelFourAccounts = ChartOfAccount::select('id')
                        ->whereIn('category', ['cash','bank','card'])
                        ->where('level', 4)
                        ->pluck('id')  // This will return the 'id' values as an array
                        ->toArray();  // Convert the collection to an array
    
                    return $query->whereIn('chart_of_account_id',$levelFourAccounts);

                    }else{
                        return $query->where('chart_of_account_id', $currentAssetAccountId);
                    }
                })
                ->when($request->startDate, function ($query, $startDate) {
                    return $query->where('date', '>=', $startDate);
                })
                ->when($request->endDate, function ($query, $endDate) {
                    return $query->where('date', '<=', $endDate);
                })
                ->orderBy('id')
                ->orderBy('date')
                ->with(['customer','supplier']);  //relationship
                
            $journals = $query->get(); 
        
        $pdf = PDF::loadView('account_reports.cashbook_pdf', compact('journals','broughtForward'));
        $pdf->setpaper('A4', 'landscape');

        return $pdf->stream();
    }



    public function gernalLedgerPDF(Request $request)
    {

        $this->validateDateRange($request);

        $broughtForward = DB::table('journals')
            ->when($request->coa_id, function ($query, $coaId) {
                if($coaId != "0"){
                    return $query->where('chart_of_account_id', $coaId);
                }
            })
            ->when($request->startDate, function ($query, $startDate) {
                return $query->where('date', '<', $startDate);
            })
            ->select(DB::raw('SUM(COALESCE(debit, 0) - COALESCE(credit, 0)) AS amount'))
            ->get();

           

        $query = Journal::query()
                ->when($request->coa_id, function ($query, $coaId) {
                    if($coaId != "0"){
                        return $query->where('chart_of_account_id', $coaId);
                    }
                })
                ->when($request->startDate, function ($query, $startDate) {
                    return $query->where('date', '>=', $startDate);
                })
                ->when($request->endDate, function ($query, $endDate) {
                    return $query->where('date', '<=', $endDate);
                })
                ->orderBy('id')
                ->orderBy('date')
                ->with(['customer','supplier']);  //relationship
                


        $journals = $query->get(); 
        
        $pdf = PDF::loadView('account_reports.gernal_ledger_pdf', compact('journals','broughtForward'));
        $pdf->setpaper('A4', 'landscape');

        return $pdf->stream();
    }



    public function daybookPDF(Request $request)
    {
        $this->validateDateRange($request);

        $levelFourAccounts = ChartOfAccount::select('id')
                        ->whereIn('category', ['cash','bank','card'])
                        ->where('level', 4)
                        ->pluck('id')  // This will return the 'id' values as an array
                        ->toArray();  // Convert the collection to an array

        $invoices = InvoiceMaster::whereBetween('date',[$request->startDate,$request->endDate])
        ->whereIn('type', ['receipt','invoice'])
        ->get();

        $query = Journal::query()
                ->when($request->coa_id, function ($query, $coaId) {
                    return $query->where('chart_of_account_id', $coaId);
                })
                ->when($request->startDate, function ($query, $startDate) {
                    return $query->where('date', '>=', $startDate);
                })
                ->when($request->endDate, function ($query, $endDate) {
                    return $query->where('date', '<=', $endDate);
                })
                
                ->whereIn('chart_of_account_id',$levelFourAccounts)
                ->orderBy('id')
                ->orderBy('date')
                ->with(['customer','supplier']);  //relationship
                


            $journals = $query->get(); 


            
        
        $pdf = PDF::loadView('account_reports.daybook_pdf', compact('journals','invoices'));
        $pdf->setpaper('A4', 'landscape');

        return $pdf->stream();
    }

    public function trialBalancePDF(Request $request)
    {
        $this->validateDateRange($request);
        $query = Journal::query()
        // Filter by top-level chart of accounts
        ->when($request->top_level_coa_id, function ($query, $topLevelAccounts) {
            if ($topLevelAccounts != "0") {

                $account = ChartOfAccount::find($topLevelAccounts);
                $levelFourAccounts = ChartOfAccount::select('id')
                    ->where('type', $account->type)
                    ->where('level', 4)
                    ->pluck('id')  // This will return the 'id' values as an array
                    ->toArray();  // Convert the collection to an array

                return $query->whereIn('chart_of_account_id',$levelFourAccounts);
            } 
        })
        // Filter by start date
        ->when($request->startDate, function ($query, $startDate) {
            return $query->where('date', '>=', $startDate);
        })
        // Filter by end date
        ->when($request->endDate, function ($query, $endDate) {
            return $query->where('date', '<=', $endDate);
        })
        // Group by chart_of_account_id and get the sum of debit
        ->select('chart_of_account_id', 
            DB::raw('SUM(debit) as total_debit'),
            DB::raw('SUM(credit) as total_credit'))
        ->groupBy('chart_of_account_id')
        ->having(DB::raw('SUM(COALESCE(debit, 0)) - SUM(COALESCE(credit, 0))'), '!=', 0);
        // Execute the query
                
        $journals = $query->get(); 

        $pdf = PDF::loadView('account_reports.trial_balance_pdf', compact('journals'));
        // $pdf->setpaper('A4', 'landscape');
        return $pdf->stream();

    }


    public function customerBalancePDF(Request $request)
    {
        $this->validateDateRange($request);
        $type = $request->balance_report_type_customer;

        $query = Journal::query()

        ->when($request->customer_id, function ($query, $customer_id){
            if($customer_id != "0"){
                return $query->where('customer_id', $customer_id);
            }
        })
         // Filter by start date
         ->when($request->startDate, function ($query, $startDate) {
            return $query->where('date', '>=', $startDate);
        })
        // Filter by end date
        ->when($request->endDate, function ($query, $endDate) {
            return $query->where('date', '<=', $endDate);
        })
        
        ->where('chart_of_account_id', env('AR'))
        ->select('customer_id',
        DB::raw('sum(if(ISNULL(debit),0,debit)) as total_debit'),
        DB::raw('sum(if(ISNULL(credit),0,credit)) as total_credit'))
        
        ->groupBy('customer_id')
        // ->having(DB::raw('sum(if(ISNULL(debit),0,debit)) - sum(if(ISNULL(credit),0,credit))'), '>', 0);
        ->having(DB::raw('SUM(COALESCE(debit, 0)) - SUM(COALESCE(credit, 0))'), ($type == 'debitor') ?  '>' : '<' , 0);
        
        $journals = $query->get(); 

        $pdf = PDF::loadView('account_reports.customer_balance_pdf', compact('journals'));
        // $pdf->setpaper('A4', 'landscape');
        return $pdf->stream();
        
    }

    public function supplierBalancePDF(Request $request)
    {
        $this->validateDateRange($request);
        $type = $request->balance_report_type_supplier;

        $query = Journal::query()

        ->when($request->supplier_id, function ($query, $supplier_id){
            if($supplier_id != "0"){
                return $query->where('supplier_id', $supplier_id);
            }
        })
         // Filter by start date
         ->when($request->startDate, function ($query, $startDate) {
            return $query->where('date', '>=', $startDate);
        })
        // Filter by end date
        ->when($request->endDate, function ($query, $endDate) {
            return $query->where('date', '<=', $endDate);
        })

        ->where('chart_of_account_id', env('AP'))
        ->select('supplier_id',
        DB::raw('sum(if(ISNULL(debit),0,debit)) as total_debit'),
        DB::raw('sum(if(ISNULL(credit),0,credit)) as total_credit'))
        
        ->groupBy('supplier_id')
        // ->having(DB::raw('sum(if(ISNULL(debit),0,debit)) - sum(if(ISNULL(credit),0,credit))'), '>', 0);
        ->having(DB::raw('SUM(COALESCE(debit, 0)) - SUM(COALESCE(credit, 0))'), ($type == 'debitor') ?  '>' : '<' , 0);
        
        $journals = $query->get(); 

        $pdf = PDF::loadView('account_reports.supplier_balance_pdf', compact('journals'));
        // $pdf->setpaper('A4', 'landscape');
        return $pdf->stream();
        
    }


    public function expensePDF(Request $request)
    {
        $this->validateDateRange($request);
        $query = Expense::query()

        // Filter by start date
        ->when($request->startDate, function ($query, $startDate) {
            return $query->where('date', '>=', $startDate);
        })
        // Filter by end date
        ->when($request->endDate, function ($query, $endDate) {
            return $query->where('date', '<=', $endDate);
        });

        $expenses = $query->get(); 

        $pdf = PDF::loadView('account_reports.expense_pdf', compact('expenses'));
        return $pdf->stream();


    }

    public function customerLedgerPDF(Request $request)
    {
        $this->validateDateRange($request);

        $request->validate([
            'customer_id_1' => 'required',
        ],
        [
            'customer_id_1.required' =>'customer is required'
        ]);

        $broughtForward = DB::table('journals')
        ->when($request->customer_id_1, function ($query, $customer_id){
            return $query->where('customer_id', $customer_id);
        })
          // Filter by start date
          ->when($request->startDate, function ($query, $startDate) {
            return $query->where('date', '<', $startDate);
        })
            
      
        ->where('chart_of_account_id', env('AR'))
        ->select(DB::raw('SUM(COALESCE(debit, 0) - COALESCE(credit, 0)) AS amount'))
        ->get();

        $query = Journal::query()

        ->when($request->customer_id_1, function ($query, $customer_id){
            return $query->where('customer_id', $customer_id);
        })
         ->when($request->startDate, function ($query, $startDate) {
            return $query->where('date', '>=', $startDate);
        })
        ->when($request->endDate, function ($query, $endDate) {
            return $query->where('date', '<=', $endDate);
        })    
            
        ->where('chart_of_account_id', env('AR'));
        
        $journals = $query->get(); 


        $pdf = PDF::loadView('account_reports.customer_ledger_pdf', compact('journals','broughtForward'));
        // $pdf->setpaper('A4', 'landscape');
        return $pdf->stream();
    }



    public function supplierLedgerPDF(Request $request)
    {

        $this->validateDateRange($request);

        $request->validate([
            'supplier_id_1' => 'required',
        ],
        [
            'supplier_id_1.required' =>'Supplier is required'
        ]);


        $broughtForward = DB::table('journals')
        ->when($request->supplier_id_1, function ($query, $supplier_id){
            return $query->where('supplier_id', $supplier_id);
        })
          // Filter by start date
          ->when($request->startDate, function ($query, $startDate) {
            return $query->where('date', '<', $startDate);
        })
      
        ->where('chart_of_account_id', env('AP'))
        ->select(DB::raw('SUM(COALESCE(debit, 0) - COALESCE(credit, 0)) AS amount'))
        ->get();

        $query = Journal::query()

        ->when($request->supplier_id_1, function ($query, $supplier_id){
            return $query->where('supplier_id', $supplier_id);
        })
         // Filter by start date
         ->when($request->startDate, function ($query, $startDate) {
            return $query->where('date', '>=', $startDate);
        })
        // Filter by end date
        ->when($request->endDate, function ($query, $endDate) {
            return $query->where('date', '<=', $endDate);
        })    
        ->where('chart_of_account_id', env('AP'));
        
        $journals = $query->get(); 


        $pdf = PDF::loadView('account_reports.supplier_ledger_pdf', compact('journals','broughtForward'));
        $pdf->setpaper('A4', 'landscape');
        return $pdf->stream();
    }



    
}
