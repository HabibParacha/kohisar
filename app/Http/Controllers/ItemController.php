<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Models\Item;
use App\Models\Unit;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Variation;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $categories = Category::all();
        $brands = Brand::all();
        // $variation = DB::table('variations')->get();
        $taxes = Tax::all();
        $units = Unit::all();
        $warehouses = Warehouse::all();

        $itemTypes = $this->itemTypes();
      

        try{
            if ($request->ajax()) {
                $data = Item::all();
    
                return Datatables::of($data)
                    ->addIndexColumn()
                    // Status toggle column

                    ->addColumn('category_name', function ($row) {
                        return ($row->category_id) ? $row->category->name : '-';
                    })
                    ->addColumn('tax_name', function ($row) {
                        return ($row->tax_id) ?  $row->tax->name : '-';
                    })
                    ->addColumn('unit', function ($row) {
                        return ($row->unit_id) ? $row->unit->base_unit.' , '.$row->unit->child_unit : '-';
                        
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
                                            <a href="javascript:void(0)" onclick="editItem(' . $row->id . ')" class="dropdown-item">
                                                <i class="bx bx-pencil font-size-16 text-secondary me-1"></i> Edit
                                            </a>
                                        </li>
                                         <li>
                                            <a href="javascript:void(0)" onclick="deleteItem(' . $row->id . ')" class="dropdown-item">
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
    
            return view('items.index', compact('categories','brands','taxes','units','warehouses','itemTypes'));

        }catch (\Exception $e){

            return back()->with('flash-danger', $e->getMessage());
        }
        
        
    }

    public function store(Request $request)
    {
        
        // Start a transaction
        DB::beginTransaction();

        try {

            // Validate the request data
            $validator = Validator::make($request->all(), [
                'type' => 'required',
                'code' => 'required|unique:items,code', 
                'name' => 'required',
                'stock_alert_qty' => 'nullable',
                'is_active' => 'nullable',
            ]);

            if($request->type == "Good")
            {
                $validator = Validator::make($request->all(), [
                    'category_id' => 'required',
                    'unit_id' => 'required', 
                    'tax_id' => 'required', 
                    'unit_weight' => 'required',
                ]);
            }
            // Validate the request data
           



            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ]);
            }

            $data = $request->all();// storing request data in array

            Item::create($data);

            DB::commit();// Commit the transaction

            // Return a JSON response with a success message
            return response()->json([
                'success' => true,
                'message' => 'Item added successfully.',
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
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        
        try {
            $data = Item::findOrFail($id);
            return response()->json($data);

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
     */

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        $item = Item::findOrFail($id);

        // Validate the request data
        $validator = Validator::make($request->all(), [
            // 'type' => 'required', // making type disable in update, type can't be changed
            'code' => 'required|unique:items,code,'.$item->id,
            'name' => 'required',
            'category_id' => 'nullable',
            'unit_id' => 'required', 
            'tax_id' => 'nullable', 
            'stock_alert_qty' => 'nullable',
            'unit_weight' => 'nullable',
            'is_active' => 'nullable',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

       
        $data = $request->all();// storing request data in array
      

       try {
           $item = Item::findOrFail($id);

           $item->update($data);

           DB::commit();// Commit the transaction

           // Return a JSON response with a success message
           return response()->json([
               'success' => true,
               'message' => 'Item Update successfully.',
               ],200);


       } catch (\Exception $e) {
          
           DB::rollBack(); // Rollback the transaction if there is an error

           // Return a JSON response with an error message
           return response()->json([
               'success' => false,
               'message' => $e->getMessage(),
           ], 500);
       }
   }

    /**
     * Remove the specified resource from storage.
     */
   
    public function destroy($id)
    {
        

        DB::beginTransaction();// Start a transaction

        try {
            $item = Item::find($id);

            // Check if the item has any associated invoice details
            $invoiceDetailExists = $item->invoiceDetails()->exists();
            $recipeDetailExists = $item->recipeDetails()->exists();
            
            if ($invoiceDetailExists || $recipeDetailExists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item cannot be deleted due to links with existing invoices or recipes'
                ], 409);
            }

            $item->delete();// Delete the item record

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

    public function itemTypes()
    {
        $data = [
            'Raw',
            'Good',
        ];

        return $data;
    }

    public function getAllItems(){
        $items = Item::all();
        return response()->json($items);
    }


   


}
