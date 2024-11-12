<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Models\Party;
use App\Models\Expense;
use Illuminate\Http\Request;

use App\Models\ChartOfAccount;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        

        try{
            if ($request->ajax()) {
                $data = Expense::all();
    
                return Datatables::of($data)
                    ->addIndexColumn()
                    // Status toggle column
                   
                    ->addColumn('COA_name', function($row){
                        return $row->chartOfAccount->account_name;
                    })
                    ->addColumn('party_name', function($row){
                        return $row->party->business_name;
                    })

                    ->addColumn('action', function ($row) {
                        $btn = '
                            <div class="d-flex align-items-center col-actions">
                                <div class="dropdown">
                                    <a class="action-set show" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="true">
                                        <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="'.route('expense.show', $row->id).'" class="dropdown-item">
                                                <i class="bx bx-show font-size-16 text-primary me-1"></i> View
                                            </a>
                                        </li>
                                       
                                       
                                       
                                    </ul>
                                </div>
                            </div>';
    
                   
                    return $btn;
                    // <li>
                    //     <a href="javascript:void(0)" onclick="editBrand(' . $row->id . ')" class="dropdown-item">
                    //         <i class="bx bx-pencil font-size-16 text-secondary me-1"></i> Edit
                    //     </a>
                    // </li>
                    //     <li>
                    //     <a href="javascript:void(0)" onclick="deleteBrand(' . $row->id . ')" class="dropdown-item">
                    //         <i class="bx bx-trash font-size-16 text-danger me-1"></i> Delete
                    //     </a>
                    // </li>
                    })
                    
                  
    
                    ->rawColumns(['action']) // Mark these columns as raw HTML
                    ->make(true);
            }
    
            return view('expenses.index');

        }catch (\Exception $e){

            return back()->with('flash-danger', $e->getMessage());
        }
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers =  Party::whereIn('party_type',['supplier','both'])->get();

        $accounts = ChartOfAccount::all();

        $taxes = Tax::all();

        $newExpenseNo = $this->generateExpenseNo('EXP');
        return view('expenses.create', compact('suppliers','accounts','newExpenseNo','taxes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'paid_by_COA' => 'required',
            'chart_of_account_id.*' =>'required',
            'total.*' =>'required',
            'per_unit_price.*' =>'required',
        ]);
    

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        
        // Start a transaction
        DB::beginTransaction();
        // amount_exclusive_tax
        // tax_percentage
        // calculated_tax_amount
        // amount_inclusive_tax
        try {

            $newExpenseNo = $this->generateExpenseNo('EXP');


            $expense_data = [
                'date' => $request->input('date'),
                'party_id' => $request->input('supplier_id'),
                'chart_of_account_id' => $request->input('paid_by_COA'),
                'expense_no' => $newExpenseNo,
                'amount_exclusive_tax' => $request->total_exclusive_amount,
                // 'tax_percentage' => '',
                'calculated_tax_amount' => $request->total_tax,
                'amount_inclusive_tax' => $request->total_inclusive_amount,
                'description' => $request->input('expense_description'),
                'attachment' => $request->file('attachment') // For handling file uploads

            ];

            
            // Check if the file input is provided
            if ($request->hasFile('attachment')) {
                $attachment = $request->file('attachment'); 
                $attachmentName = time() . '.' .  $attachment->extension();
                
                // Move the file to the desired folder
                $attachment->move(public_path('attachments/expense-order'), $attachmentName);
                
                // Store the filename in the expense_data array
                $expense_data['attachment'] = $attachmentName; 
            }

            $expense_id  = DB::table('expenses')->insertGetId($expense_data);

           for($i=0; $i < count($request->COA_id); $i++)
           {
                $expense_detail = [
                    'expense_id' => $expense_id,
                    'date' => $request->input('date'),
                    'expense_no' => $newExpenseNo,
                    'chart_of_account_id' => $request->COA_id[$i],
                    'description' => $request->description[$i],
                    
                    'tax_percentage' => $request->tax_percentage[$i],
                    'amount_exclusive_tax' => $request->amount_exclusive_tax[$i],
                    'calculated_tax_amount' => $request->calculated_tax_amount[$i],
                    'amount_inclusive_tax' => $request->amount_inclusive_tax[$i],
                ];


                DB::table('expense_details')->insertGetId($expense_detail);

           }

            DB::commit();// Commit the transaction

            // Return a JSON response with a success message
            return response()->json([
                'success' => true,
                'message' => 'Purchase added successfully. New Receipt No: '.$newExpenseNo,
            ],200);
        

            
        } catch (\Exception $e) {
            
            DB::rollBack();// Rollback the transaction if there's an error

            // Return a JSON response with an error message
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $expense = Expense::with('details')->find($id);
           
            return view('expenses.show', compact('expense'));

        } catch (\Exception $e) {
            // Return a JSON response with an error message
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function generateExpenseNo($prefix){
        
        $max_expense_no = Expense::max('expense_no');
        
                 
        //if record exist
        if($max_expense_no)
        {
            // Split by '-' and get the second part (the numeric part) +1
            $get_invoice_digits = (int)  explode('-', $max_expense_no)[1] + 1;

            $newExpenseNo =  $prefix.'-'.$get_invoice_digits;

            return $newExpenseNo;
        }
        else{ 
            $newExpenseNo = $prefix.'-'.'1';
            return $newExpenseNo;
        }  
    }
}
