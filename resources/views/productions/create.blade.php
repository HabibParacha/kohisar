@extends('template.tmp')
@section('title', 'kohisar')

@section('content')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>
    /* Chrome, Safari, Edge, Opera : remove spin input type number*/
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
      

    }

    .table>:not(caption)>*>* {
    padding: 0.15rem .15rem !important;
    }

    table tbody tr input.form-control{
    
        border-radius: 0rem !important;
        font-size: 11px;
    
    }

    #summary-table input.form-control{
        /* border: 0; */
        border-radius: 0.25rem !important;
    }

    .form-control:disabled, .form-control[readonly] {
    background-color: #eff2f780 !important;
    opacity: 1;

   
}
    /* material table input */
    #material-table input{
        border: 1px solid #ced4da; 
        padding:3px;
    }
    #material-table input:read-only{
        border: none; 
        padding:3px;
    }
</style>
<style>
    .ui-state-highlight {
        height: 40px;
        background-color: #f0f0f0;
        color: #495057;
    }
</style>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <form id="production-store" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            {{-- <h4 class="card-title mb-4">Purchase Order</h4> --}}
                            <h4 class="card-title mb-4">Production Plan</h4>

                            <div class="row">
                               
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Production  No</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bx-receipt"></span> </div>
                                            <input type="text" name="invoice_no"  class="form-control" value="{{ $newInvoiceNo }}" readonly>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="col-md-3 d-none">
                                    <div class="mb-3">
                                        <label class="form-label">batch No</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bx-barcode" ></span> </div>
                                            <input type="text" name="batch_no"  class="form-control" autocomplete="off">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Recipes</label>
                                        <select name="recipe_id" id="recipe_id" class="select2 form-control" autofocus>                                                
                                            <option value="">Choose...</option>
                                            @foreach ($recipes as $recipe)
                                                <option value="{{$recipe->id}}">{{ '('.$recipe->id.') '.$recipe->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>                                        
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-2">
                                        <label class="form-label">Total Tons</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="mdi mdi-weight"></span> </div>
                                            <input type="number" name="production_material_tons" id="production_material_tons" step="0.0001" class="form-control" disabled>
                                        </div> 
                                        <span id="production_material_tons_message" class="text-danger">Please Select Recipe</span>
                                    </div> 
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Output</label>
                                        <select  id="output-item" class="form-control select2" style="width:100%" >                                                
                                            <option value="" >Choose...</option>
                                            @foreach ($goodItems as $item)
                                                <option value="{{$item->id}}" data-unit-id="{{ $item->unit_id }}"  data-unit-weight="{{ $item->unit_weight }}">{{ $item->code.'-'.$item->category->name .'-'.$item->name }}</option>
                                            @endforeach
                    
                                        </select>
                                    </div>                                        
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Date</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bx-calendar" ></span> </div>
                                            <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}">
                                        </div>
                                       
                                    </div> 
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Expiry Date</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bx-calendar" ></span> </div>
                                            <input type="date" name="expiry_date"  class="form-control" value="{{ date('Y-m-d') }}">
                                        </div>
                                       
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bx-message-square-dots" ></span> </div>
                                            <input type="text" name="description"  class="form-control" autocomplete="off">
                                        </div> 
                                    </div> 
                                </div>
                                
                            </div>
                        </div> 
                    </div>

                    
                    <div class="row">
                       <div class="col-md-12">
                            <div class="card">
                        
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Marerial</h4>
                                    <div class="table-responsive">
                                        <table id="material-table" class="table table-border" style="border-collapse:collapse;">
                                            <thead>
                                                <tr>
                                                    <th width="10%" class="text-start">Item Name</th> 
                                                    <th width="10%" class="d-none">Unit</th> 
                                                    <th width="10%" class="text-end">Recipe QTY</th> 
                                                    <th width="10%" class="text-end">Production QTY</th> 
                                                    <th width="10%" class="text-end">Stock QTY</th> 
                                                    <th width="10%" class="text-end d-none">Unit Cost</th> 
                                                    <th width="10%" class="text-end d-none">Total Cost</th> 
                                                    <th width="20%" class="text-center">status</th> 
                                                
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                            
                                            </tbody> 
                                            <tfoot>
                                                <tr class="text-end">
                                                    <td  class="fw-bold text-start">TOTAL</td>
                                                    <td><input type="number" id="materail_recipe_qty_total" class="fw-bold text-end" readonly></td>
                                                    <td><input type="number" id="materail_production_qty_total" class="text-end fw-bold" readonly></td>
                                                    <td><input type="number" id="materail_stock_qty_total" class="text-end fw-bold" readonly></td>
                                                    <td class="d-none"><input type="number" id="materail_avg_unit_price" class="text-end fw-bold" readonly></td>
                                                    <td class="d-none"><input type="number" id="materail_total_cost" class="text-end fw-bold" readonly></td>
                                                    <td></td>
                                                    
                                                </tr>
                                            </tfoot>
                                        </table>
        
                                    </div> 
                                
        
                                
                                </div>
        
                            </div>
                       </div>
                     
    
                        <div class="col-md-12">
                            <div class="card">
                          
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Output</h4>
                                    <div class="table-responsive">
                                        <table id="output-table" class="table table-border" style="border-collapse:collapse;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" width="30"></th>
                                                    <th class="text-center" width="30">Surplus</th> 
                                                    <th class="text-center" width="200">Item Name</th> 
                                                    <th class="d-none" width="150">Unit Name</th> 
                                                    <th class="text-center" width="150">Unit Weight</th> 
                                                    <th class="text-center" width="100">Bags Qty.</th> 
                                                    <th class="text-center" width="100">QTY Weight</th> 
                                                    <th class="text-center" width="100">Unit Cost</th> 
                                                    <th class="text-center" width="100">Total Cost</th> 
                                                    <th class="text-center" width="50"></th>
                                                
                                                </tr>
                                            </thead>
                                            <tbody id="sortable-table">
                                                
                                               
                                            </tbody> 
                                        </table>
        
                                        <button id="btn-add-more" class="btn btn-primary"><span class="bx bx-plus"></span> Add More</button>
                                    </div> 
                                   
                                 
        
                                  
                                </div>
                                
                            </div>
                        </div>
                      
                    </div>





                    <div class="row mt-3">
                        
                        <div class="col-md-6 d-flex justify-content-end offset-md-6">
                       <div class="card">
                           
                           
                            <div class="card-body">
                                <h4 class="card-title mb-4">Summary</h4>
                                <table id="summary-table" class="table">
                                    <tr>
                                        <th width="50%">Production <sub>KG's</sub></th>
                                        <td width="50%">
                                            <input type="number" name="production_sub_total_weight" id="production-sub-total-weight" value="0" class="form-control text-end border-0 fw-bold" readonly>
                                        </td>
                                    </tr>  
                                    <tr>
                                        <th width="50%">Output <sub>KG's</sub></th>
                                        {{-- <td width="50%">
                                        </td> --}}
                                        <td>
                                            <div class="input-group">
                                                    <span class="input-group-text"> KG's</span>
                                                    <input type="number" name="output_sub_total_weight" id="output-sub-total-weight" value="0" class="form-control text-end border-0 fw-bold" readonly>

                                            </div>
                                            <div class="input-group ">
                                                <span class="input-group-text">Bags</span>
                                                <input type="number" name="output_bags" id="output-bags" value="0" class="form-control text-end border-0 fw-bold" readonly>
                                            </div>
                                        </td>
                                    </tr>  
                                    <tr>
                                        <th width="50%">Surplus <sub>KG's</sub></th>
                                        <td width="50%">
                                            <div class="input-group">
                                                <span class="input-group-text"> KG's</span>
                                                <input type="number" name="surplus_sub_total_weight" id="surplus-sub-total-weight" value="0" class="form-control text-end border-0 fw-bold" readonly>

                                            </div>
                                            <div class="input-group ">
                                                <span class="input-group-text">Bags</span>
                                                <input type="number" name="surplus_bags" id="surplus-bags" value="0" class="form-control text-end border-0 fw-bold" readonly>
                                            </div>
                                        </td>
                                    </tr>  
                                    <tr>
                                        <th width="50%">Prod. Cost</th>
                                        <td width="50%">
                                            <input type="number" name="total_production_cost" id="total-production-cost" value="0" class="form-control text-end border-0 fw-bold" readonly>
                                        </td>
                                    </tr>  
                                
                        
                                
                                </table>
                            </div>
                        </div>
                       </div>
                    </div>  

                    
                    <div class="row  mt-2">
                       
                        <div class="col-md-12 text-end">
                            {{-- <button type="submit" id="submit-production-store"  class="btn btn-success w-md">Save</button> --}}
                            <button type="button" id="submit-production-store" disabled  class="btn btn-success w-md">Save</button>
                            <a href="{{ route('production.index') }}"class="btn btn-secondary w-md ">Cancel</a>
        
                        </div>

                    </div>
                </form>    
             
            </div>
         </div>
         
    </div>

    <!-- Progress Modal -->
    <div class="modal fade" id="progressModal" tabindex="-1" aria-labelledby="progressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5 class="modal-title" id="progressModalLabel">Processing...</h5>
                    <!-- You can use either a spinner or a progress bar -->
                    
                    <!-- Option 1: Spinner -->
                    <div class="spinner-border text-primary my-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    
                    <!-- Option 2: Progress Bar (if you want an animated bar instead) -->
                    <!-- Uncomment to use the progress bar instead of the spinner -->
                    <!--
                    <div class="progress my-3">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>

  
    <!-- Quantity Mismatch Modal -->
    <div class="modal fade" id="quantityMismatchModal" tabindex="-1" aria-labelledby="quantityMismatchLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-white">
                    <h5 class="modal-title d-flex align-items-center" id="quantityMismatchLabel">
                        <i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 1.5rem;"></i> <!-- Bootstrap icon for warning -->
                        Quantity Mismatch Warning
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="text-danger fw-bold">Production and output quantities do not match!</p>
                    <p>Are you sure you want to proceed with creating the production?</p>
                    
                    <!-- Display Production Quantity, Output Quantity, and Difference -->
                    <div class="alert alert-info">
                        <div class="d-flex justify-content-between">
                            <strong>Production Quantity:</strong>
                            <span id="productionQty">0</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <strong>Output Quantity:</strong>
                            <span id="outputQty">0</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <strong>Difference <sub>(output - production)</sub> </strong>
                            <span id="quantityDifference">0</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="yes-proceed-btn" type="button" class="btn btn-danger">Yes, Proceed</button>
                    <button id="cancelButton" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    





    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
<script>
     $(document).ready(function () {
       
        // appendNewRow();
    });
    //tfoot of material table
    

    $('#production-store').on('keydown', function(e) {
        if (e.key === 'Enter') {
        e.preventDefault(); // Prevent the default behavior (form submission)
        }
    });
</script>    

@include('productions.js')

<script>
    
  
    $('#submit-production-store').on('click', function(e){

        storeProduction();

    //     e.preventDefault();

        //    let prodcution_weight =  parseFloat($('#production-sub-total-weight').val()) || 0;
        //    let output_weight =  parseFloat($('#output-sub-total-weight').val()) || 0;
        //    let difference = output_weight - prodcution_weight;

        //    if(prodcution_weight == 0)
        //    {
        //         alert("Add Total Tons Value");
        //         return;
                
        //    }
        

        //    $('#productionQty').text(prodcution_weight.toFixed(2));
        //    $('#outputQty').text(output_weight.toFixed(2));
        //    $('#quantityDifference').text(difference.toFixed(2));

        //    if(prodcution_weight != output_weight)
        //    {
        //     $('#quantityMismatchModal').modal('show');   
        //    }
        //    else{
        //     storeProduction();
    //    }
 
    });
    $('#yes-proceed-btn').on('click',function(e){
        e.preventDefault();
        storeProduction();

    });


</script>


{{-- START:: Store Data using AJAX --}}


<script>
    function storeProduction()
    {
       
        var submit_btn = $('#submit-production-store');
        let createformData = new FormData($('#production-store')[0]);
        $.ajax({
            type: "POST",
            url: "{{ route('production.store') }}",
            dataType: 'json',
            contentType: false,
            processData: false,
            cache: false,
            data: createformData,
            enctype: "multipart/form-data",
            beforeSend: function() {
                submit_btn.prop('disabled', true);
                submit_btn.html('Processing');
            },
            success: function(response) {
                
                submit_btn.prop('disabled', false).html('Save');  

                if(response.success == true){
                    $('#production-store')[0].reset();  // Reset all form data
                
                    notyf.success({
                        message: response.message, 
                        duration: 3000
                    });

                    // Redirect after success notification
                    setTimeout(function() {
                        window.location.href = '{{ route("production.create") }}';
                    }, 200); // Redirect after 3 seconds (same as notification duration)


                }else{
                    notyf.error({
                        message: response.message,
                        duration: 5000
                    });
                }   
            },
            error: function(e) {
                submit_btn.prop('disabled', false).html('Save');
            
                notyf.error({
                    message: e.responseJSON.message,
                    duration: 5000
                });
            }
        });
    
    }
   
            
</script>
{{-- END:: Store Data using AJAX --}}



@endsection
