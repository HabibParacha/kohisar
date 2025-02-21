<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;




class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        

        try{
            if ($request->ajax()) {
                $data = Customer::all();
    
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
                                            <a href="javascript:void(0)" onclick="editCustomer(' . $row->id . ')" class="dropdown-item">
                                                <i class="bx bx-pencil font-size-16 text-secondary me-1"></i> Edit
                                            </a>
                                        </li>
                                         <li>
                                            <a href="javascript:void(0)" onclick="deleteCustomer(' . $row->id . ')" class="dropdown-item">
                                                <i class="bx bx-trash font-size-16 text-danger me-1"></i> Delete
                                            </a>
                                        </li>
                                       
                                       
                                    </ul>
                                </div>
                            </div>';
    
                   
                    return $btn;
                   
                    })
                    
                    ->addColumn('image', function ($row) {
                        $imageUrl = $row->image 
                            ? URL::asset('/build/img/customer/' . $row->image) 
                            : URL::asset('/build/img/default.png');
                    
                        return '
                            <a href="javascript:void(0);" class="item-img stock-img">
                                <img src="' . $imageUrl . '" alt="'.$row->image .'"  width="50px" height="50px" >
                            </a>';
                    })

    
                    ->rawColumns(['action','image']) // Mark these columns as raw HTML
                    ->make(true);
            }
    
            return view('customers.index');

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
                'name' => 'required|string|max:250',
                'contact_person' => 'nullable|string|max:250',
                'mobile_no' => 'nullable|numeric',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for image
                'is_active' => 'boolean'

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ]);
            }

            $data = $request->all();// storing request data in array

             // Handle the image upload
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('build/img/customer'), $imageName);
                $data['image'] = $imageName; // Save the image name in the data array
            }

            Customer::create($data);

            DB::commit();// Commit the transaction

            // Return a JSON response with a success message
            return response()->json([
                'success' => true,
                'message' => 'Customer added successfully.',
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
            $data = Customer::findOrFail($id);
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
        
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:250',
            'contact_person' => 'nullable|string|max:250',
            'mobile_no' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for image
            'is_active' => 'boolean'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        //check if customer is busy in
        $customer = Customer::where('id',$id)
        ->whereIn('id', function ($query) {
            $query->select('customer_id')
                  ->from('vehicle_assignments')
                  ->where('status', 1);
        })->first();
        // if customer is busy you can't update the status
        if($customer)
        {
            return response()->json([
                'success' => false,
                'message' => 'Customer is busy can\'t update the status.',
            ],200);
        }

        $data = $request->all();// storing request data in array
      

       try {
           $customer = Customer::findOrFail($id);

           // Handle the image upload
           if ($request->hasFile('image')) {
               // Delete old image if it exists
               if ($customer->image && $customer->image != 'default.jpg') {
                   unlink(public_path('build/img/customer/' . $customer->image));
               }

               $imageName = time() . '.' . $request->image->extension();
               $request->image->move(public_path('build/img/customer'), $imageName);
               $data['image'] = $imageName; // Save the image name in the data array
           }


           $customer->update($data);

           DB::commit();// Commit the transaction

           // Return a JSON response with a success message
           return response()->json([
               'success' => true,
               'message' => 'Customer Update successfully.',
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
            $customer = Customer::find($id);

            $customer->delete();// Delete the customer record

            DB::commit();// Commit the transaction
            
            return response()->json([
                'success' => true,
                'message' => 'Customer Delete successfully.',
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
