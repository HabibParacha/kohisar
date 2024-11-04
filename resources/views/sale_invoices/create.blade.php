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
                <form id="sale-invoice-store" action="{{ route('sale-invoice.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Sale Invoice</h4>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Customers</label>
                                        <select name="party_id"  id="party_id" class="select2 form-control">                                                
                                            <option value="">Choose...</option>
                                            @foreach ($partyCustomers as $customer)
                                                <option value="{{$customer->id}}">
                                                    {{ $customer->id .'-'.$customer->business_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>                                        
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Warehouse</label>
                                        <select name="party_warehouse_id"  id="party_warehouse_id" class="select2 form-control">                                                
                                            
                                        </select>
                                    </div>                                        
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Saleman</label>
                                        <select name="saleman_id"  id="saleman_id" class="select2 form-control" >                                                
                                            <option value="">Choose...</option>
                                            @foreach ($userSalemen as $saleman)
                                                <option value="{{$saleman->id}}">
                                                    {{ $saleman->id .'-'.$saleman->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>                                        
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Invoice No</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bx-receipt"></span> </div>
                                            <input type="text" name="invoice_no" id="invoice_no" class="form-control" value="{{ $newInvoiceNo }}" readonly>
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
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Vehicle No</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bxs-truck" ></span> </div>
                                            <input type="text" name="vehicle_no"  class="form-control">
                                        </div> 
                                    </div> 
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Reference No</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bxs-spreadsheet" ></span> </div>
                                            <input type="text" name="reference_no"class="form-control">
                                        </div> 
                                    </div> 
                                </div>
                               
                                
                              
                                
                            </div>
                        </div> 
                    </div>
                 

                    <div class="card">
                      
                        <div class="card-body">
                            <h4 class="card-title mb-4">Invoice Details</h4>
                            <div class="table-responsive">
                                <table id="table" class="table table-border" style="border-collapse:collapse;">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="50"></th>
                                            <th class="text-center" width="150">Item</th> 
                                            <th class="text-center" width="150">Unit</th> 
                                            <th class="text-center" width="150">Unit Weight</th> 
                                            <th class="text-center" width="150">Qty</th> 
                                            <th class="text-center" width="150">Total Weight</th> 
                                            <th class="text-center" width="150">Unit Price</th> 
                                            <th class="text-center" width="150">Total Price</th> 
                                            
                                
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
                                    {{-- <label for="form-label">Descripion</label> --}}
                                    <textarea name="description" id="description" class="form-control text-start d-none"  rows="4"></textarea> 
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
                                            <th>Freight </th>
                                            <td>
                                                <input type="number" name="shipping" class="form-control text-end"  autocomplete="off">
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
                            <button type="submit" id="submit-sale-invoice-store" class="btn btn-success w-md">Save</button>
                            <a href="{{ route('sale-invoice.index') }}"class="btn btn-secondary w-md ">Cancel</a>
        
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
    $(document).ready(function () {
      
        appendNewRow();

    });

       //  Detect Enter key in input fields
    $('#sale-invoice-store').on('keydown', function(e) {
        if (e.key === 'Enter') {
        e.preventDefault(); // Prevent the default behavior (form submission)
        }
    });

    // warehouse dropdown called on change of party
    $(document).ready(function () {
        $('#party_id').on('select2:select', function(e){
            e.preventDefault();

            let party_id = $(this).find('option:selected').val();

            var warehouseDropdown = $('#party_warehouse_id');
            
            $.ajax({
                url: `{{ route('party-warehouse.fetchList','') }}/${party_id}`,
                type: 'GET',
                beforeSend: function() {
                    warehouseDropdown.append('<option value="">Loading...</option>');
                },
                success: function(data) {
                    warehouseDropdown.empty(); // Clear current options
                    console.log(data);

                    warehouseDropdown.append('<option selected value="">Choose...</option>');
                    
                    // Check if data is empty
                    if (data.length === 0) {
                        warehouseDropdown.append('<option disabled>No records found</option>');
                    } else {
                        // Append the new items
                        $.each(data, function(index, warehouse) {
                            warehouseDropdown.append(new Option(warehouse.name, warehouse.id));
                        });
                    }

                    // Close the dropdown
                    warehouseDropdown.select2('close');
                    // Notify select2 about the change
                    warehouseDropdown.trigger('change');
                    warehouseDropdown.select2('open');
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", status, error);
                    alert('Failed to load items. Please try again.'); // Optional user feedback
                }
            });
            
        });
    });
    

    //item Dropdown Change
    $(document).on('change', '.item-dropdown', function(e){
        
        let selected_item = $(this).find('option:selected');
        
        let unit_id = selected_item.data('unit-id');
        let unit_weight = parseFloat(selected_item.data('unit-weight')) || 0;

        let row =  $(this).closest('tr');
        
        let unit_dropdown = row.find('.item-unit-dropdown');
        row.find('.item-unit-weight').val(unit_weight.toFixed(2));

        unit_dropdown.val(unit_id).trigger('change');
        $(this).select2('close');
        
        calculation(row);  
    });

    //input: quantity, unit price
    $(document).on('keyup','.item-total-quantity, .item-per-unit-price',function(){
        let row = $(this).closest('tr');

        calculation(row);  
    });

    
    function calculation(row) {

        let quantity = parseFloat(row.find('.item-total-quantity').val()) || 0;
        let per_unit_price = parseFloat(row.find('.item-per-unit-price').val()) || 0;
        let unit_weight = parseFloat(row.find('.item-unit-weight').val()) || 0;



        //Amount: start    
            let total_price = quantity * per_unit_price;
            row.find('.item-total-price').val(total_price.toFixed(2));


            let net_weight = quantity*unit_weight;
            row.find('.item-net-weight').val(net_weight.toFixed(2));

        //Amount: end    

        summaryCalculation();

    }

    function summaryCalculation()
    {
        let sub_total = 0;
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
            <td><a style="cursor:grab"><i style="font-size:25px" class="mdi mdi-drag handle text-dark"></i></a> </td>

            <td> 
                <select  name="item_id[]" class="form-control select2 item-dropdown" style="width:100%">                                                
                    <option value="" >Choose...</option>
                    @foreach ($itemGoods as $item)
                        <option value="{{$item->id}}" data-unit-id="{{ $item->unit_id }}"  data-unit-weight="{{ $item->unit_weight }}">{{ $item->code.'-'.$item->category->name .'-'.$item->name }}</option>
                    @endforeach

                </select>

            </td> 
            <td> 
                <select name="unit_id[]"  class="form-control select2 item-unit-dropdown" style="width:100%">                                                
                    <option>Choose...</option>
                    @foreach ($units as $unit)
                        <option value="{{$unit->id}}" data-base-unit-value="{{ $unit->base_unit_value }}" >{{ $unit->base_unit }}</option>
                    @endforeach
                </select>

            </td> 
            <td>
                <input type="number" name="unit_weight[]" step="0.0001" class="form-control item-unit-weight" readonly>  
            </td>
            <td>
                <input type="number" name="total_quantity[]" step="0.0001" class="form-control item-total-quantity" >  
            </td>
            <td>
                <input type="number" name="net_weight[]" step="0.0001" class="form-control item-net-weight" readonly>  
            </td>
            <td>
                <input type="number" name="per_unit_price[]" step="0.0001" class="form-control item-per-unit-price">  
            </td>
            <td>
                <input type="number" name="total_price[]" step="0.0001" class="form-control item-total-price" readonly>  
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
    $('#sale-invoice-store').on('submit', function(e) {
        e.preventDefault();
        var submit_btn = $('#submit-sale-invoice-store');
        let createformData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "{{ route('sale-invoice.store') }}",
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
                    $('#sale-invoice-store')[0].reset();  // Reset all form data
                
                    notyf.success({
                        message: response.message, 
                        duration: 3000
                    });

                    // Redirect after success notification
                    setTimeout(function() {
                        window.location.href = '{{ route("sale-invoice.index") }}';
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