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
                <form id="purchase-order-update" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="invoice_master_id" value="{{ $invoice_master->id }}">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Bill Receipt</h4>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Supplier</label>
                                        <select name="party_id"  class="select2 form-select">                                                
                                            <option value="">Choose...</option>
                                            @foreach ($suppliers as $supplier)
                                                <option 
                                                
                                                    @if($supplier->id ==  $invoice_master->party_id ) selected @endif 
                                                    
                                                    value="{{$supplier->id}}"> {{ $supplier->id .'-'.$supplier->business_name }}
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
                                            <input type="text" name="invoice_no" class="form-control" value="{{ $invoice_master->invoice_no }}" readonly>
                                        </div> 
                                    </div> 
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Vehicle No</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bxs-truck" ></span> </div>
                                            <input type="text" name="vehicle_no" value="{{ $invoice_master->vehicle_no }}" class="form-control" autocomplete="off">
                                        </div> 
                                    </div> 
                                </div>
                               

                             
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Date</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bx-calendar" ></span> </div>
                                            <input type="date" name="date" id="date" class="form-control" value="{{ $invoice_master->date }}">
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
                                      @foreach ($invoice_detail as $detail)
                                      <tr>
                                        <td><a style="cursor:grab"><i style="font-size:25px" class="mdi mdi-drag handle text-dark"></i></a> </td>
                                        <td> 
                                            <select name="item_id[]" class="form-control select2 item-dropdown-list" style="width:150px">                                                
                                                <option value="">Choose...</option>
                                                @foreach ($items as $item)
                                                    <option 
                                                    @if($detail->item_id == $item->id ) selected @endif
                                                    value="{{ $item->id }}"  data-unit-id="{{ $item->unit_id }}">{{ $item->code.'-'. $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>  
                                        <td> 
                                            <input type="number" name="gross_weight[]" value="{{ $detail->gross_weight }}" step="0.01" class="form-control item-gross-weight"  autocomplete="off">  
                                        </td>
                                    
                                        @if($detail->cut_percentage > 0)
                                            <td class="text-center"> 
                                                <input class="form-check-input cut-checkbox" type="checkbox" checked>
                                            </td>
                                            <td> 
                                                <input type="number" name="cut_percentage[]" value="{{ $detail->cut_percentage }}" step="0.01" class="form-control item-cut-percentage"  autocomplete="off">  
                                            </td>
                                            <td> 
                                                <input type="number" name="cut_value[]" value="{{ $detail->cut_value }}" step="0.01" class="form-control item-cut-value text-end" readonly>  
                                            </td>
                                            <td> 
                                                <input type="number" name="after_cut_total_weight[]" value="{{ $detail->after_cut_total_weight }}" step="0.01" class="form-control item-after-cut-total-weight text-end" readonly>  
                                            </td>
                                        @else
                                            <td class="text-center"> 
                                                <input class="form-check-input cut-checkbox" type="checkbox">
                                            </td>
                                            <td> 
                                                <input type="number" name="cut_percentage[]" value="0" step="0.01" class="form-control item-cut-percentage d-none"  autocomplete="off">  
                                            </td>
                                            <td> 
                                                <input type="number" name="cut_value[]" value="0" step="0.01" class="form-control item-cut-value d-none text-end" readonly>  
                                            </td>
                                            <td> 
                                                <input type="number" name="after_cut_total_weight[]" value="{{ $detail->after_cut_total_weight }}" step="0.01" class="form-control item-after-cut-total-weight d-none text-end" readonly>  
                                            </td>
                                        @endif
                                    
                                        <td> 
                                            <input type="number" name="total_quantity[]" value="{{ $detail->total_quantity }}" step="0.01" class="form-control item-total-quantity"  autocomplete="off">  
                                        </td>
                                        <td> 
                                            <input type="number" name="per_package_weight[]" value="{{ $detail->per_package_weight }}" step="0.01" class="form-control item-per-package-weight"  autocomplete="off">  
                                        </td>
                                        <td> 
                                            <input type="number" name="total_package_weight[]" value="{{ $detail->total_package_weight }}" step="0.01" class="form-control item-total-package-weight text-end" readonly>  
                                        </td>
                                        <td> 
                                            <input type="number" name="net_weight[]" value="{{ $detail->net_weight }}" step="0.01" class="form-control item-net-weight text-end" readonly>  
                                        </td>
                                        <td> 
                                            <input type="number" name="per_unit_price[]" value="{{ $detail->per_unit_price }}" step="0.01" class="form-control item-per-unit-price"  autocomplete="off">  
                                            <input type="hidden" name="per_unit_price_old_value[]" value="{{ $detail->per_unit_price }}" step="0.01" class="form-control">  
                                        
                                        </td>
                                        <td> 
                                            <input type="number" name="total_price[]" value="{{ $detail->total_price }}" step="0.01" class="form-control item-total-price text-end" readonly>  
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
                           

                            <div class="row mt-3">
                                <div class="col-md-8">

                                    <label for="form-label">Descripion</label>
                                    <textarea name="description" id="description" rows="4" class="form-control">{{ $invoice_master->description }}</textarea> 
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <table id="summary-table" class="table">
                                        <tr>
                                            <th width="50%">Sub Total</th>
                                            <td width="50%">
                                                <input type="number" name="sub_total" id="sub-total" value="{{ $invoice_master->sub_total }}" class="form-control text-end" readonly>
                                            </td>
                                        </tr>  
                                        <tr>
                                            <th>Freight </th>
                                            <td>
                                                <input type="number" name="shipping" value="{{ $invoice_master->shipping }}" class="form-control text-end" >
                                            </td>
                                        </tr>

                                        <tr class="">
                                            <th width="50%">Grand Total</th>
                                            <td width="50%">
                                                <input type="number" name="grand_total" id="grand-total" value="{{ $invoice_master->grand_total }}" class="form-control text-end" readonly>
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
                                    <input type="hidden" name="attachment_old_value" value="{{ $invoice_master->attachment }}" class="form-control">
                                </div>
                            </div>  
                        </div>
                        <div class="col-md-8 text-end">
                            <button type="submit"id="submit-purchase-order-update" class="btn btn-success w-md">Save</button>
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
    //  // Detect Enter key in input fields
     $('#purchase-order-update').on('keydown', function(e) {
        if (e.key === 'Enter') {
        e.preventDefault(); // Prevent the default behavior (form submission)
        }
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
                <td><a style="cursor:grab"><i style="font-size:25px" class="mdi mdi-drag handle text-warning"></i></a> </td>
                <td> 
                    <select name="item_id[]" class="form-control select2 item-dropdown-list" style="width:150px">                                                
                        <option value="">Choose...</option>
                        @foreach ($items as $item)
                            <option value="{{$item->id}}"  data-unit-id="{{ $item->unit_id }}" >{{ $item->code.'-'. $item->name }}</option>
                        @endforeach
                        
                    </select>
                    
                </td>  
            
                <td class="text-end"> 
                    <input type="number" name="gross_weight[]" step="0.01" class="form-control item-gross-weight"  autocomplete="off">  
                </td>

                <td class="text-center"> 
                    <input class="form-check-input cut-checkbox" type="checkbox">
                </td>
                <td> 
                    <input type="number" name="cut_percentage[]" step="0.01" class="form-control item-cut-percentage d-none"  autocomplete="off">  
                </td>
                <td> 
                    <input type="number" name="cut_value[]" value="0" step="0.01" class="form-control item-cut-value d-none text-end" readonly>  
                </td>
                <td> 
                    <input type="number" name="after_cut_total_weight[]" step="0.01" class="form-control item-after-cut-total-weight d-none text-end" readonly>  
                </td>



                <td> 
                    <input type="number" name="total_quantity[]" step="0.01" class="form-control item-total-quantity"  autocomplete="off">  
                </td>
                <td> 
                    <input type="number" name="per_package_weight[]"  step="0.01" class="form-control item-per-package-weight"  autocomplete="off">  
                </td>
                <td> 
                    <input type="number" name="total_package_weight[]" value="0" step="0.01" class="form-control item-total-package-weight text-end" readonly>  
                </td>
                <td> 
                    <input type="number" name="net_weight[]" value="0" step="0.01" class="form-control item-net-weight text-end" readonly>  
                </td>
                


                <td> 
                    <input type="number" name="per_unit_price[]" step="0.01" class="form-control item-per-unit-price"  autocomplete="off">  
                    <input type="hidden" name="per_unit_price_old_value[]" value="" step="0.01" class="form-control">  

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
    $('#purchase-order-update').on('submit', function(e) {
                e.preventDefault();
                var submit_btn = $('#submit-purchase-order-update');
                let invoice_master_id = $('#invoice_master_id').val(); // Get the ID of the purchase-order being edited

                let editFormData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('purchase-order.update', ':id') }}".replace(':id', invoice_master_id), // Using route name
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
                            $('#purchase-order-update')[0].reset();  // Reset all form data
                        
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

