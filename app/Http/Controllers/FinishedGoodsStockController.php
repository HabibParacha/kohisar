<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\InvoiceMaster;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class FinishedGoodsStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                // Fetch data with filtering and eager loading
                $data = InvoiceMaster::where('type', 'output')
                    ->where('invoice_no', 'like', 'OB-%') // Filter by 'OB' prefix in invoice_no
                    ->orderBy('id', 'desc')
                    ->orderBy('date', 'desc')
                    ->with('invoiceDetails') // Eager load related invoiceDetails
                    ->get();
    
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '
                            <div class="d-flex align-items-center col-actions">
                                <div class="dropdown">
                                    <a class="action-set show" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="true">
                                        <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                         <li>
                                                <a href="'. route('finished-goods-stock.show', $row->id).'" class="dropdown-item">
                                                    <i class="bx bx-show font-size-16 text-secondary me-1"></i> View
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
    
            // Return the view if not an AJAX request
            return view('finished_goods_stock.index');
    
        } catch (\Exception $e) {
            // Handle the exception
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
        $itemGoods = DB::table('v_finished_goods_stock_report')->get();

        return view('finished_goods_stock.create', compact('itemGoods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        {

            // Start a transaction
            DB::beginTransaction();
    
            try { 
                    $validator = Validator::make($request->all(), [
                        'item_id.*' => 'required',
                        'unit_weight.*' => 'required',
                        'total_quantity.*' => 'required',
                        'net_weight.*' => 'required',  
                        'cost_unit_price.*' => 'required',  
                        'cost_price.*' => 'required',  
                    ]);
                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'message' => $validator->errors()->first()
                    ]);
                }


              
    
                $newInvoiceNo = InvoiceMaster::generateInvoiceNo('OB','output');// defined in model
    
                $invoice_master = [
                    'date' => $request->input('date'),
                    'invoice_no' => $newInvoiceNo,
                    'batch_no' => $request->input('batch_no'),
                    'type' => 'output',
                    'description' => "opening Balance",
                    'output_qty' => $request->total_net_weight,

                    'grand_total' => $request->grand_total,

                ];
    
                $invoice_master_id  = DB::table('invoice_master')->insertGetId($invoice_master);
    
                //output
               
    
                for($i=0; $i < count($request->item_id); $i++)
                {
                    
                    $invoice_detail = [
                        'invoice_master_id' => $invoice_master_id,
                        'date' => $request->input('date'),
                        'invoice_no' => $newInvoiceNo,
                        'type' => 'output',
                        'item_id' => $request->item_id[$i],
                        'unit_weight' => $request->unit_weight[$i],
                        'per_unit_price' => $request->cost_unit_price[$i] ,
                        'total_quantity' => $request->total_quantity[$i],
                        'net_weight' => $request->net_weight[$i],
                        
                        'total_price' => $request->grand_total[$i],
                        'grand_total' => $request->grand_total[$i],//output Grand Total
                    ];
    
                    DB::table('invoice_detail')->insertGetId($invoice_detail);

                    DB::table('items')
                    ->where('id', $request->item_id[$i])
                    ->update([
                        'purchase_price' => $request->cost_unit_price[$i]
                    ]);
    
                }
               
                
                   
    
                DB::commit();// Commit the transaction
    
                // Return a JSON response with a success message
                return response()->json([
                    'success' => true,
                    'message' => 'Production added successfully.',
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
            $data = InvoiceMaster::with(['invoiceDetails'])->find($id);

            return view('finished_goods_stock.show', compact('data'));

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
        // try {
        //     $data = Brand::findOrFail($id);
        //     return response()->json($data);

        // } catch (\Exception $e) {
        //     // Return a JSON response with an error message
        //     return response()->json([
        //         'message' => $e->getMessage(),
        //         'success' => false,
        //     ], 500);
        // }
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
