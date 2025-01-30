<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Models\Item;
use App\Models\Unit;
use App\Models\Party;
use App\Models\Voucher;
use Illuminate\Http\Request;

use App\Models\InvoiceDetail;
use App\Models\InvoiceMaster;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
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
                    ->addColumn('total_bags', function($row){
                        return ($row->total_bags ? number_format($row->total_bags,2): '');
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
        $items = Item::where('type','Raw')->get();
        $taxes = Tax::all();
        $units = Unit::all();
        
        $itemBags = Item::where('type','Good')->where('category_id',6)->get();
       
        $paymentTerms = $this->paymentTerms();
        $newInvoiceNo = InvoiceMaster::generateInvoiceNo('PR','receipt');
 
        

        $itemController = new ItemController;
        $itemTypes = $itemController->itemTypes();
        
        return view('purchase_orders.create', 
        compact(
            'suppliers','items','taxes','units','paymentTerms','newInvoiceNo','itemTypes','itemBags'
        ));
    }
    public function createTest()
    {
        
        $suppliers = Party::whereIn('party_type',['supplier','both'])->get();
        $items = Item::all();
        $taxes = Tax::all();
        $units = Unit::all();

        $paymentTerms = $this->paymentTerms();
        $newInvoiceNo = InvoiceMaster::generateInvoiceNo('PR','receipt');
 
        

        $itemController = new ItemController;
        $itemTypes = $itemController->itemTypes();
        
        return view('purchase_orders.test.create', 
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
            'bag_type_id' => 'required',
            'item_id.*' =>'required',
            'gross_weight.*' =>'required',
            'per_unit_price.*' =>'required',
        ],
        [
            'bag_type_id.required' => 'Select empty bag Item.',
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

            $newInvoiceNo = InvoiceMaster::generateInvoiceNo('PR','receipt');// defined in model


            $invoice_master = [
                'date' => $request->input('date'),
                'due_date' => $request->input('due_date'),
                'invoice_no' => $newInvoiceNo,
                'reference_no' => $request->input('reference_no'),
                'vehicle_no' => $request->input('vehicle_no'),
                'status' => $request->input('status'),
                'type' => 'receipt',
                'party_id' => $request->input('party_id'),
                'item_total' => $request->input('item_total'),
                'total_bags' => $request->input('total_bags'),
                // 'empty_bag_weight' => $request->input('empty_bag_weight'),
                'bag_type_id' => $request->input('bag_type_id'),
                // 'bag_type_name' => $request->input('bag_type_name'),
                'is_x_freight' => $request->input('is_x_freight'),
                'shipping' => $request->input('shipping'),
                'sub_total' => $request->input('sub_total'),
                'sub_total_stock' => $request->input('sub_total_stock'),
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
                    'type' => 'receipt',
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

                    'per_unit_price_stock' => $request->per_unit_price_stock[$i],
                    'total_price_stock' => $request->total_price_stock[$i],


                    'grand_total' => $request->total_price[$i],
                ];


                DB::table('invoice_detail')->insertGetId($invoice_detail);

           }

              // Add empty bag item in invoice detail

                $itemBag = Item::find($request->bag_type_id);
                $item_bag = [
                    'invoice_master_id' => $invoice_master_id,
                    'date' => $request->input('date'),
                    'invoice_no' => $newInvoiceNo,
                    'type' => 'receipt',
                    'item_id' => $request->bag_type_id,
                    'gross_weight' => $itemBag->unit_weight * $request->total_bags,
                    'total_quantity' => $request->total_bags,
                    'unit_weight' => $itemBag->unit_weight,
                    'net_weight' => $itemBag->unit_weight * $request->total_bags,
                ];


                DB::table('invoice_detail')->insertGetId($item_bag);

           


           $this->createVoucherJournals($request, $invoice_master_id, $newInvoiceNo);






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
            $items = Item::where('type','Raw')->get();
            $taxes = Tax::all();
            $units = Unit::all();

            $paymentTerms = $this->paymentTerms();
            
            $invoice_master = InvoiceMaster::findOrFail($id);
            $invoice_detail = InvoiceDetail::where('invoice_master_id', $id)->get();

            return view('purchase_orders.edit', 
            compact(
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
                'reference_no' => $request->input('reference_no'),
                'party_id' => $request->input('party_id'),
                'item_total' => $request->input('item_total'),
                'total_bags' => $request->input('total_bags'),

                // 'empty_bag_weight' => $request->input('empty_bag_weight'),
                // 'bag_type_id' => $request->input('bag_type_id'),
                'bag_type_name' => $request->input('bag_type_name'),
                'is_x_freight' => $request->input('is_x_freight'),
                'sub_total_stock' => $request->input('sub_total_stock'),

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

            // Delete  invoice details
            DB::table('invoice_detail')
            ->where('invoice_master_id', $invoiceMaster->id)
            ->delete();

            DB::table('voucher_details')
            ->where('invoice_master_id', $invoiceMaster->id)
            ->delete();

            DB::table('vouchers')
            ->where('invoice_master_id', $invoiceMaster->id)
            ->delete();
            
            DB::table('journals')
            ->where('invoice_master_id', $invoiceMaster->id)
            ->delete();

           
            



           for($i=0; $i < count($request->item_id); $i++)
           {
                $invoice_detail = [
                    'invoice_master_id' => $invoiceMaster->id,
                    'date' => $request->input('date'),
                    'invoice_no' => $invoiceMaster->invoice_no,
                    'type' => $invoiceMaster->type,
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

                    'per_unit_price_stock' => $request->per_unit_price_stock[$i],
                    'total_price_stock' => $request->total_price_stock[$i],
                    
                    'grand_total' => $request->total_price[$i],
                ];


                DB::table('invoice_detail')->insertGetId($invoice_detail);

           }

           $this->createVoucherJournals($request, $invoiceMaster->id, $invoiceMaster->invoice_no);

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
            DB::table('journals')->where('invoice_master_id', $id)->delete();

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


    public function createVoucherJournals(Request $request, $invoice_master_id, $newInvoiceNo)
    {
        $date = $request->input('date');
        $supplier_id = $request->input('party_id');
        $is_x_freight = $request->input('is_x_freight');
        $sub_total = $request->input('sub_total');
        $sub_total_stock = $request->input('sub_total_stock');
        $shipping = $request->input('shipping');
        $grand_total = $request->input('grand_total');

        // material = 100
         // freight = 10
        if($is_x_freight == 0 )
        {   
         /**
          * Raw material Cost = 100
          * Freight = 10
          * 
          * Jounral Raw material DR = 100
          * Jounral AP CR = 100
          * 
          * Jounral AP DR = 10
          * Jounral Petty Cah CR = 10
        
          */
             //in this case suppliers says pay freight on the befalf of him 
             
             $rawMaterial_DR = $grand_total; //DR => 100
             $AP_CR = $grand_total;// CR => 100
             $narration1 = 'Raw material purchased @ '.$newInvoiceNo;

             $AP_DR = $shipping; // DR => 10
             $pettyCash_CR = $shipping;  // CR => 10
             $narration2 = 'Freight paid on behalf of supplier @ '.$newInvoiceNo;

             // $rawMaterial_DR
             DB::table('journals')->insert([
                 'date' =>  $request->input('date'),
                 'voucher_no' => $newInvoiceNo,
                 'type' => 'receipt',
                 'chart_of_account_id' => env('RAW_MATERIAL'),
                 'narration' => $narration1,
                 'supplier_id' => $supplier_id,
                 'invoice_master_id' => $invoice_master_id,
                 'debit' => $rawMaterial_DR,
                 'trace' => '',
                 'created_by' => Auth::user()->id,
                 'created_at' => now(),
             ]);

             // $AP_CR
             DB::table('journals')->insert([
                 'date' =>  $request->input('date'),
                 'voucher_no' => $newInvoiceNo,
                 'type' => 'receipt',
                 'chart_of_account_id' => env('AP'),
                 'narration' => $narration1,
                 'supplier_id' => $supplier_id,
                 'invoice_master_id' => $invoice_master_id,
                 'credit' => $AP_CR,
                 'trace' => '',
                 'created_by' => Auth::user()->id,
                 'created_at' => now(),
             ]);


             $voucher_type = DB::table('voucher_types')->where('code','CP')->first();
             $newVoucherNo =  Voucher::generateVoucherNo( $voucher_type->code);

             $voucher = [
                 'date' => $request->date,
                 'voucher_no' => $newVoucherNo,
                 'code' => $voucher_type->code,
                 'type' => $voucher_type->name,
                 'invoice_master_id' => $invoice_master_id,

                 'narration' => $narration2,
                 'total_amount' => $shipping,
                 'created_by' => Auth::user()->id,
             ];
             $voucher_id = DB::table('vouchers')->insertGetId($voucher);
             
             $voucher_DR = [
                 'voucher_id' => $voucher_id,
                 'date' => $request->date,
                 'voucher_no' => $newVoucherNo,
                 'code' => $voucher_type->code,
                 'type' => $voucher_type->name,
                 'chart_of_account_id' => env('AP'),
                 'invoice_master_id' => $invoice_master_id,

                 'supplier_id' => $supplier_id,
                 'narration' => $narration2,
                 'debit' => $AP_DR,
                 'created_at' => now(),
             ];
             DB::table('voucher_details')->insert($voucher_DR);

             $voucher_DR['created_by'] = Auth::user()->id; // Add created_by only for journals
             DB::table('journals')->insert($voucher_DR);

             $voucher_CR = [
                 'voucher_id' => $voucher_id,
                 'date' => $request->date,
                 'voucher_no' => $newVoucherNo,
                 'code' => $voucher_type->code,
                 'type' => $voucher_type->name,
                 'chart_of_account_id' => env('PETTY_CASH'),
                 'invoice_master_id' => $invoice_master_id,

                 'supplier_id' => $supplier_id,
                 'narration' => $narration2,
                 'credit' => $pettyCash_CR,
                 'created_at' => now(),
             ];
             DB::table('voucher_details')->insert($voucher_CR);

             $voucher_CR['created_by'] = Auth::user()->id; // Add created_by only for journals
             DB::table('journals')->insert($voucher_CR);

      
        }
        else{
             // in this case freight is paid by us so our raw material 
             //cost will be increrased by the amount of freight

             $rawMaterial_DR = $grand_total + $shipping; //DR => 110
             $AP_CR = $grand_total;// CR => 100
             $freightExp_CR = $shipping;// CR => 10
             $narration1 = 'Raw material purchased @ '.$newInvoiceNo;
             $shipping1 = 'Freight paid @ '.$newInvoiceNo;


             $freightExp_DR = $shipping;// DR => 10
             $pettyCash_CR =  $shipping;// CR => 10 
             
             

             // $rawMaterial_DR
             DB::table('journals')->insert([
                 'date' =>  $request->input('date'),
                 'voucher_no' => $newInvoiceNo,
                 'type' => 'receipt',
                 'chart_of_account_id' => env('RAW_MATERIAL'),
                 'narration' => $narration1. ' and '. $shipping1,
                 'supplier_id' => $supplier_id,
                 'invoice_master_id' => $invoice_master_id,
                 'debit' => $rawMaterial_DR,
                 'trace' => '',
                 'created_by' => Auth::user()->id,
                 'created_at' => now(),
             ]);

             // $AP_CR
             DB::table('journals')->insert([
                 'date' =>  $request->input('date'),
                 'voucher_no' => $newInvoiceNo,
                 'type' => 'receipt',
                 'chart_of_account_id' => env('AP'),
                 'narration' => $narration1,
                 'supplier_id' => $supplier_id,
                 'invoice_master_id' => $invoice_master_id,
                 'credit' => $AP_CR,
                 'trace' => '',
                 'created_by' => Auth::user()->id,
                 'created_at' => now(),
             ]);

             // $freightExp_CR
             DB::table('journals')->insert([
                 'date' =>  $request->input('date'),
                 'voucher_no' => $newInvoiceNo,
                 'type' => 'receipt',
                 'chart_of_account_id' => env('INPUT_FREIGHT'),
                 'narration' => $shipping1,
                 'supplier_id' => $supplier_id,
                 'invoice_master_id' => $invoice_master_id,
                 'credit' => $freightExp_CR,
                 'trace' => '',
                 'created_by' => Auth::user()->id,
                 'created_at' => now(),
             ]);




             $voucher_type = DB::table('voucher_types')->where('code','CP')->first();
             $newVoucherNo =  Voucher::generateVoucherNo( $voucher_type->code);

             $voucher = [
                 'date' => $request->date,
                 'voucher_no' => $newVoucherNo,
                 'code' => $voucher_type->code,
                 'type' => $voucher_type->name,
                 'invoice_master_id' => $invoice_master_id,

                 'narration' => $shipping1,
                 'total_amount' => $shipping,
                 'created_by' => Auth::user()->id,
             ];
             $voucher_id = DB::table('vouchers')->insertGetId($voucher);
             
             $voucher_DR = [
                 'voucher_id' => $voucher_id,
                 'date' => $request->date,
                 'voucher_no' => $newVoucherNo,
                 'code' => $voucher_type->code,
                 'type' => $voucher_type->name,
                 'chart_of_account_id' => env('INPUT_FREIGHT'),
                 'invoice_master_id' => $invoice_master_id,

                 'supplier_id' => $supplier_id,
                 'narration' => $shipping1,
                 'debit' => $freightExp_DR,
                 'created_at' => now(),
             ];
             DB::table('voucher_details')->insert($voucher_DR);

             $voucher_DR['created_by'] = Auth::user()->id; // Add created_by only for journals
             DB::table('journals')->insert($voucher_DR);

             $voucher_CR = [
                 'voucher_id' => $voucher_id,
                 'date' => $request->date,
                 'voucher_no' => $newVoucherNo,
                 'code' => $voucher_type->code,
                 'type' => $voucher_type->name,
                 'chart_of_account_id' => env('PETTY_CASH'),
                 'invoice_master_id' => $invoice_master_id,

                 'supplier_id' => $supplier_id,
                 'narration' => $shipping1,
                 'credit' => $pettyCash_CR,
                 'created_at' => now(),
             ];
             DB::table('voucher_details')->insert($voucher_CR);

             $voucher_CR['created_by'] = Auth::user()->id; // Add created_by only for journals
             DB::table('journals')->insert($voucher_CR);






        }
    }

   
    public function calculateItemAvgCost()
    {
        $item = Item::find(12);
        
        $transactions = InvoiceDetail::where('item_id',12)
        ->whereIn('type',['receipt','production'])
        ->orderBy('id','asc')
        ->orderBy('date','asc')
        ->get();

        $stock_weight = 0;
        $stock_value = 0;
        $avg_cost = 0;

        $data = [];
        
        foreach($transactions as $transaction)
        {

            if($transaction->type == 'receipt')
            {
                $stock_value += $transaction->total_price_stock;
                $stock_weight += $transaction->net_weight;

                $avg_cost = $stock_value / $stock_weight;
                
            }
            else if($transaction->type == 'production')
            {           
                $stock_value -= $transaction->net_weight * $avg_cost;
                $stock_weight -= $transaction->net_weight;
 
            }


            $data[] = [
                'date' => $transaction->date,
                'type' => $transaction->type,
                'qty_in' => ($transaction->type == 'receipt') ? $transaction->net_weight : '-',
                'qty_out' => ($transaction->type == 'production') ? $transaction->net_weight : '-',
                'balance' => $stock_weight,
                'balance' => number_format($stock_weight, 2),
                'avg_cost' => ($transaction->type == 'receipt') ? number_format($avg_cost, 2):'-',
                // 'avg_cost' => number_format($avg_cost, 2),
                'stock_value' => number_format($stock_value, 2),
            ];


           
        }
        
        // return response()->json($data);

        return view('reports.item_average_price_history.show', compact('data'));


        
    }


  

}
