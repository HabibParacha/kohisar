<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Models\Voucher;
use App\Models\VoucherType;
use Illuminate\Http\Request;
use App\Models\VoucherDetail;
use App\Models\ChartOfAccount;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

      
        $voucherTypes = VoucherType::all();
        try{
            if ($request->ajax()) {


                $query = Voucher::query()
                ->when($request->voucher_type_code, function ($query, $voucherTypeCode) {
                    return $query->where('code', $voucherTypeCode);
                })
                ->when($request->start_date, function ($query, $startDate) {
                    return $query->where('date', '>=', $startDate);
                })
                ->when($request->end_date, function ($query, $endDate) {
                    return $query->where('date', '<=', $endDate);
                })
                ->orderByDesc('id')
                ->orderByDesc('date');


                $data = $query->get();
    
                return Datatables::of($data)
                    ->addIndexColumn()
                    // Status toggle column
                   

                    ->addColumn('action', function ($row) {
                        $btn = '
                            <div class="d-flex align-items-center col-actions">
                                <div class="dropdown">
                                    <a class="action-set show" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="true">
                                        <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">';
                                    if($row->attachment)
                                    {
                                        $fileUrl = asset('/attachments/vouchers/' . htmlspecialchars($row->attachment));
                                        $btn .= '
                                        <li>
                                            <a href="' . $fileUrl . '" target="_blank" class="dropdown-item">
                                                <i class="bx bx-file font-size-16 text-danger me-1"></i> Attachment
                                            </a>
                                        </li>';
                                    }

                                     $btn .= '    <li>
                                            <a href="'.route('voucher.show', $row->id).'" class="dropdown-item">
                                                <i class="bx bx-show font-size-16 text-primary me-1"></i> Show
                                            </a>
                                        </li>
                                        <li>
                                            <a href="'.route('voucher.edit', $row->id).'" class="dropdown-item">
                                                <i class="bx bx-pencil font-size-16 text-secondary me-1"></i> Edit
                                            </a>
                                        </li>
                                       
                                         <li>
                                            <a href="javascript:void(0)" onclick="deleteVoucher(' . $row->id . ')" class="dropdown-item">
                                                <i class="bx bx-trash font-size-16 text-danger me-1"></i> Delete
                                            </a>
                                        </li>';

                                      
                                       
                                       
                                        $btn .= '
                                        </ul>
                                    </div>
                                </div>';
    
                   
                    return $btn;
                   
                    })


                    ->rawColumns(['action','attachment']) // Mark these columns as raw HTML
                    ->make(true);
            }
    
            return view('vouchers.index', compact('voucherTypes'));

        }catch (\Exception $e){
            dd($e);
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
       

        $suppliers = Party::whereIn('party_type',['supplier','both'])->get(); 
        $customers = Party::whereIn('party_type',['customer','both'])->get(); 
        $chart_of_accounts = ChartOFAccount::where('level',4)->get();
        $voucherTypes = VoucherType::all(); 


       return view('vouchers.create', compact('suppliers','customers','voucherTypes','chart_of_accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    
     public function store(Request $request)
     {
        
         // Start a transaction
         DB::beginTransaction();
 
         try {
 
             // Validate the request data
             $validator = Validator::make($request->all(), [
                 
             ]);
 
 
             if ($validator->fails()) {
                 return response()->json([
                     'success' => false,
                     'message' => $validator->errors()->first()
                 ]);
             }
 
           
        

             $voucher_type = DB::table('voucher_types')->where('code',$request->voucher_type_code)->first();
             $newVoucherNo =  Voucher::generateVoucherNo( $voucher_type->code);
     
             $voucher = [
                 'date' => $request->date,
                 'voucher_no' => $newVoucherNo,
                 'code' => $voucher_type->code,
                 'type' => $voucher_type->name,
                 'chart_of_account_id' => $request->chart_of_account_id_main,
                 'narration' => $request->narration_main,
                 'total_amount' => $request->total_amount,
                 'creator_id' => Auth::user()->id,
             ];


            // Handle the image upload
            if ($request->hasFile('attachment')) {
                $imageName = time() . '.' . $request->attachment->extension();
                $request->attachment->move(public_path('attachments/vouchers'), $imageName);
                $voucher['attachment'] = $imageName; // Save the image name in the data array
            }

     
             $voucher_id = DB::table('vouchers')->insertGetId($voucher);
     
             for($i=0; $i < count($request->chart_of_account_id); $i++)
             {
                
                $debitEntry = [
                    'voucher_id' => $voucher_id,
                    'date' => $request->date,
                    'voucher_no' => $newVoucherNo,
                    'code' => $voucher_type->code,
                    'type' => $voucher_type->name,
                    'chart_of_account_id' => $request->chart_of_account_id_main,
                    'customer_id' => $request->customer_id[$i],
                    'supplier_id' => $request->supplier_id[$i],
                    'narration' => $request->narration_main,
                    // 'reference_no' => $request->reference_no[$i],
                    'debit' => $request->amount[$i],
                ];
     
                DB::table('voucher_details')->insert($debitEntry);

                $creditEntry = [
                    'voucher_id' => $voucher_id,
                    'date' => $request->date,
                    'voucher_no' => $newVoucherNo,
                    'code' => $voucher_type->code,
                    'type' => $voucher_type->name,
                    'chart_of_account_id' => $request->chart_of_account_id[$i],
                    // 'party_id' => '',//  client is both a customer and supplier
                    'customer_id' => $request->customer_id[$i],
                    'supplier_id' => $request->supplier_id[$i],
                    'narration' => $request->narration[$i],
                    'reference_no' => $request->reference_no[$i],
                    'credit' => $request->amount[$i],
                
                ];
                DB::table('voucher_details')->insert($creditEntry);




                $debitEntry['creator_id'] = Auth::user()->id;
                DB::table('journals')->insert($debitEntry);

                $creditEntry['creator_id'] = Auth::user()->id;
                DB::table('journals')->insert($creditEntry);
             }      
 


             DB::commit();// Commit the transaction
 
             // Return a JSON response with a success message
             return response()->json([
                 'success' => true,
                 'message' => 'Voucher added successfully.',
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
            $voucher = Voucher::with(['details','chartOfAccount'])->find($id);
            return view('vouchers.show', compact('voucher'));

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
      

        try {
            $voucher = Voucher::with('details')->find($id);

            $voucherTypes = VoucherType::all();
            $suppliers = Party::whereIn('party_type',['supplier','both'])->get(); 
            $customers = Party::whereIn('party_type',['customer','both'])->get(); 
            $chart_of_accounts = ChartOFAccount::where('level',4)->get();



            return view('vouchers.edit', compact('voucher','suppliers','customers','chart_of_accounts','voucherTypes'));

        } catch (\Exception $e) {
            // Return a JSON response with an error message
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
            ], 500);
        }
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
        // Start a transaction
        DB::beginTransaction();

        try {

            // Validate the request data
            $validator = Validator::make($request->all(), [
                
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ]);
            }


            if($request->total_amount_debit != $request->total_amount_credit)
            {
                return response()->json([
                    'success' => false,
                    'message' => "Debit and Credit are not equal"
                ]);
            }


          



            $voucher_type = DB::table('voucher_types')->where('code',$request->voucher_type_code)->first();
            
            $voucher =  Voucher::find($id);
    
            $voucherData = [
                'date' => $request->date,
                'code' => $voucher_type->code,
                'type' => $voucher_type->name,
                'narration' => $request->narration_main,
                'total_amount' => $request->total_amount,
                'creator_id' => Auth::user()->id,
            ];

            
           // Handle the attachment upload
           if ($request->hasFile('attachment')) {
            // Delete old attachment if it exists
            if ($voucher->attachment) {
                unlink(public_path('attachments/vouchers/' . $voucher->attachment));
            }

                $imageName = time() . '.' . $request->attachment->extension();
                $request->attachment->move(public_path('attachments/vouchers'), $imageName);
                $voucherData['attachment'] = $imageName; // Save the image name in the data array
            }

            //first update table voucher the record
            DB::table('vouchers')->where('id', $voucher->id)->update($voucherData);
            // then delete existing voucher detail record
            DB::table('voucher_details')->where('voucher_id',$voucher->id)->delete();

            //insert new record in voucher detail
            for($i=0; $i < count($request->chart_of_account_id); $i++)
            {
               
   
               $entry = [
                   'voucher_id' => $voucher->id,
                   'date' => $request->date,
                   'voucher_no' => $voucher->voucher_no,
                   'code' => $voucher_type->code,
                   'type' => $voucher_type->name,
                   'chart_of_account_id' => $request->chart_of_account_id[$i],
                   // 'party_id' => '',//  client is both a customer and supplier
                   'customer_id' => $request->customer_id[$i],
                   'supplier_id' => $request->supplier_id[$i],
                   'narration' => $request->narration[$i],
                   'reference_no' => $request->reference_no[$i],
                   'debit' => $request->debit[$i],
                   'credit' => $request->credit[$i],
               
               ];
    
                DB::table('voucher_details')->insert($entry);
            }      



            DB::commit();// Commit the transaction

            // Return a JSON response with a success message
            return response()->json([
                'success' => true,
                'message' => 'Voucher added successfully.',
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

   
}
