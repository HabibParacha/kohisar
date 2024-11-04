<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Unit;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {

        try{
            if ($request->ajax()) {
                $data = Recipe::all();
    
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
                                            <a href="'. route('recipe.show', $row->id) .'"  class="dropdown-item">
                                                <i class="bx bx-show font-size-16 text-primary me-1"></i> Show
                                            </a>
                                        </li>
                                        <li>
                                            <a href="'.route('recipe.edit', $row->id).'" class="dropdown-item">
                                                <i class="bx bx-pencil font-size-16 text-secondary me-1"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" onclick="deleteRecipe(' . $row->id . ')" class="dropdown-item">
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
    
            return view('recipes.index');

        }catch (\Exception $e){

            return back()->with('flash-danger', $e->getMessage());
        }
        
        
    }

    public function create()
    {
        $items  = Item::all();
        $units = Unit::all();

        return view('recipes.create', compact('items','units'));
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


            $recipe = [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'user_id' => Auth::id(),
            ];

            $recipe_id = DB::table('recipes')->insertGetId($recipe);


            for($i=0; $i < count($request->item_id); $i++)
            {
                $recipeDetail = [
                    'recipe_id' => $recipe_id,
                    'item_id'    => $request->item_id[$i],
                    'unit_id'    => $request->unit_id[$i],
                    'quantity'   => $request->quantity[$i],
                ];

                DB::table('recipe_detail')->insert($recipeDetail);
                
            }

            DB::commit();// Commit the transaction

            // Return a JSON response with a success message
            return response()->json([
                'success' => true,
                'message' => 'Recipe added successfully.',
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
            $recipe = Recipe::findOrFail($id);
            $recipeDetails = $recipe->recipeDetails;
            return view('recipes.show', compact('recipe','recipeDetails','items','units'));

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
            $recipe = Recipe::findOrFail($id);
            $recipeDetails = $recipe->recipeDetails;
            return view('recipes.edit', compact('recipe','recipeDetails','items','units'));

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
            $recipe = [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'user_id' => Auth::id(),
            ];

          DB::table('recipes')->where('id',$id)->update($recipe);
          DB::table('recipe_detail')->where('recipe_id',$id)->delete();


            for($i=0; $i < count($request->item_id); $i++)
            {
                $recipeDetail = [
                    'recipe_id' => $id,
                    'item_id'    => $request->item_id[$i],
                    'unit_id'    => $request->unit_id[$i],
                    'quantity'   => $request->quantity[$i],
                ];

                DB::table('recipe_detail')->insert($recipeDetail);
                
            }

            DB::commit();// Commit the transaction

           // Return a JSON response with a success message
           return response()->json([
               'success' => true,
               'message' => 'Recipe Update successfully.',
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
            $recipe = Recipe::find($id);

            DB::table('recipe_detail')->where('recipe_id',$id)->delete();

            $recipe->delete();// Delete the recipe record

            DB::commit();// Commit the transaction
            
            return response()->json([
                'success' => true,
                'message' => 'Recipe Delete successfully.',
                ],200);
                
        } catch (\Exception $e) {
          
            DB::rollBack();  // Rollback the transaction if there is an error

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
        
    }


    public function getRecipeDetailWithStock($id)
    {
     
        try {
            $recipe = Recipe::findOrFail($id);
            $recipeDetails = DB::table('v_recipe_detail_stock')->where('recipe_id',$id)->get();

            return response()->json([
                'recipe' => $recipe,
                'recipeDetails' => $recipeDetails,
            ]);

        } catch (\Exception $e) {
            // Return a JSON response with an error message
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
            ], 500);
        }
    }


   


}
