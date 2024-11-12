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
                            <h4 class="card-title mb-4">Production</h4>

                            <div class="row">
                               
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Receipt No</label>
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
                                                <option value="{{$recipe->id}}">{{ $recipe->name }}</option>
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


                    <div class="card">
                      
                        <div class="card-body">
                            <h4 class="card-title mb-4">Marerial</h4>
                            <div class="table-responsive">
                                <table id="material-table" class="table table-border" style="border-collapse:collapse;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Item Name</th> 
                                            <th class="text-center">Unit</th> 
                                            <th class="text-center">Recipe QTY</th> 
                                            <th class="text-center">Production QTY</th> 
                                            <th class="text-center">Stock QTY</th> 
                                            <th class="text-center">status</th> 
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                       
                                    </tbody> 
                                </table>

                            </div> 
                           

                          
                        </div>

                    </div>
                 

                    <div class="card">
                      
                        <div class="card-body">
                            <h4 class="card-title mb-4">Output</h4>
                            <div class="table-responsive">
                                <table id="table" class="table table-border" style="border-collapse:collapse;">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="50"></th>
                                            <th class="text-center" width="200">Item Name</th> 
                                            <th class="text-center" width="150">Unit Name</th> 
                                            <th class="text-center" width="150">Unit Weight</th> 
                                            <th class="text-center" width="100">QTY</th> 
                                            <th class="text-center" width="100">QTY Weight</th> 
                                            <th class="text-center" width="50"></th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody id="sortable-table">
                                       
                                       
                                    </tbody> 
                                </table>

                                <button id="btn-add-more" class="btn btn-primary"><span class="bx bx-plus"></span> Add More</button>
                            </div> 
                           
                         

                          
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-8">
                            </div>
                            
                            <div class="col-md-4 d-flex align-items-center">
                                <table id="summary-table" class="table">
                                    <tr>
                                        <th width="50%">Production Sub Total Weight</th>
                                        <td width="50%">
                                            <input type="number" name="production_sub_total_weight" id="production-sub-total-weight" value="0" class="form-control text-end" readonly>
                                        </td>
                                    </tr>  
                                    <tr>
                                        <th width="50%">Output Sub Total Weight</th>
                                        <td width="50%">
                                            <input type="number" name="output_sub_total_weight" id="output-sub-total-weight" value="0" class="form-control text-end" readonly>
                                        </td>
                                    </tr>  
                                  
                        
                                   
                                </table>
                            </div>
                        </div>  

                    </div>
                    
                    
                    <div class="row  mt-2">
                       
                        <div class="col-md-12 text-end">
                            {{-- <button type="submit" id="submit-production-store"  class="btn btn-success w-md">Save</button> --}}
                            <button type="button" id="submit-production-store"  class="btn btn-success w-md">Save</button>
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

  
    <!-- Modal -->
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

    $('#production-store').on('keydown', function(e) {
        if (e.key === 'Enter') {
        e.preventDefault(); // Prevent the default behavior (form submission)
        }
    });
</script>    

@include('productions.js')

<script>
    
    
    $('#submit-production-store').on('click', function(e){
        e.preventDefault();

       let prodcution_weight =  parseFloat($('#production-sub-total-weight').val()) || 0;
       let output_weight =  parseFloat($('#output-sub-total-weight').val()) || 0;
       let difference = output_weight - prodcution_weight;

       if(prodcution_weight == 0)
       {
            alert("Add Total Tons Value");
            return;
            
       }
       if(output_weight == 0)
       {
            let tableLength = $('#table').find('tr').length;
            
            alert("Add Output Item");
            // If only the header row is present, add a new row
            if (tableLength === 1) {
                appendNewRow();
            }
            return;
            
       }
       

       $('#productionQty').text(prodcution_weight.toFixed(2));
       $('#outputQty').text(output_weight.toFixed(2));
       $('#quantityDifference').text(difference.toFixed(2));

       if(prodcution_weight != output_weight)
       {
        $('#quantityMismatchModal').modal('show');   
       }
       else{
        storeProduction();
       }
 
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
                        window.location.href = '{{ route("production.index") }}';
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
    // $('#production-store').on('submit', function(e) {
    //     e.preventDefault();
    //     var submit_btn = $('#submit-production-store');
    //     let createformData = new FormData($('#production-store')[0]);
    //     $.ajax({
    //         type: "POST",
    //         url: "{{ route('production.store') }}",
    //         dataType: 'json',
    //         contentType: false,
    //         processData: false,
    //         cache: false,
    //         data: createformData,
    //         enctype: "multipart/form-data",
    //         beforeSend: function() {
    //             submit_btn.prop('disabled', true);
    //             submit_btn.html('Processing');
    //         },
    //         success: function(response) {
                
    //             submit_btn.prop('disabled', false).html('Save');  

    //             if(response.success == true){
    //                 $('#production-store')[0].reset();  // Reset all form data
                
    //                 notyf.success({
    //                     message: response.message, 
    //                     duration: 3000
    //                 });

    //                 // Redirect after success notification
    //                 setTimeout(function() {
    //                     window.location.href = '{{ route("production.index") }}';
    //                 }, 200); // Redirect after 3 seconds (same as notification duration)


    //             }else{
    //                 notyf.error({
    //                     message: response.message,
    //                     duration: 5000
    //                 });
    //             }   
    //         },
    //         error: function(e) {
    //             submit_btn.prop('disabled', false).html('Save');
            
    //             notyf.error({
    //                 message: e.responseJSON.message,
    //                 duration: 5000
    //             });
    //         }
    //     });
    // });
            
</script>
{{-- END:: Store Data using AJAX --}}


{{-- js.blade.php --}}

@endsection
{{-- START:: Production Table Function --}}
<script>
  
    // START:: input: Total Tons calculation
        $(document).on('keyup', '#production_material_tons', function(e){
        
            let production_material_tons = parseFloat($(this).val()) || 0;
            
            $('#material-table tbody tr').each(function() {
                // Get the recipe quantity for the current row
                let recipe_quantity = parseFloat($(this).find('.recipe-quantity').val()) || 0;

                // Calculate production quantity
                let production_quantity_weight = production_material_tons * recipe_quantity;

                // Insert the calculated production quantity into the production-quantity-weight cell
                $(this).find('.production-quantity-weight').val(production_quantity_weight.toFixed(4));

            
            });

            checkStockQuantity();// check stock and production quantity
            summaryCalculation();
        });

        function checkStockQuantity() {
            $('#material-table tbody tr').each(function() {
                let production_quantity_weight = parseFloat($(this).find('.production-quantity-weight').val()) || 0;
                let stock_quantity = parseFloat($(this).find('.stock-quantity').val()) || 0;
                
                // Check if stock quantity is greater than production quantity
                // 1)make production_quantity_weight red 2)show status out of stock 3)disable SAVE button
                if (stock_quantity < production_quantity_weight) {
                    $(this).find('.production-quantity-weight').addClass('text-danger');
                    $(this).find('.stock-status-cross').removeClass('d-none');  
                    $(this).find('.stock-status-tick').addClass('d-none');  

                } else {
                    $(this).find('.production-quantity-weight').removeClass('text-danger'); // Reset color if condition is not met
                    $(this).find('.stock-status-cross').addClass('d-none');  
                    $(this).find('.stock-status-tick').removeClass('d-none');  
                }
            });
        }
    // END:: input: Total Tons calculation    

    // START: Recipe and Material table   
        
        //on Change of recipe dropdown
        $(document).on('select2:select', '#recipe_id', function(e){
            let recipe_id = $(this).val();
            if(recipe_id){
                $('#production_material_tons').prop('disabled', false);
                $('#production_material_tons_message').addClass('d-none');


                getRecipeDetailWithStock(recipe_id);

            }
            else{
                $('#production_material_tons').prop('disabled', true).val('');//adding disable and val empty
                $('#production_material_tons_message').removeClass('d-none');
                $('#material-table tbody').empty();
            }
        
        
        });
            
        function getRecipeDetailWithStock(id) {
            $.get("{{ route('getRecipeDetailWithStock', ':id') }}".replace(':id', id), {
                beforeSend: function() {
                    $('#progressModal').modal('show'); // Show the progress bar before the request is sent
                }
            }).done(function(response) {
                $('#material-table tbody').empty();
                
                // Loop through the response data and append rows to the table
                response.recipeDetails.forEach(function(detail) {
                    $('#material-table tbody').append(
                        `<tr>
                            <td>
                                <input type="hidden" name="production_item_id[]" value="${detail.item_id}" readonly>
                                <input type="text" value="${detail.name}" readonly>
                            </td>
                            <td>
                                <input type="text" name="production_unit_id[]" value="${detail.base_unit}" readonly>
                            <td>
                                <input type="number" name="" step="0.0001" class="recipe-quantity text-end" value="${detail.quantity}" readonly>
                            </td>
                            <td>
                                <input type="number" name="production_quantity_weight[]" step="0.0001" class="production-quantity-weight text-end" readonly>
                            </td>
                            <td>
                                <input type="number" name="" step="0.0001" class="stock-quantity text-end" value="${detail.balance}" readonly>
                            </td> 
                           
                            <td>
                                <span class="stock-status-tick  bx bxs-check-circle text-success    fs-4"></span>
                                <span class="stock-status-cross bx bxs-x-circle     text-danger     fs-4 d-none"></span>
                            </td>
                        </tr>`
                    );
                });

                $('#progressModal').modal('hide'); // Hide the progress bar after the request completes
                $('#production_material_tons').focus();

            }).fail(function(xhr) {
                alert('Error fetching brand details: ' + xhr.responseText);
            });

        }

    // END: Recipe and Material table    

</script>


{{-- START:: Output Table Function --}}
    <script>
        // Change Item Dropdown
        $(document).on('change', '.output-item-dropdown', function(e){
        
            let selected_item = $(this).find('option:selected');
            
            let unit_id = selected_item.data('unit-id');
            let unit_weight = parseFloat(selected_item.data('unit-weight')) || 0;

            let row =  $(this).closest('tr');
            
            let unit_dropdown = row.find('.output-item-unit-dropdown');
            row.find('.output-unit-weight').val(unit_weight.toFixed(2));

            unit_dropdown.val(unit_id).trigger('change');
            $(this).select2('close');

            
            calculation(row);  
        });

    
        //Quantity Value Change
        $(document).on('keyup','.output-quantity', function(e){
            e.preventDefault(); // Prevent the default behavior (form submission)
            
            let row =  $(this).closest('tr');
            let quantity = parseFloat(row.find('.output-quantity').val()) || 0;
            let unit_weight = parseFloat(row.find('.output-unit-weight').val()) || 0;
            let quanity_weight = quantity*unit_weight;
            row.find('.output-quantity-weight').val(quanity_weight.toFixed(2));
            summaryCalculation();
        });

        // Click Add More Button
        $('#btn-add-more').on('click', function(e){
            e.preventDefault();
            appendNewRow();
        });

        //Click Trash Icon
        $(document).on('click', '.remove-item', function(e) {
            e.preventDefault();
            // Show a confirmation dialog
            if (confirm("Are you sure you want to remove this item?")) {
                // If confirmed, remove the row
                $(this).closest('tr').remove();

                // Recalculate the summary
                summaryCalculation();
            }
        });
        
        function appendNewRow(){
            let tableBody = $('#table tbody');

            let row = `
            <tr>
                <td><a style="cursor:grab"><i style="font-size:25px" class="mdi mdi-drag handle text-dark"></i></a> </td>

                <td> 
                    <select  name="output_item_id[]" class="form-control select2 output-item-dropdown" style="width:100%" >                                                
                        <option value="" >Choose...</option>
                        @foreach ($goodItems as $item)
                            <option value="{{$item->id}}" data-unit-id="{{ $item->unit_id }}"  data-unit-weight="{{ $item->unit_weight }}">{{ $item->code.'-'.$item->category->name .'-'.$item->name }}</option>
                        @endforeach

                    </select>

                </td> 
                <td> 
                    <select name="output_unit_id[]"  class="form-control select2 output-item-unit-dropdown" style="width:100%">                                                
                        <option>Choose...</option>
                        @foreach ($units as $unit)
                            <option value="{{$unit->id}}" data-base-unit-value="{{ $unit->base_unit_value }}" >{{ $unit->base_unit }}</option>
                        @endforeach
                    </select>

                </td> 

                <td>
                    <input type="number" name="output_unit_weight[]" step="0.0001" class="form-control output-unit-weight" readonly>  
                </td>
                <td>
                    <input type="number" name="output_quantity[]" step="0.0001" class="form-control output-quantity">  
                </td>
                <td>
                    <input type="number" name="output_quantity_weight[]" step="0.0001" class="form-control output-quantity-weight" readonly>  
                </td>
                <td class="text-center">  
                    <a href="#"><span style="font-size:18px" class="bx bx-trash text-danger remove-item"></span></a>
                </td>
            </tr>
            `;
        
            tableBody.append(row);
            $('.select2', 'table').select2();

        }
    
        function summaryCalculation()
        {
            let output_sub_total_weight = 0;
            let production_sub_total_weight = 0;
            let wastage_quantity_weight = 0;
            
    
            $('.output-quantity-weight').each(function(){
                let item_quantity_weight = parseFloat($(this).val()) || 0;
                output_sub_total_weight+= item_quantity_weight;
            });
            $('#output-sub-total-weight').val(output_sub_total_weight.toFixed(2));
    
            
            $('.production-quantity-weight').each(function(){
                let production_quantity_weight = parseFloat($(this).val()) || 0;
                production_sub_total_weight+= production_quantity_weight;
            });
            $('#production-sub-total-weight').val(production_sub_total_weight.toFixed(2));
    
    
            // checkProductionOutputWeight(output_sub_total_weight, production_sub_total_weight);
        }
    
        function checkProductionOutputWeight(output_weight, production_weight) {
            
            if(output_weight > production_weight){
                $('#production-sub-total-weight').addClass('text-danger');
            }else{
                $('#production-sub-total-weight').removeClass('text-danger');
            }
    
            if(output_weight == production_weight){
                $('#submit-production-store').prop('disabled', false);
            }else{
                $('#submit-production-store').prop('disabled', true);
            }
        }
    
    </script>
{{-- END:: Output Table Function --}}



{{-- START:: sortable #sortable-table --}}
    <script>
        $(function() {
            // Enable full sorting for tbody rows, allowing drag and drop from bottom to top
            $("#sortable-table").sortable({
                handle: ".handle",  // Set the 'handle' option to the bx-menu icon
                placeholder: "ui-state-highlight",  // Placeholder while dragging
                axis: "y",  // Restrict dragging to vertical movement
                update: function(event, ui) {
                    // This event is triggered when the row has been moved
                    console.log('Row moved');
                }
            }).disableSelection();  // Disable text selection while dragging
        });
    </script>
{{-- END:: sortable #sortable-table --}}
