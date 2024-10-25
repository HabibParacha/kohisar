<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Unit;
use App\Models\Receipe;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ReceipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        

        try{
            if ($request->ajax()) {
                $data = Receipe::all();
    
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
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="'. route('receipe.show', $row->id) .'"  class="dropdown-item">
                                                <i class="bx bx-show font-size-16 text-primary me-1"></i> Show
                                            </a>
                                        </li>
                                        <li>
                                            <a href="'.route('receipe.edit', $row->id).'" class="dropdown-item">
                                                <i class="bx bx-pencil font-size-16 text-secondary me-1"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" onclick="deleteReceipe(' . $row->id . ')" class="dropdown-item">
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
    
            return view('receipes.index');

        }catch (\Exception $e){

            return back()->with('flash-danger', $e->getMessage());
        }
        
        
    }

    public function create()
    {
        $items  = Item::all();
        $units = Unit::all();

        return view('receipes.create', compact('items','units'));
    }

    public function store(Request $request)
    {
        // Start a transaction
        DB::beginTransaction();

        try {

            // Validate the request data
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'nullable', // Validation for image
                'item_id.*' => 'required',
                'unit_id.*' => 'required',
                'quantity.*' => 'required',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ]);
            }


            $receipe = [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'user_id' => Auth::id(),
            ];

            $receipe_id = DB::table('receipes')->insertGetId($receipe);


            for($i=0; $i < count($request->item_id); $i++)
            {
                $receipeDetail = [
                    'receipe_id' => $receipe_id,
                    'item_id'    => $request->item_id[$i],
                    'unit_id'    => $request->unit_id[$i],
                    'quantity'   => $request->quantity[$i],
                ];

                DB::table('receipe_detail')->insert($receipeDetail);
                
            }

            DB::commit();// Commit the transaction

            // Return a JSON response with a success message
            return response()->json([
                'success' => true,
                'message' => 'Receipe added successfully.',
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
    public function show($id)
    {
        $items  = Item::all();
        $units = Unit::all();
        try {
            $receipe = Receipe::findOrFail($id);
            $receipeDetails = $receipe->receipeDetails;
            return view('receipes.show', compact('receipe','receipeDetails','items','units'));

        } catch (\Exception $e) {
            // Return a JSON response with an error message
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
            ], 500);
        }
    }

    public function edit($id)
    {
        $items  = Item::all();
        $units = Unit::all();
        try {
            $receipe = Receipe::findOrFail($id);
            $receipeDetails = $receipe->receipeDetails;
            return view('receipes.edit', compact('receipe','receipeDetails','items','units'));

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
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'nullable', // Validation for image
            'item_id.*' => 'required',
            'unit_id.*' => 'required',
            'quantity.*' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }



        DB::beginTransaction();
        

       try {
            $receipe = [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'user_id' => Auth::id(),
            ];

          DB::table('receipes')->where('id',$id)->update($receipe);
          DB::table('receipe_detail')->where('receipe_id',$id)->delete();


            for($i=0; $i < count($request->item_id); $i++)
            {
                $receipeDetail = [
                    'receipe_id' => $id,
                    'item_id'    => $request->item_id[$i],
                    'unit_id'    => $request->unit_id[$i],
                    'quantity'   => $request->quantity[$i],
                ];

                DB::table('receipe_detail')->insert($receipeDetail);
                
            }

            DB::commit();// Commit the transaction

           // Return a JSON response with a success message
           return response()->json([
               'success' => true,
               'message' => 'Receipe Update successfully.',
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
            $receipe = Receipe::find($id);

            DB::table('receipe_detail')->where('receipe_id',$id)->delete();

            $receipe->delete();// Delete the receipe record

            DB::commit();// Commit the transaction
            
            return response()->json([
                'success' => true,
                'message' => 'Receipe Delete successfully.',
                ],200);
                
        } catch (\Exception $e) {
          
            DB::rollBack();  // Rollback the transaction if there is an error

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
        
    }


   


}
