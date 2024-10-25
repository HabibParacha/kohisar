<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Models\Item;
use App\Models\Unit;
use App\Models\Party;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;

use App\Models\InvoiceMaster;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PurchaseOrderController extends Controller
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
                $data = InvoiceMaster::where('type','receipt')
                ->orderBy('id','desc')
                ->orderBy('date','desc')
                ->get();
    
                return Datatables::of($data)
                    ->addIndexColumn()
                    // Status toggle column

                    ->addColumn('party_business_name', function($row){
                        return $row->party->business_name;
                    })
                    ->addColumn('date', function($row){
                        return date('d-m-Y', strtotime($row->date));
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
                                            <a href="'.route('purchase-order.show',$row->id) .'"  class="dropdown-item">
                                                <i class="bx bx-show font-size-16 text-primary me-1"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a href="'. route('purchase-order.edit', $row->id).'" class="dropdown-item">
                                                <i class="bx bx-pencil font-size-16 text-secondary me-1"></i> Edit
                                            </a>
                                        </li>
                                         <li>
                                            <a href="javascript:void(0)" onclick="deletePurchaseOrder(' . $row->id . ')" class="dropdown-item">
                                                <i class="bx bx-trash font-size-16 text-danger me-1"></i> Delete
                                            </a>
                                        </li>
                                       
                                       
                                    </ul>
                                </div>
                            </div>';
    
                   
                    return $btn;
                   
                    })
    
                    ->rawColumns(['action']) // Mark these columns as raw HTML
                    ->make(true);
            }
    
            return view('purchase_orders.index');

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
        $items = Item::all();
        $taxes = Tax::all();
        $units = Unit::all();

        $paymentTerms = $this->paymentTerms();
        $newInvoiceNo = $this->generateInvoiceNo('PR','receipt');
        

        $itemController = new ItemController;
        $itemTypes = $itemController->itemTypes();
        
        return view('purchase_orders.create', 
        compact(
            'suppliers','items','taxes','units','paymentTerms','newInvoiceNo','itemTypes'
        ));
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
            'party_id' => 'required',
            'item_id.*' =>'required',
            'gross_weight.*' =>'required',
            'per_unit_price.*' =>'required',
        ],
        [
            'party_id.required' => 'The Supplier is required.',
            'item_id.*.required' => 'Each item is required.',
            'gross_weight.*.required' => 'Gross weight is required for all items.',
            'per_unit_price.*.required' => 'Per Kg price is required for each item.',
        ]);
    


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        
        // Start a transaction
        DB::beginTransaction();
       
        try {

            $newInvoiceNo = $this->generateInvoiceNo('PR','receipt');


            $invoice_master = [
                'date' => $request->input('date'),
                'due_date' => $request->input('due_date'),
                'invoice_no' => $newInvoiceNo,
                'vehicle_no' => $request->input('vehicle_no'),
                'status' => $request->input('status'),
                'type' => 'receipt',
                'party_id' => $request->input('party_id'),
                'item_total' => $request->input('item_total'),
                'shipping' => $request->input('shipping'),
                'sub_total' => $request->input('sub_total'),
                'discount_type' => $request->input('discount_type'),
                'discount_value' => $request->input('discount_value'),
                'discount_amount' => $request->input('discount_amount'),
                'total' => $request->input('total'),
                'tax_type' => $request->input('tax_type'),
                'tax_rate' => $request->input('tax_rate'),
                'grand_total' => $request->input('grand_total'),
                'description' => $request->input('description'),
                'attachment' => $request->file('attachment') // For handling file uploads
            ];

            
            // Check if the file input is provided
            if ($request->hasFile('attachment')) {
                $attachment = $request->file('attachment'); 
                $attachmentName = time() . '.' .  $attachment->extension();
                
                // Move the file to the desired folder
                $attachment->move(public_path('attachments/purchase-order'), $attachmentName);
                
                // Store the filename in the invoice_master array
                $invoice_master['attachment'] = $attachmentName; 
            }

            $invoice_master_id  = DB::table('invoice_master')->insertGetId($invoice_master);

           for($i=0; $i < count($request->item_id); $i++)
           {
                $invoice_detail = [
                    'invoice_master_id' => $invoice_master_id,
                    'date' => $request->input('date'),
                    'invoice_no' => $newInvoiceNo,
                    'item_id' => $request->item_id[$i],
                    'gross_weight' => $request->gross_weight[$i],
                    'cut_percentage' => $request->cut_percentage[$i],
                    'cut_value' => $request->cut_value[$i],
                    'after_cut_total_weight' => $request->after_cut_total_weight[$i],
                    'total_quantity' => $request->total_quantity[$i],
                    'per_package_weight' => $request->per_package_weight[$i],
                    'total_package_weight' => $request->total_package_weight[$i],
                    'net_weight' => $request->net_weight[$i],

                    'per_unit_price' => $request->per_unit_price[$i],
                    'per_unit_price_old_value' => $request->per_unit_price[$i],// to keep track of change

                    'total_price' => $request->total_price[$i],
                    'grand_total' => $request->total_price[$i],
                ];


                DB::table('invoice_detail')->insertGetId($invoice_detail);

           }

            DB::commit();// Commit the transaction

            // Return a JSON response with a success message
            return response()->json([
                'success' => true,
                'message' => 'Purchase added successfully. New Receipt No: '.$newInvoiceNo,
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
            $invoice_master = InvoiceMaster::findOrFail($id);
            $invoice_detail = InvoiceDetail::where('invoice_master_id', $id)->get();

            return view('purchase_orders.show', compact('invoice_master','invoice_detail'));

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
            $suppliers = Party::whereIn('party_type',['supplier','both'])->get();
            $items = Item::all();
            $taxes = Tax::all();
            $units = Unit::all();

            $paymentTerms = $this->paymentTerms();
            
            $invoice_master = InvoiceMaster::findOrFail($id);
            $invoice_detail = InvoiceDetail::where('invoice_master_id', $id)->get();

            return view('purchase_orders.edit', compact
            (
                'invoice_master','invoice_detail',
                'suppliers','items','taxes','units','paymentTerms'
            ));

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


        $validator = Validator::make($request->all(), [
            'party_id' => 'required',
            'description' => 'required',
            'item_id.*' =>'required',
            'gross_weight.*' =>'required',
            'per_unit_price.*' =>'required',
        ],
        [
            'party_id.required' => 'The Supplier is required.',
            'item_id.*.required' => 'Each item is required.',
            'gross_weight.*.required' => 'Gross weight is required for all items.',
            'per_unit_price.*.required' => 'Per Kg price is required for each item.',
        ]);
    


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

      
        // Start a transaction
        DB::beginTransaction();

        try {

        
            $invoice_master_data = [
                'date' => $request->input('date'),
                'vehicle_no' => $request->input('vehicle_no'),
                'party_id' => $request->input('party_id'),
                'item_total' => $request->input('item_total'),
                'shipping' => $request->input('shipping'),
                'sub_total' => $request->input('sub_total'),
                'discount_type' => $request->input('discount_type'),
                'discount_value' => $request->input('discount_value'),
                'discount_amount' => $request->input('discount_amount'),
                'total' => $request->input('total'),
                'tax_type' => $request->input('tax_type'),
                'tax_rate' => $request->input('tax_rate'),
                'grand_total' => $request->input('grand_total'),
                'description' => $request->input('description'),
                'attachment' => $request->attachment_old_value // For handling file uploads
            ];

             
            // Check if the file input is provided
            if ($request->hasFile('attachment')) {
                $attachment = $request->file('attachment'); 
                $attachmentName = time() . '.' .  $attachment->extension();
                
                // Move the file to the desired folder
                $attachment->move(public_path('attachments/purchase-order'), $attachmentName);
                
                // Store the filename in the invoice_master array
                $invoice_master['attachment'] = $attachmentName; 
            }

            $invoiceMaster = InvoiceMaster::findOrFail($id);

            // Update invoice master
            $invoiceMaster->update($invoice_master_data);

            // Delete related invoice details
            DB::table('invoice_detail')
            ->where('invoice_master_id', $invoiceMaster->id)
            ->delete();



           for($i=0; $i < count($request->item_id); $i++)
           {
                $invoice_detail = [
                    'invoice_master_id' => $invoiceMaster->id,
                    'date' => $request->input('date'),
                    'invoice_no' => $invoiceMaster->invoice_no,
                    'item_id' => $request->item_id[$i],
                    'gross_weight' => $request->gross_weight[$i],
                    'cut_percentage' => $request->cut_percentage[$i],
                    'cut_value' => $request->cut_value[$i],
                    'after_cut_total_weight' => $request->after_cut_total_weight[$i],
                    'total_quantity' => $request->total_quantity[$i],
                    'per_package_weight' => $request->per_package_weight[$i],
                    'total_package_weight' => $request->total_package_weight[$i],
                    'net_weight' => $request->net_weight[$i],

                    'per_unit_price' => $request->per_unit_price[$i],
                    'per_unit_price_old_value' => ($request->per_unit_price_old_value[$i]),// to keep track of change
                    'per_unit_price_new_value' => $request->per_unit_price[$i],// to keep track of change

                    'total_price' => $request->total_price[$i],
                    'grand_total' => $request->total_price[$i],
                ];


                DB::table('invoice_detail')->insertGetId($invoice_detail);

           }

            DB::commit();// Commit the transaction

            // Return a JSON response with a success message
            return response()->json([
                'success' => true,
                'message' => 'Purchase update successfully',
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
        DB::beginTransaction();// Start a transaction

        try {
           
             // Delete invoice details first
            DB::table('invoice_detail')->where('invoice_master_id', $id)->delete();

            // Then delete the invoice master record
            DB::table('invoice_master')->where('id', $id)->delete();
        
            DB::commit();// Commit the transaction
            
            return response()->json([
                'success' => true,
                'message' => 'Item Delete successfully.',
                ],200);
                
        } catch (\Exception $e) {
          
            DB::rollBack();  // Rollback the transaction if there is an error

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
        
    }

    public function paymentTerms(){
        $data = [
            [   'name' => 'net 07','value' => 07  ],
            [   'name' => 'net 10','value' => 10  ],
            [   'name' => 'net 15','value' => 15  ],
            [   'name' => 'net 20','value' => 20  ],
            [   'name' => 'net 45','value' => 30  ],
            [   'name' => 'net 45','value' => 45  ],
           
        ];

        return $data;
    }

   
    public function generateInvoiceNo($prefix,$type){
        
        $max_invoice_no = DB::table('invoice_master')
        ->where('type',$type)
        ->max('invoice_no');
        
        
        //if record exist
        if($max_invoice_no)
        {
            // Split by '-' and get the second part (the numeric part) +1
            $get_invoice_digits = (int)  explode('-', $max_invoice_no)[1] + 1;

            $new_invoice_no =  $prefix.'-'.$get_invoice_digits;

            return $new_invoice_no;
        }
        else{ 
            
            $new_invoice_no = $prefix.'-'.'1';

            return $new_invoice_no;// first invoice no

        }
          
    }


  

}
