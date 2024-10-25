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
                <form id="purchase-order-store" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            {{-- <h4 class="card-title mb-4">Purchase Order</h4> --}}
                            <h4 class="card-title mb-4">Bill Receipt</h4>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Supplier</label>
                                        <select name="party_id"  id="party_id" class="select2 form-select" tabindex="1" autofocus >                                                
                                            <option selected="">Choose...</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{$supplier->id}}">
                                                    {{ $supplier->business_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>                                        
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Receipt No</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bx-receipt"></span> </div>
                                            <input type="text" name="invoice_no" id="invoice_no" class="form-control" value="{{ $newInvoiceNo }}" readonly>
                                        </div> 
                                    </div> 
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Vehicle No</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bxs-truck" ></span> </div>
                                            <input type="text" name="vehicle_no" id="vehicle_no" class="form-control" tabindex="2">
                                        </div> 
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
                                <div class="col-md-4 d-none">
                                    <div class="mb-3">
                                        <label class="form-label">Payment Terms</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bx-money" ></span> </div>
                                            <select name="payment_terms" id="payment_terms"  class="form-control">
                                                <option selected value="">Choose...</option>
                                                @foreach ($paymentTerms as $term )
                                                    <option value="{{ $term['value'] }}">{{ $term['name'] }}</option>
                                                    
                                                @endforeach

                                            </select>
                                        </div>
                                       
                                    </div> 
                                </div>
                                <div class="col-md-4 d-none">
                                    <div class="mb-3">
                                        <label class="form-label">Due Date</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bx-calendar" ></span> </div>
                                            <input type="date" name="due_date" id="due_date" class="form-control">
                                        </div> 
                                    </div> 
                                </div>
                                
                              
                                
                            </div>
                        </div> 
                    </div>
                 

                    <div class="card">
                      
                        <div class="card-body">
                            <h4 class="card-title mb-4">Order Details</h4>
                            <div class="table-responsive">
                                <table id="table" class="table table-border" style="border-collapse:collapse;">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="50"></th>
                                            <th class="text-center" width="150">Item</th> 
                                            <th class="text-center" width="100">
                                                Gross wgt <i class="bx bxs-help-circle mr-1" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Total Weight in KG's"></i> 
                                            </th>
                                            <th class="text-center" width="50">
                                                Cut <i class="bx bxs-help-circle mr-1" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Add/Remove Cut Fileds"></i>
                                            </th>
                                            <th class="text-center" width="50">Cut(%)</th>
                                            <th class="text-center" width="100">
                                                Cut Value <i class="bx bxs-help-circle mr-1" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="( cut% / 100 ) x gross wgt"></i>
                                            </th>
                                            <th class="text-center" width="100">
                                                After Cut <i class="bx bxs-help-circle mr-1" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="gross wgt - cut value"></i>
                                            </th>


                                            <th class="text-center" width="100">Total Bags </th>
                                            <th class="text-center" width="100">Per Empty <br> bag  wgt</th>
                                            <th class="text-center" width="100">Total Empty <br> bag wgt</th>
                                            <th class="text-center" width="100">
                                                Net wgt <i class="bx bxs-help-circle mr-1" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="gross wgt - (after cut + Total Empty bag wgt )">
                                            </th>



                                            <th class="text-center" width="100">Per Kg Price</th>
                                            <th class="text-center" width="100">
                                                Total Price <i class="bx bxs-help-circle mr-1" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="per kg price x after cut">
                                            </th>
                                
                                            <th class="text-center" width="50"></th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody id="sortable-table">
                                       
                                        
                                    </tbody> 
                                </table>

                                <button id="btn-add-more" class="btn btn-primary"><span class="bx bx-plus"></span> Add More</button>
                            </div> 
                           

                            <div class="row mt-3">
                                <div class="col-md-8">
                                    <label for="form-label">Descripion</label>
                                    <textarea name="description" id="description" class="form-control text-start"  rows="4"></textarea> 
                                </div>
                                
                                <div class="col-md-4 d-flex align-items-center">
                                    <table id="summary-table" class="table">
                                        <tr>
                                            <th width="50%">Sub Total</th>
                                            <td width="50%">
                                                <input type="number" name="sub_total" id="sub-total" value="0" class="form-control text-end" readonly>
                                            </td>
                                        </tr>  
                                        <tr>
                                            <th>Shipping</th>
                                            <td>
                                                <input type="number" name="shipping" value="0" class="form-control text-end" >
                                            </td>
                                        </tr>

                                        <tr class="">
                                            <th width="50%">Grand Total</th>
                                            <td width="50%">
                                                <input type="number" name="grand_total" id="grand-total" value="0" class="form-control text-end" readonly>
                                            </td>
                                        </tr>  
                            
                                       
                                    </table>
                                </div>
                            </div>    

                        </div>

                    </div>
                    <div class="row  mt-2">
                        <div class="col-md-4">
                             <div class="row d-none">
                                <label class="col-md-3 col-form-label">Attachment</label>
                                <div class="col-md-9">
                                    <input type="file" name="attachment" class="form-control">
                                </div>
                            </div>  
                        </div>
                        <div class="col-md-8 text-end">
                            <button type="submit" id="submit-purchase-order-store" class="btn btn-success w-md">Save</button>
                            <a href="{{ route('purchase-order.index') }}"class="btn btn-secondary w-md ">Cancel</a>
        
                        </div>

                    </div>
                    
                    

                </form>       
             
            </div>
         </div>
    </div>

    

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('/assets/js/tinymce1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script>
        // Create an instance of Notyf
        let notyf = new Notyf({
            duration: 3000,
            position: {
                x: 'right',
                y: 'top',
            },
        });
    </script>



<script>
    //  Detect Enter key in input fields
    $('#purchase-order-store').on('keydown', function(e) {
        if (e.key === 'Enter') {
        e.preventDefault(); // Prevent the default behavior (form submission)
        }
    });
    $(document).on('keydown', '#party_id', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault(); // Prevent form submission
            // Move to the first select in the first table row
            $('#vehicle_no').focus(); // Focus on the Select2 container
            
        }
    });
    $(document).on('keydown', '#vehicle_no', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault(); // Prevent form submission
            // Move to the first select in the first table row
            $('#sortable-table tr:first .item-dropdown-list').focus().select2('open'); // Focus on the Select2 container
            
        }
    });
   
    $(document).on('keydown', '.select2-container', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            
            let $select = $(this).prev('select'); // Get the original select element
            let $row = $(this).closest('tr'); // Use $ to denote jQuery object

            // Check if an option is selected
            if ($select.val() !== null) {
                $row.find('.item-gross-weight').focus(); // Move to the next input
            }
        }
    });

    // Handling the actual select event
    $(document).on('select2:select', '.item-dropdown-list', function(e) {
        let $row = $(this).closest('tr'); 
        $row.find('.item-gross-weight').focus(); // Move to the next input
    });

    $(document).on('keydown', '.item-gross-weight, .item-total-quantity, .item-per-package-weight, .item-per-unit-price', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            let $row = $(this).closest('tr'); // Use $ to denote jQuery object

            // Check the class to determine the next field to focus on
            if ($(this).hasClass('item-dropdown-list')) {
                $row.find('.item-gross-weight').focus(); 
            } 
            else if ($(this).hasClass('item-gross-weight')) {
                $row.find('.item-total-quantity').focus();
            } 
            else if ($(this).hasClass('item-total-quantity')) {
                $row.find('.item-per-package-weight').focus();
            } 
            else if ($(this).hasClass('item-per-package-weight')) {
                $row.find('.item-per-unit-price').focus();
            }
            else if ($(this).hasClass('item-per-unit-price')) {
                appendNewRow(); // This should only happen when the last input is focused

            }
        }
    });
</script>

<script>  
    $(document).ready(function () {
      
        appendNewRow();

    });


    $(document).on('change', '.unit-dropdown-list, .item-discount-type, .item-tax-dropdown', function(e){
    
        let row =  $(this).closest('tr');
    
        calculation(row);  

    });

    $(document).on('keyup','.item-gross-weight, .item-per-unit-price, .item-discount-value, .item-cut-percentage, .item-per-package-weight',function(){
        
        let row = $(this).closest('tr');

        calculation(row);  
    });

    $(document).on('change', '.cut-checkbox', function(e){
        
        let row =  $(this).closest('tr');
    
        if($(this).prop('checked'))
        {
            
           row.find('.item-cut-percentage').removeClass('d-none');
           row.find('.item-cut-value').removeClass('d-none');
           row.find('.item-after-cut-total-weight').removeClass('d-none');
        }   
        else{
            row.find('.item-cut-percentage').addClass('d-none').val('0');//reest value to 0
            row.find('.item-cut-value').addClass('d-none').val('0');//reest value to 0
            row.find('.item-after-cut-total-weight').addClass('d-none');
            calculation(row);

        }     
   
    });
   
    function calculation(row) {

        let gross_weight = parseFloat(row.find('.item-gross-weight').val()) || 0;
        let price = parseFloat(row.find('.item-price').val()) || 0;

        //Cut Calcaution:start
            let cut_percentage = parseFloat(row.find('.item-cut-percentage').val()) || 0;
            let after_cut_total_weight =  gross_weight; 
            if(cut_percentage > 0){
                cut_value = (cut_percentage/100) * gross_weight;
                row.find('.item-cut-value').val(cut_value.toFixed(2));

                after_cut_total_weight = gross_weight - cut_value;

            }
            row.find('.item-after-cut-total-weight').val(after_cut_total_weight.toFixed(2));
        //Cut Calcaution:end


        //Package Weight Calcaution: start
            let total_quantity = parseFloat(row.find('.item-total-quantity').val()) || 0;
            let per_package_weight = parseFloat(row.find('.item-per-package-weight').val()) || 0;

            let total_package_weight = per_package_weight * total_quantity;
            row.find('.item-total-package-weight').val(total_package_weight.toFixed(2));

            let net_weight = after_cut_total_weight - total_package_weight
            row.find('.item-net-weight').val(net_weight.toFixed(2));
        //Package Weight Calcaution: end

        //Total Price Calcaution: start    
            let per_unit_price =  parseFloat(row.find('.item-per-unit-price').val()) || 0;
            let total_price = per_unit_price * after_cut_total_weight;
            row.find('.item-total-price').val(total_price.toFixed(2));
        //Total Price Calcaution: end    

        summaryCalculation();

    }

    function summaryCalculation()
    {
        let sub_total = 0;
        let tax_total = 0;
        let discount_total = 0;
        let grand_total = 0;

        $('.item-total-price').each(function(){
            let item_total_price = parseFloat($(this).val()) || 0;
            sub_total+= item_total_price;
        });
        $('#sub-total').val(sub_total.toFixed(2));


        grand_total = sub_total;
        $('#grand-total').val(grand_total.toFixed(2));


        
 
    }

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
                <td><a href=""><i style="font-size:25px" class="bx bx-menu handle text-dark"></i></a> </td>
                <td> 
                    <select  name="item_id[]" class="form-control select2 item-dropdown-list" style="width:100%">                                                
                        <option >Choose...</option>
                        @foreach ($items as $item)
                            <option value="{{$item->id}}"  data-unit-id="{{ $item->unit_id }}"  >{{ $item->name }}</option>
                        @endforeach
                        
                    </select>
                    
                </td>  
            
                <td class="text-end"> 
                    <input  type="number" name="gross_weight[]" step="0.01" class="form-control item-gross-weight">  
                </td>

                <td class="text-center"> 
                    <input class="form-check-input cut-checkbox" type="checkbox">
                </td>
                <td> 
                    <input type="number" name="cut_percentage[]" value="0" step="0.01" class="form-control item-cut-percentage d-none">  
                </td>
                <td> 
                    <input type="number" name="cut_value[]" value="0" step="0.01" class="form-control item-cut-value d-none text-end" readonly>  
                </td>
                <td> 
                    <input type="number" name="after_cut_total_weight[]" step="0.01" class="form-control item-after-cut-total-weight d-none text-end" readonly>  
                </td>



                <td> 
                    <input type="number" name="total_quantity[]" value="0" step="0.01" class="form-control item-total-quantity">  
                </td>
                <td> 
                    <input type="number" name="per_package_weight[]" value="0" step="0.01" class="form-control item-per-package-weight">  
                </td>
                <td> 
                    <input type="number" name="total_package_weight[]" value="0" step="0.01" class="form-control item-total-package-weight text-end" readonly>  
                </td>
                <td> 
                    <input type="number" name="net_weight[]" value="0" step="0.01" class="form-control item-net-weight text-end" readonly>  
                </td>
                


                <td> 
                    <input type="number" name="per_unit_price[]" step="0.01" class="form-control item-per-unit-price">  
                </td>
                

                <td > 
                    <input type="number" name="total_price[]" step="0.01" class="form-control item-total-price text-end" readonly>  
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
    $('#purchase-order-store').on('submit', function(e) {
        e.preventDefault();
        var submit_btn = $('#submit-purchase-order-store');
        let createformData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "{{ route('purchase-order.store') }}",
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
                    $('#purchase-order-store')[0].reset();  // Reset all form data
                
                    notyf.success({
                        message: response.message, 
                        duration: 3000
                    });

                    // Redirect after success notification
                    setTimeout(function() {
                        window.location.href = '{{ route("purchase-order.index") }}';
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
    });
            
</script>
    


@endsection
