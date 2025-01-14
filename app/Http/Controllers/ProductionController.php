<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Unit;
use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use App\Models\InvoiceMaster;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        
        $recipes = Recipe::all();
        try{
            if ($request->ajax()) {
                $query = InvoiceMaster::where('type', 'production')
                ->orderBy('id', 'desc')
                ->orderBy('date', 'desc');

                if ($request->recipe_id) {
                    $query->where('recipe_id', $request->recipe_id );
                }
    
                if ($request->start_date && $request->end_date) {
                    $query->whereBetween('date', [$request->start_date, $request->end_date]);
                }


                $data = $query->get();


                return Datatables::of($data)
                    ->addIndexColumn()
                    // Status toggle column

                    ->addColumn('recipe_name', function($row){
                        return  $row->recipe->name ?? 'N/A';
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
                                            <a href="'.route('production.show',$row->id) .'"  class="dropdown-item">
                                                <i class="bx bx-show font-size-16 text-primary me-1"></i> View
                                            </a>
                                        </li>';

                                        if($row->is_lock == 0)
                                        {
                                            $btn .='
                                            <li>
                                                <a href="'. route('production.edit', $row->id).'" class="dropdown-item">
                                                    <i class="bx bx-pencil font-size-16 text-secondary me-1"></i> Edit
                                                </a>
                                            </li>
                                             <li>
                                                <a href="'.route('production.posting',$row->id) .'"  class="dropdown-item '.($row->output_qty == 0 ? "disabled":'') .'">
                                                    <i class="fas fa-check-double font-size-16 text-warning me-1"></i> Posting
                                                </a>
                                            </li>';
                                        }else{
                                            $btn .='
                                             <li>
                                                <a href="'.route('production.unposting',$row->id) .'"  class="dropdown-item '.($row->output_qty == 0 ? "disabled":'') .'">
                                                    <i class="fas fa-check-double font-size-16 text-danger me-1"></i> UnPosting
                                                </a>
                                            </li>
                                            ';
                                        }
                                       
                                       
                                       
                        $btn .='    </ul>
                                </div>
                            </div>';
    
                   
                    return $btn;

                    
                    //  <li>
                    //     <a href="javascript:void(0)" onclick="deleteProduction(' . $row->id . ')" class="dropdown-item">
                    //         <i class="bx bx-trash font-size-16 text-danger me-1"></i> Delete
                    //     </a>
                    // </li>
                   
                    })
    
                    ->rawColumns(['action']) // Mark these columns as raw HTML
                    ->make(true);
            }
    
            return view('productions.index', compact('recipes'));

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
        $goodItems  = Item::where('type','Good')->get();
        $units = Unit::all();
        $recipes = Recipe::where('is_active',1)->get();
        
        $newInvoiceNo = InvoiceMaster::generateInvoiceNo('PRO','production');

        return view('productions.create', compact('newInvoiceNo','goodItems','units','recipes'));
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
                'recipe_id' => 'required',
                'production_material_tons' => 'required',
                'production_material_tons' => 'required',
                
            ]);

            if($request->has('output_item_id'))
            {
                $validator = Validator::make($request->all(), [
                    'output_item_id.*' => 'required',
                    'output_quantity.*' => 'required',
                    
                ]);
            }

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ]);
            }


            $newInvoiceNo = InvoiceMaster::generateInvoiceNo('PRO','production');// defined in model


            $invoice_master = [
                'date' => $request->input('date'),
                'expiry_date' => $request->input('expiry_date'),
                'invoice_no' => $newInvoiceNo,
                'batch_no' => $request->input('batch_no'),
                'type' => 'production',
                'recipe_id' => $request->input('recipe_id'),
                'production_material_tons' => $request->input('production_material_tons'),
                'description' => $request->input('description'),
                'production_qty' => $request->production_sub_total_weight,
                'output_qty' => $request->output_sub_total_weight,
                'surplus_qty' => $request->surplus_sub_total_weight,
                'grand_total' => $request->total_production_cost,
                'output_bags' => $request->output_bags,
                'surplus_bags' => $request->surplus_bags,

            ];

            $invoice_master_id  = DB::table('invoice_master')->insertGetId($invoice_master);


           

            //production
            for($i=0; $i < count($request->production_item_id); $i++)
            {
                 $invoice_detail = [
                     'invoice_master_id' => $invoice_master_id,
                     'date' => $request->input('date'),
                     'invoice_no' => $newInvoiceNo,
                     'type' => 'production',
                     'item_id' => $request->production_item_id[$i],
                     'net_weight' => $request->production_quantity_weight[$i],
                     
                     'per_unit_price' =>  $request->production_unit_cost[$i],
                     'grand_total' =>  $request->production_item_total_cost[$i],
                 ];
 
 
                 DB::table('invoice_detail')->insertGetId($invoice_detail);
 
            }
            //output
            if($request->has('output_item_id'))
            {

                for($i=0; $i < count($request->output_item_id); $i++)
                {
                    
                    $invoice_detail = [
                        'invoice_master_id' => $invoice_master_id,
                        'date' => $request->input('date'),
                        'invoice_no' => $newInvoiceNo,
                        'type' => 'output',
                        'item_id' => $request->output_item_id[$i],
                        'unit_weight' => $request->output_unit_weight[$i],
                        'per_unit_price' => $request->output_per_unit_cost[$i] / $request->output_unit_weight[$i] ,
                        'total_quantity' => $request->output_quantity[$i],
                        'net_weight' => $request->output_quantity_weight[$i],
                        'total_price' => $request->output_total_cost[$i],
                        'grand_total' => $request->output_total_cost[$i],//output Grand Total
                        'is_surplus' =>  $request->is_surplus[$i],
                    ];
    
                    DB::table('invoice_detail')->insertGetId($invoice_detail);
    
                }

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        try {
            $production = InvoiceMaster::with(['productionDetails','outputDetails'])->find($id);
        
            return view('productions.show', compact('production'));

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
        $goodItems  = Item::where('type','Good')->get();
        $units = Unit::all();
        $recipes = Recipe::where('is_active',1)->get();
        
        try {
            $production = InvoiceMaster::with(['productionDetails','outputDetails'])->find($id);
            return view('productions.edit', compact('production','goodItems','units','recipes'));

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
        // dd($request->all());
        // Start a transaction
        DB::beginTransaction();

        try {

            // Validate the request data
            $validator = Validator::make($request->all(), [
                'recipe_id' => 'required',
                'production_material_tons' => 'required',
                
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ]);
            }
            
            $production = InvoiceMaster::find($id);

            $invoice_master = [
                'date' => $request->input('date'),
                'expiry_date' => $request->input('expiry_date'),
                'batch_no' => $request->input('batch_no'),
                'type' => 'production',
                'recipe_id' => $request->input('recipe_id'),
                'production_material_tons' => $request->input('production_material_tons'),
                'description' => $request->input('description'),
                'production_qty' => $request->production_sub_total_weight,
                'output_qty' => $request->output_sub_total_weight,
                'surplus_qty' => $request->surplus_sub_total_weight,
                'grand_total' => $request->total_production_cost,
                'output_bags' => $request->output_bags,
                'surplus_bags' => $request->surplus_bags,
            ];
            $invoice_master_id = $production->id;
            $invoice_no = $production->invoice_no;
            DB::table('invoice_master')->where('id', $production->id)->update($invoice_master);
            
           
            DB::table('invoice_detail')->where('invoice_master_id',$production->id)->delete();

            //production
            for($i=0; $i < count($request->production_item_id); $i++)
            {
                $invoice_detail = [
                    'invoice_master_id' => $invoice_master_id,
                    'date' => $request->input('date'),
                    'invoice_no' => $invoice_no,
                    'type' => 'production',
                    'item_id' => $request->production_item_id[$i],
                    'net_weight' => $request->production_quantity_weight[$i],
                    'per_unit_price' =>  $request->production_unit_cost[$i],
                    'grand_total' =>  $request->production_item_total_cost[$i],
                ];
                DB::table('invoice_detail')->insertGetId($invoice_detail);
            }


            //output
            if($request->has('output_item_id'))
            {       
                for($i=0; $i < count($request->output_item_id); $i++)
                {
                    $invoice_detail = [
                        'invoice_master_id' => $invoice_master_id,
                        'date' => $request->input('date'),
                        'invoice_no' => $invoice_no,
                        'type' => 'output',
                        'item_id' => $request->output_item_id[$i],
                        'unit_weight' => $request->output_unit_weight[$i],
                        'per_unit_price' => $request->output_per_unit_cost[$i] / $request->output_unit_weight[$i] ,
                        'total_quantity' => $request->output_quantity[$i],
                        'net_weight' => $request->output_quantity_weight[$i],
                        'total_price' => $request->output_total_cost[$i],
                        'grand_total' => $request->output_total_cost[$i],//output Grand Total
                        'is_surplus' =>  $request->is_surplus[$i],

                    ];
    
                    DB::table('invoice_detail')->insertGetId($invoice_detail);
    
                }
               
            }
               

            DB::commit();// Commit the transaction

            // Return a JSON response with a success message
            return response()->json([
                'success' => true,
                'message' => 'Production update successfully.',
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


    public function posting($id){

        DB::beginTransaction();
        try {

            $production = InvoiceMaster::find($id);

            $recipe = 'Recipe: ' .$production->recipe->name;
            $batches = ' Total Batches: '.number_format($production->production_material_tons,0);
            $cost = ' Cost: '.$production->grand_total;

            $narration = $recipe . $batches . $cost;
            

            $journalCredit = [
                'date' => $production->date,
                'voucher_no' => $production->invoice_no,
                'type' => 'production',
                'chart_of_account_id' => env('RAW_MATERIAL'),
                'narration' => $narration ,
                'production_id' => $production->id,
                'credit' =>  $production->grand_total,
                'trace' => '',
                'created_by' => Auth::user()->id,
                'created_at' => now(),
            ];
            
            DB::table('journals')->insert($journalCredit);
    
            $journalDebit = [
    
                'date' => $production->date,
                'voucher_no' => $production->invoice_no,
                'type' => 'output',
                'chart_of_account_id' => env('FINISHED_GOOD'),
                'narration' => $narration ,
                'production_id' => $production->id,
                'debit' =>  $production->grand_total,
                'trace' => '',
                'created_by' => Auth::user()->id,
                'created_at' => now(),
            ];
            
            DB::table('journals')->insert($journalDebit);
    
            $production->update([
                'is_lock' => 1
            ]);
        
            DB::commit();

             // Return a JSON response with a success message
            //  return response()->json([
            //     'success' => true,
            //     'message' => 'Production Posting successfully.',
            // ],200);
            return redirect()->back();


        } catch (\Exception $e) {
            DB::rollBack();
            // Handle the exception
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function unposting($id)
    {

        DB::beginTransaction();
        try {
            $production = InvoiceMaster::find($id);
            DB::table('journals')->where('production_id',$production->id)->delete();
            $production->update([
                'is_lock' => 0
            ]);
            DB::commit();
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            // Handle the exception
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }   


}
