<?php

namespace App\Http\Controllers;
use App\Models\Tax;

use App\Models\Item;
use App\Models\Unit;
use App\Models\User;
use App\Models\Party;
use App\Models\Voucher;
use Illuminate\Http\Request;

use App\Models\InvoiceDetail;
use App\Models\InvoiceMaster;
use App\Models\PartyWarehouse;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Validator;

class SaleInvoiceController extends Controller
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
                $data = InvoiceMaster::where('type','invoice')
                ->orderBy('id','desc')
                ->orderBy('date','desc')
                ->get();
    
                return Datatables::of($data)
                    ->addIndexColumn()
                    // Status toggle column

                    ->addColumn('party_business_name', function($row){
                        return $row->party->business_name;
                    })
                    ->addColumn('saleman_name', function($row){
                        return ($row->saleman) ?  $row->saleman->name : 'N/A';
                    })
                    ->addColumn('party_warehouse_name', function($row){
                        return ($row->party_warehouse_id) ?  $row->partyWarehouse->name : 'N/A';
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
                                            <a href="'.route('sale-invoice.show',$row->id) .'"  class="dropdown-item">
                                                <i class="bx bx-show font-size-16 text-primary me-1"></i> View
                                            </a>
                                        </li>
                                         <li>
                                            <a href="'. route('sale-invoice.edit', $row->id).'" class="dropdown-item">
                                                <i class="bx bx-pencil font-size-16 text-warning me-1"></i> Edit
                                            </a>
                                        </li>
                                         
                                        <li>
                                            <a href="javascript:void(0)" onclick="deleteSaleInvoice(' . $row->id . ')" class="dropdown-item">
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
    
            return view('sale_invoices.index');

        }catch (\Exception $e){
            dd($e);
            return back()->with('flash-danger', $e->getMessage());
        }
    }

    public function create()
    {
        $partyCustomers = Party::whereIn('party_type',['customer','both'])->get();
        $userSalemen = User::where('type','saleman')->get();
        $newInvoiceNo = InvoiceMaster::generateInvoiceNo('INV','invoice');
        // $itemGoods = Item::where('type','good')->get();
        $itemGoods = DB::table('v_finished_goods_stock_report')->get();

        $units = Unit::all();
        return view('sale_invoices.create', compact('partyCustomers','newInvoiceNo','userSalemen','itemGoods','units'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // passing sale order id as parameter
    public function createFromSaleOrder($id)
    {
      
        $saleOrder = InvoiceMaster::with('invoiceDetails')->find($id);
        $newInvoiceNo = InvoiceMaster::generateInvoiceNo('INV','invoice');
        $partyWarehouses = PartyWarehouse::where('party_id',$saleOrder->party_id)->get();
        $itemGoods = DB::table('v_finished_goods_stock_report')->get();


        return view('sale_invoices.create_from_sale_order', compact('saleOrder','partyWarehouses','newInvoiceNo','itemGoods'));
    }
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'party_id' =>'required',
            'party_warehouse_id' =>'required',
            'total_quantity.*' =>'required',
            'per_unit_price.*' =>'required',
        ],
        [
            'party_id.required' => 'Party is required.',
            'party_warehouse_id.required' => 'Party Farm /  Warehouse in required.',
            'total_quantity.*.required' => 'Quantity is required for all items.',
            'per_unit_price.*.required' => 'Unit price is required for each item.',
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

          $newInvoiceNo = InvoiceMaster::generateInvoiceNo('INV','invoice');// defined in model


          $invoice_master = [
                'date' => $request->input('date'),
                'invoice_no' => $newInvoiceNo,
                'type' => 'invoice',
                'party_id' => $request->input('party_id'),
                'saleman_id' => $request->input('saleman_id'),
                'party_warehouse_id' => $request->input('party_warehouse_id'),
                'reference_no' => $request->input('reference_no'),
                'vehicle_no' => $request->input('vehicle_no'),
                'sub_total' => $request->input('sub_total'),
                // 'discount_type' =>'on rate',
                // 'discount_value',
                'discount_amount' =>  $request->input('discount_total'),
                
                'tax_rate' => $request->input('gst_rate'),
                'tax_amount' => $request->input('gst_amount'),
                
                'wth_tax_rate' => $request->input('wth_rate'),
                'wth_tax_amount' => $request->input('wth_amount'),
                
                'commission_rate' => $request->input('commission_rate'),
                'commission_amount' => $request->input('commission_amount'),
                
                'is_x_freight' => $request->input('is_x_freight'),
                'shipping' => $request->input('shipping'),
                
                'grand_total' => $request->input('grand_total'),
            
            
                'description' => $request->input('description'),

                'created_by' => Auth::user()->id,
          ];

          
          // Check if the file input is provided
          if ($request->hasFile('attachment')) {
              $attachment = $request->file('attachment'); 
              $attachmentName = time() . '.' .  $attachment->extension();
              
              // Move the file to the desired folder
              $attachment->move(public_path('attachments/sale-order'), $attachmentName);
              
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
                  'type' => 'invoice',
                  'item_id' => $request->item_id[$i],
                  'unit_weight' => $request->unit_weight[$i],
                  'total_quantity' => $request->total_quantity[$i],
                  'net_weight' => $request->net_weight[$i],
                  
                  'per_unit_price' => $request->per_unit_price[$i],
                  'total_price' => $request->total_price[$i],


                  'discount_type' =>  $request->discount_type[$i],
                  'discount_value' => $request->discount_value[$i],// this discount is on rate
                  'discount_amount' => $request->discount_unit_price[$i],
                  'after_discount_total_price' => $request->after_discount_total_price[$i],

                  'grand_total' => $request->after_discount_total_price[$i],
              ];


              DB::table('invoice_detail')->insertGetId($invoice_detail);

         }

         $voucher_type = DB::table('voucher_types')->where('code','CP')->first();
         $newVoucherNo =  Voucher::generateVoucherNo( $voucher_type->code);

        
         $this->createJournalEntries(
            $request, $newInvoiceNo, $invoice_master_id, 
            $newVoucherNo, $voucher_type->code,$voucher_type->name 
        );

          DB::commit();// Commit the transaction

          // Return a JSON response with a success message
          return response()->json([
              'success' => true,
              'message' => 'Sale Order added successfully. New Receipt No: '.$newInvoiceNo,
          ],200);
      

          
      } catch (\Exception $e) {
          
          DB::rollBack();// Rollback the transaction if there's an error
            dd($e);
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
            $saleInvoice = InvoiceMaster::with(['invoiceDetails','partyWarehouse'])->find($id);

            return view('sale_invoices.show', compact('saleInvoice'));

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
            $partyCustomers = Party::whereIn('party_type',['customer','both'])->get();
            $itemGoods = DB::table('v_finished_goods_stock_report')->get();
            $taxes = Tax::all();
            $units = Unit::all();
            $userSalemen = User::where('type','saleman')->get();

            
            $invoice_master = InvoiceMaster::findOrFail($id);

            return view('sale_invoices.edit', 
            compact(
                'invoice_master',
                'partyCustomers','userSalemen','itemGoods','taxes','units',
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
            'party_id' =>'required',
            'party_warehouse_id' =>'required',
            'total_quantity.*' =>'required',
            'per_unit_price.*' =>'required',
        ],
        [
            'party_id.required' => 'Party is required.',
            'party_warehouse_id.required' => 'Party Farm /  Warehouse in required.',
            'total_quantity.*.required' => 'Quantity is required for all items.',
            'per_unit_price.*.required' => 'Unit price is required for each item.',
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
            'party_id' => $request->input('party_id'),
            'saleman_id' => $request->input('saleman_id'),
            'party_warehouse_id' => $request->input('party_warehouse_id'),
            'reference_no' => $request->input('reference_no'),
            'vehicle_no' => $request->input('vehicle_no'),
            'sub_total' => $request->input('sub_total'),
            


            
            'discount_amount' =>  $request->input('discount_total'),
            
            'tax_rate' => $request->input('gst_rate'),
            'tax_amount' => $request->input('gst_amount'),
            
            'wth_tax_rate' => $request->input('wth_rate'),
            'wth_tax_amount' => $request->input('wth_amount'),
            
            'commission_rate' => $request->input('commission_rate'),
            'commission_amount' => $request->input('commission_amount'),
            
            'is_x_freight' => $request->input('is_x_freight'),
            'shipping' => $request->input('shipping'),
            
            'grand_total' => $request->input('grand_total'),
        
        
            'description' => $request->input('description'),

            'updated_by' => Auth::user()->id,
        ];

          
          // Check if the file input is provided
          if ($request->hasFile('attachment')) {
              $attachment = $request->file('attachment'); 
              $attachmentName = time() . '.' .  $attachment->extension();
              
              // Move the file to the desired folder
              $attachment->move(public_path('attachments/sale-order'), $attachmentName);
              
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

         for($i=0; $i < count($request->item_id); $i++)
         {
              $invoice_detail = [
                  'invoice_master_id' => $invoiceMaster->id,
                  'date' => $request->input('date'),
                  'invoice_no' => $invoiceMaster->invoice_no,
                  'type' => 'invoice',
                  'item_id' => $request->item_id[$i],
                  'unit_weight' => $request->unit_weight[$i],
                  'total_quantity' => $request->total_quantity[$i],
                  'net_weight' => $request->net_weight[$i],
                  
                  'per_unit_price' => $request->per_unit_price[$i],
                  'total_price' => $request->total_price[$i],


             
                  'discount_type' =>  $request->discount_type[$i],
                  'discount_value' => $request->discount_value[$i],// this discount is on rate
                  'discount_amount' => $request->discount_unit_price[$i],
                  'after_discount_total_price' => $request->after_discount_total_price[$i],

                  'grand_total' => $request->after_discount_total_price[$i],
              ];


              DB::table('invoice_detail')->insertGetId($invoice_detail);

         }



         $voucher_no = $voucher_code = $voucher_type = null;

         $voucher = Voucher::where('invoice_master_id', $invoiceMaster->id)->first();
         // If a voucher exists
         if($voucher)
         {
            $voucher_no = $voucher->voucher_no;
            $voucher_code = $voucher->code;
            $voucher_type = $voucher->type;
         }else{
            $voucher_type = DB::table('voucher_types')->where('code','CP')->first();
            $voucher_no =  Voucher::generateVoucherNo( $voucher_type->code);
            $voucher_code = $voucher_type->code;
            $voucher_type = $voucher_type->name;
         }


         DB::table('voucher_details')
         ->where('invoice_master_id', $invoiceMaster->id)
         ->delete();

         DB::table('vouchers')
         ->where('invoice_master_id', $invoiceMaster->id)
         ->delete();
         
         DB::table('journals')
         ->where('invoice_master_id', $invoiceMaster->id)
         ->delete();


        
         $this->createJournalEntries(
            $request, $invoiceMaster->invoice_no, $invoiceMaster->id, 
            $voucher_no, $voucher_code, $voucher_type
        );



          DB::commit();// Commit the transaction

          // Return a JSON response with a success message
          return response()->json([
              'success' => true,
              'message' => 'Sale Order added successfully. New Receipt No: '.$invoiceMaster->invoice_no,
          ],200);
      

          
      } catch (\Exception $e) {
          
          DB::rollBack();// Rollback the transaction if there's an error
            dd($e);
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

            DB::table('invoice_detail')->where('invoice_master_id', $id)->delete();
            DB::table('journals')->where('invoice_master_id', $id)->delete();

            // Then delete the invoice master record
            DB::table('invoice_master')->where('id', $id)->delete();

            DB::commit();// Commit the transaction
            
            return response()->json([
                'success' => true,
                'message' => 'Sale Invoice Delete successfully.',
                ],200);
                
        } catch (\Exception $e) {
          
            DB::rollBack();  // Rollback the transaction if there is an error

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function createJournalEntries(Request $request, $invoice_no, $invoice_master_id, $voucher_no, $voucher_code, $voucher_type)
    {
        $narrationAR = 'AR @ ' . $invoice_no . ' amount Rs: ' . number_format($request->input('grand_total') ?? 0, 2);
        $narrationWTH = 'WTH Tax @ ' . $invoice_no . ' amount Rs: ' . number_format($request->input('wth_amount') ?? 0, 2).' ('.$request->input('wth_rate').')%';
        $narrationGST = 'GST Tax @ ' . $invoice_no . ' amount Rs: ' . number_format($request->input('gst_amount') ?? 0, 2).' ('.$request->input('gst_rate').')%';
        $narrationCOMM = 'Commission @ ' . $invoice_no . ' amount Rs: ' . number_format($request->input('commission_amount') ?? 0, 2).' ('.$request->input('commission_rate').')%';
        $narrationXshipping = 'Freight Paid on behalf of Kohisar Mill @ ' . $invoice_no . ' amount Rs: ' . number_format($request->input('shipping') ?? 0, 2);
        $narrationShipping = 'Freight Paid @ ' . $invoice_no . ' amount Rs: ' . number_format($request->input('shipping') ?? 0, 2);
        $narrationInventory = 'Inventory @ ' . $invoice_no . ' amount Rs: ' . number_format($request->input('inventory') ?? 0, 2);

        $customer_id = $request->input('party_id');


        $journalDebit_AR = [
            'date' => $request->input('date'),
            'voucher_no' => $invoice_no,
            'type' => 'invoice',
            
            'chart_of_account_id' => env('AR'),
            'narration' => $narrationAR,
            
            'customer_id' => $customer_id,
            'invoice_master_id' => $invoice_master_id,
            
            'debit' => $request->input('grand_total'),
            'trace' => '',
            'created_by' => Auth::user()->id,
            'created_at' => now(),
        ];
        DB::table('journals')->insert($journalDebit_AR);

        $journalCredit_inventory = [
            'date' => $request->input('date'),
            'voucher_no' => $invoice_no,
            'type' => 'invoice',
            
            'chart_of_account_id' => env('FINISHED_GOOD'),
            'narration' => $narrationInventory,
            
            'customer_id' => $request->input('party_id'),
            'invoice_master_id' => $invoice_master_id,
            
            'credit' => $request->input('inventory'),
            'trace' => '',
            'created_by' => Auth::user()->id,
            'created_at' => now(),
        ];
        DB::table('journals')->insert($journalCredit_inventory); 



        // Debit: AR Customer
        //Credit: OUTPUT_FREIGHT
        if($request->input('is_x_freight') == '1')
        {
           $journalCredit_shipping = [
                'date' => $request->input('date'),
                'voucher_no' => $invoice_no,
                'type' => 'invoice',             
                'chart_of_account_id' => env('AR'),
                'narration' => $narrationShipping,

                'customer_id' => $customer_id,
                'invoice_master_id' => $invoice_master_id,

                'credit' => $request->input('shipping'),
                'trace' => '',
                'created_by' => Auth::user()->id,
                'created_at' => now(),
           ];
           DB::table('journals')->insert($journalCredit_shipping); 


           $journalDebit_output_freight = [
                'date' => $request->input('date'),
                'voucher_no' => $invoice_no,
                'type' => 'invoice',

                'chart_of_account_id' => env('OUTPUT_FREIGHT'),
                'narration' => $narrationXshipping,

                'customer_id' => $customer_id,
                'invoice_master_id' => $invoice_master_id,

                'debit' => $request->input('shipping'),
                'trace' => '',
                'created_by' => Auth::user()->id,
                'created_at' => now(),
           ];
           DB::table('journals')->insert($journalDebit_output_freight); 

        }
       
        // voucher plus journal 
        // Debit: OUTPUT_FREIGHT
        //Credit: PETTY_CASH
        else{

           

            $voucher = [
                'date' => $request->date,
                'voucher_no' => $voucher_no,
                'code' => $voucher_code,
                'type' => $voucher_type,
                'invoice_master_id' => $invoice_master_id,

                'narration' => $narrationShipping,
                'total_amount' => $request->shipping,
                'created_by' => Auth::user()->id,
            ];
            $voucher_id = DB::table('vouchers')->insertGetId($voucher);
             
            $voucher_DR = [
                'voucher_id' => $voucher_id,
                'date' => $request->date,
                'voucher_no' => $voucher_no,
                'code' => $voucher_code,
                'type' => $voucher_type,
                'chart_of_account_id' => env('OUTPUT_FREIGHT'),
                'invoice_master_id' => $invoice_master_id,

                'customer_id' => $customer_id,
                'narration' => $narrationShipping,
                'debit' => $request->shipping,
                'created_at' => now(),
            ];
            DB::table('voucher_details')->insert($voucher_DR);

            $voucher_DR['created_by'] = Auth::user()->id; // Add created_by only for journals
            DB::table('journals')->insert($voucher_DR);

            $voucher_CR = [
                'voucher_id' => $voucher_id,
                'date' => $request->date,
                'voucher_no' => $voucher_no,
                'code' => $voucher_code,
                'type' => $voucher_type,
                'chart_of_account_id' => env('PETTY_CASH'),
                'invoice_master_id' => $invoice_master_id,

                'customer_id' => $customer_id,
                'narration' => $narrationShipping,
                'credit' => $request->shipping,
                'created_at' => now(),
            ];
            DB::table('voucher_details')->insert($voucher_CR);

            $voucher_CR['created_by'] = Auth::user()->id; // Add created_by only for journals
            DB::table('journals')->insert($voucher_CR);


        }


      
       //wth: withholding tax
       /*
            $journalCredit_wth_tax = [
                'date' => $request->input('date'),
                'voucher_no' => $invoice_no,
                'type' => 'invoice',
                
                'chart_of_account_id' => env("SALE_TAX"),
                'narration' => $narrationWTH,
                
                'customer_id' => $request->input('party_id'),
                'invoice_master_id' => $invoice_master_id,
                
                'credit' => $request->input('wth_amount'),
                'trace' => '',
                'created_by' => Auth::user()->id,
                'created_at' => now(),
            ];
            DB::table('journals')->insert($journalCredit_wth_tax); 
        
            $journalCredit_gst_tax = [
                'date' => $request->input('date'),
                'voucher_no' => $invoice_no,
                'type' => 'invoice',
                
                'chart_of_account_id' => env("GST_TAX"),
                'narration' => $narrationGST,
                
                'customer_id' => $request->input('party_id'),
                'invoice_master_id' => $invoice_master_id,
                
                'credit' => $request->input('gst_amount'),
                'trace' => '',
                'created_by' => Auth::user()->id,
                'created_at' => now(),
            ];
            DB::table('journals')->insert($journalCredit_gst_tax); 
       
            if($request->input('commission_amount') > 0)
            {
                $journalCredit_commission = [
                    'date' => $request->input('date'),
                    'voucher_no' => $invoice_no,
                    'type' => 'invoice',
                    
                    'chart_of_account_id' => env('COMMISSION'),
                    'narration' => $narrationCOMM,
                    
                    'customer_id' => $request->input('party_id'),
                    'invoice_master_id' => $invoice_master_id,
                    
                    'credit' => $request->input('commission_amount'),
                    'trace' => '',
                    'created_by' => Auth::user()->id,
                    'created_at' => now(),
                ];
                DB::table('journals')->insert($journalCredit_commission); 
            }
         */

      

    }
}
