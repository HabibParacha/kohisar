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

</style>
<style>
    .ui-state-highlight {
        height: 40px;
        background-color: #f0f0f0;
    }
</style>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <form id="recipe-update" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="recipe_id" id="recipe_id" value="{{  $recipe->id }}"> <!-- Hidden field to store the brand ID -->
                    @method('PUT')
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            {{-- <h4 class="card-title mb-4">Purchase Order</h4> --}}
                            <h4 class="card-title mb-4">Recipe</h4>

                            <div class="row">
                               
                                
                             
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bx-cube" ></span> </div>
                                            <input type="text" name="name" value="{{ $recipe->name }}" class="form-control" autocomplete="off">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bx-message-square-dots" ></span> </div>
                                            <input type="text" name="description" value="{{ $recipe->description }}" class="form-control" autocomplete="off">
                                        </div> 
                                    </div> 
                                </div>
                                
                            </div>
                        </div> 
                    </div>
                 

                    <div class="card">
                      
                        <div class="card-body">
                            <h4 class="card-title mb-4">Recipe Details</h4>
                            <div class="table-responsive">
                                <table id="table" class="table table-border" style="border-collapse:collapse;">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="50"></th>
                                            <th class="text-center" width="200">Material Name</th> 
                                            <th class="text-center" width="150">Unit</th> 
                                            <th class="text-center" width="100">QTY</th> 
                                            <th class="text-center" width="50"></th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody id="sortable-table">
                                        @foreach ( $recipeDetails  as $detail)
                                            <tr>
                                                <td><a style="cursor:grab"><i style="font-size:25px" class="mdi mdi-drag handle text-dark"></i></a> </td>
                                    
                                                <td> 
                                                    <select  name="item_id[]" class="form-control select2 item-dropdown-list" style="width:100%; border:1px solid red">                                                
                                                        <option >Choose...</option>
                                                        @foreach ($items as $item)
                                                            <option @if($item->id == $detail->item_id ) selected @endif value="{{$item->id}}" data-unit-id="{{ $item->unit_id }}">{{ $item->code.'-'. $item->name }}</option>
                                                        @endforeach
                                                        
                                                    </select>
                                                    
                                                </td> 
                                                <td> 
                                                    <select name="unit_id[]"  class="form-control select2 unit-dropdown-list" style="width:100%">                                                
                                                        <option>Choose...</option>
                                                        @foreach ($units as $unit)
                                                            <option @if($unit->id == $detail->unit_id ) selected @endif value="{{$unit->id}}" data-base-unit-value="{{ $unit->base_unit_value }}" >{{ $unit->base_unit }}</option>
                                                        @endforeach
                                                    </select>
                                                    
                                                </td> 
                                                <td>
                                                    <input type="number" name="quantity[]" value="{{ $detail->quantity  }}" step="0.0001" class="form-control item-quantity">  
                                                </td>
                                                <td class="text-center">  
                                                    <a href="#"><span style="font-size:18px" class="bx bx-trash text-danger remove-item"></span></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                       
                                    </tbody> 
                                </table>

                                <button id="btn-add-more" class="btn btn-primary"><span class="bx bx-plus"></span> Add More</button>
                            </div> 
                           

                          
                        </div>

                    </div>
                    <div class="row  mt-2">
                       
                        <div class="col-md-12 text-end">
                            <button type="submit" id="submit-recipe-update" class="btn btn-success w-md">Save</button>
                            <a href="{{ route('recipe.index') }}"class="btn btn-secondary w-md ">Cancel</a>
        
                        </div>

                    </div>
                    
                    

                </form>       
             
            </div>
         </div>
    </div>

    

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   


<script>  
   
    //  Detect Enter key in input fields

    $(document).on('change', '.item-dropdown-list', function(e){
        
        let selected_item = $(this).find('option:selected');
        
        let unit_id = selected_item.data('unit-id');
        
        let row =  $(this).closest('tr');
        
        let unit_dropdown = row.find('.unit-dropdown-list');

        unit_dropdown.val(unit_id).trigger('change');

        $(this).select2('close');
        
        calculation(row);  


    });


    $('#recipe-update').on('keydown', function(e) {
        if (e.key === 'Enter') {
        e.preventDefault(); // Prevent the default behavior (form submission)
        }
    });
    $(document).on('blur','.item-quantity', function(e){
        e.preventDefault(); // Prevent the default behavior (form submission)
        let qty = parseFloat($(this).val());
        $(this).val(qty.toFixed(4));   
    });

    $('#btn-add-more').on('click', function(e){
        e.preventDefault();

        appendNewRow();
       
    });
    
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
                <select  name="item_id[]" class="form-control select2 item-dropdown-list" style="width:100%; border:1px solid red">                                                
                    <option >Choose...</option>
                    @foreach ($items as $item)
                        <option value="{{$item->id}}" data-unit-id="{{ $item->unit_id }}">{{ $item->code.'-'. $item->name }}</option>
                    @endforeach
                    
                </select>
                
            </td> 
            <td> 
                <select name="unit_id[]"  class="form-control select2 unit-dropdown-list" style="width:100%">                                                
                    <option>Choose...</option>
                    @foreach ($units as $unit)
                        <option value="{{$unit->id}}" data-base-unit-value="{{ $unit->base_unit_value }}" >{{ $unit->base_unit }}</option>
                    @endforeach
                </select>
                
            </td> 
            <td>
                <input type="number" name="quantity[]" step="0.0001" class="form-control item-quantity">  
            </td>
            <td class="text-center">  
                <a href="#"><span style="font-size:18px" class="bx bx-trash text-danger remove-item"></span></a>
            </td>
        </tr>
        `;
      
        tableBody.append(row);
        $('.select2', 'table').select2();

    }



</script>


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




<script>
    $('#recipe-update').on('submit', function(e) {
        e.preventDefault();
        var submit_btn = $('#submit-recipe-update');
        let recipe_id = $('#recipe_id').val(); // Get the ID of the recipe being edited

        let editFormData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "{{ route('recipe.update', ':id') }}".replace(':id', recipe_id), // Using route name
            dataType: 'json',
            contentType: false,
            processData: false,
            cache: false,
            data: editFormData,
            enctype: "multipart/form-data",
            beforeSend: function() {
                submit_btn.prop('disabled', true);
                submit_btn.html('Processing');
            },
            success: function(response) {
                
                submit_btn.prop('disabled', false).html('Update');  

                if(response.success == true){
                    $('#recipe-update')[0].reset();  // Reset all form data
                
                    notyf.success({
                        message: response.message, 
                        duration: 3000
                    });

                        // Redirect after success notification
                setTimeout(function() {
                    window.location.href = '{{ route("recipe.index") }}';
                }, 200); // Redirect after 3 seconds (same as notification duration)
                }else{
                    notyf.error({
                        message: response.message,
                        duration: 5000
                    });
                }   
            },
            error: function(e) {
                submit_btn.prop('disabled', false).html('Update');
            
                notyf.error({
                    message: e.responseJSON.message,
                    duration: 5000
                });
            }
        });
    });
            
</script>
    


@endsection
