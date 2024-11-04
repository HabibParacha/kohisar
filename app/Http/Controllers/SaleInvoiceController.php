<?php

namespace App\Http\Controllers;
use App\Models\Tax;

use App\Models\Item;
use App\Models\Unit;
use App\Models\User;
use App\Models\Party;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;

use App\Models\InvoiceMaster;
use App\Models\PartyWarehouse;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
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
        $itemGoods = Item::where('type','good')->get();
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


        return view('sale_invoices.create_from_sale_order', compact('saleOrder','partyWarehouses','newInvoiceNo'));
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
            'total_quantity.*' =>'required',
            'per_unit_price.*' =>'required',
        ],
        [
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
              'grand_total' => $request->input('grand_total'),
              'description' => $request->input('description'),
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
                  'type' => 'sale_order',
                  'item_id' => $request->item_id[$i],
                  'unit_weight' => $request->unit_weight[$i],
                  'total_quantity' => $request->total_quantity[$i],
                  'net_weight' => $request->net_weight[$i],

                  'per_unit_price' => $request->per_unit_price[$i],

                  'total_price' => $request->total_price[$i],
                  'grand_total' => $request->total_price[$i],
              ];


              DB::table('invoice_detail')->insertGetId($invoice_detail);

         }

          DB::commit();// Commit the transaction

          // Return a JSON response with a success message
          return response()->json([
              'success' => true,
              'message' => 'Sale Order added successfully. New Receipt No: '.$newInvoiceNo,
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
}
