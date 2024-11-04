<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Unit;
use App\Models\Recipe;
use Illuminate\Http\Request;
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
        try{
            if ($request->ajax()) {
                $data = InvoiceMaster::where('type','production')
                ->orderBy('id','desc')
                ->orderBy('date','desc')
                ->get();
    
                return Datatables::of($data)
                    ->addIndexColumn()
                    // Status toggle column

                    ->addColumn('recipe_name', function($row){
                        return ($row->recipe_id) ? $row->recipe->name : '-';
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
                                        </li>
                                        <li>
                                            <a href="'. route('production.edit', $row->id).'" class="dropdown-item">
                                                <i class="bx bx-pencil font-size-16 text-secondary me-1"></i> Edit
                                            </a>
                                        </li>
                                         <li>
                                            <a href="javascript:void(0)" onclick="deleteProduction(' . $row->id . ')" class="dropdown-item">
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
    
            return view('productions.index');

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
        $recipes = Recipe::all();
        
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
                'batch_no' => 'required',
                'production_material_tons' => 'required',
                
            ]);

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
            ];

            $invoice_master_id  = DB::table('invoice_master')->insertGetId($invoice_master);

            for($i=0; $i < count($request->production_item_id); $i++)
            {
                 $invoice_detail = [
                     'invoice_master_id' => $invoice_master_id,
                     'date' => $request->input('date'),
                     'invoice_no' => $newInvoiceNo,
                     'type' => 'production',
                     'item_id' => $request->production_item_id[$i],
                     'net_weight' => $request->production_quantity_weight[$i],
                 ];
 
 
                 DB::table('invoice_detail')->insertGetId($invoice_detail);
 
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
        //
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
