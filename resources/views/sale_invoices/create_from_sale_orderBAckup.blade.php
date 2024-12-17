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

                    <input type="hidden" name="party_id" value="{{ $saleOrder->party_id }}">
                    <input type="hidden" name="saleman_id" value="{{ $saleOrder->saleman_id }}">

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    {{-- <h4 class="card-title mb-4">Purchase Order</h4> --}}
                                    <h4 class="card-title mb-4">Sale Invoice</h4>
        
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Invoice No</label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><span class="bx bx-receipt"></span> </div>
                                                    <input type="text" name="invoice_no" class="form-control" value="{{ $newInvoiceNo }}" readonly>

                                                </div> 
                                            </div> 
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><span class="bx bx-calendar" ></span> </div>
                                                    <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}">
                                                </div>
                                               
                                            </div> 
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Customers</label>
                                                <input type="text" class="form-control" value="{{ $saleOrder->party->business_name }}" readonly>
        
                                            </div>                                        
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Farm / Warehouse</label>
                                                <div class="input-group">
                                                    <select name="party_warehouse_id" id="" class="form-control select2" style="width:100%">
                                                        <option value="">Choose...</option>
                                                        @foreach ($partyWarehouses as $warehouse)
                                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                                            
                                                        @endforeach
                                                    </select>
                                                </div> 
                                            </div> 
                                        </div>

                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Vehicle No</label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><span class="bx bxs-truck" ></span> </div>
                                                    <input type="text" name="vehicle_no"  class="form-control">
                                                </div> 
                                            </div> 
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Reference No</label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><span class="bx bxs-spreadsheet" ></span> </div>
                                                    <input type="text" name="reference_no" value="{{ $saleOrder->invoice_no }}" class="form-control" readonly>
                                                </div> 
                                            </div> 
                                        </div>
                                        
                                        
                                     
                                      
                                       
                                        
                                      
                                        
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    {{-- <h4 class="card-title mb-4">Purchase Order</h4> --}}
                                    <h4 class="card-title mb-4">Sale Order</h4>
        
                                    <div class="row">
                                       
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Saleman</label>
                                                <input type="text" class="form-control" value="{{ $saleOrder->saleman->name }}" readonly>

        
                                            </div>                                        
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Sale Order No</label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><span class="bx bx-receipt"></span> </div>
                                                    <input type="text" class="form-control" value="{{ $saleOrder->invoice_no }}" readonly>
                                                </div> 
                                            </div> 
                                        </div>
                                     
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><span class="bx bx-calendar" ></span> </div>
                                                    <input type="date" class="form-control" value="{{  $saleOrder->date }}" readonly>
                                                </div>
                                               
                                            </div> 
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
                                            <th  width="10" class="text-start" ></th>
                                            <th  width="200" class="text-start" >Item</th> 
                                            <th  width="50" class="d-none">Unit</th> 
                                            <th  width="50" class="text-center">Unit wgt.</th> 
                                            <th  width="50" class="text-center">Qty</th> 
                                            <th  width="100" class="text-center">Total  wgt.</th> 
                                            <th  width="50" class="text-center">Unit Price</th> 
                                            <th  width="100" class="text-center">Total Price  </th> 

                                            <th  width="50" class="text-center">Discount Price </th>
                                            <th  width="100" class="text-center">Discount Amount</th>
                                            <th  width="100" class="text-center">Total After Discount</th>
                                
                                            <th class="text-center" width="20"></th>
                                            
                                
                                        
                                        </tr>
                                    </thead>
                                    <tbody id="sortable-table">
                                        @foreach ($saleOrder->invoiceDetails  as $detail)    
                                        <tr>

                                            <input type="hidden" name="item_id[]" value="{{ $detail->item_id }}">


                                            <td><a style="cursor:grab"><i style="font-size:25px" class="mdi mdi-drag handle text-dark"></i></a> </td>
                                
                                            <td>{{ $detail->item->name }}</td> 
                                            <td class="d-none" > {{ $detail->item->unit->base_unit }}</td> 
                                            <td>
                                                <input type="number" name="unit_weight[]"  value="{{ $detail->unit_weight }}" step="0.0001" class="form-control item-unit-weight" readonly>  
                                            </td>
                                            <td class="text-end">
                                                <input type="number" name="total_quantity[]" step="0.0001" class=" text-end form-control item-total-quantity" >  
                                            </td>
                                            <td class="text-end">
                                                <input type="number" name="net_weight[]" step="0.0001" class=" text-end form-control item-net-weight" readonly>  
                                            </td>
                                            <td class="text-end">
                                                <input type="number" name="per_unit_price[]" step="0.0001" class=" text-end form-control item-per-unit-price">  
                                            </td>
                                            <td class="text-end">
                                                <input type="number" name="total_price[]" step="0.0001" class=" text-end form-control item-total-price" readonly>  
                                            </td>

                                            <td class="text-end">
                                                <input type="number" name="discount_unit_price[]" value="0" step="0.01" class=" text-end form-control item-discount-unit-price" >
                                            </td>
                                           
                                            
                                            <td class="text-end">
                                                <input type="number" name="discount_amount[]" value="0" step="0.01" class=" text-end form-control item-discount-amount" readonly>
                                            </td>
                                            <td class="text-end"> 
                                                <input type="number" name="after_discount_total_price[]" class=" text-end form-control item-after-discount" readonly>  
                                            </td>
                                            
                                            
                                            
                                            <td class="text-center">  
                                                <a href="#"><span style="font-size:18px" class="bx bx-trash text-danger remove-item"></span></a>
                                            </td>
                                        </tr>
                                    @endforeach 
                                    </tbody> 
                                </table>

                            </div> 
                           

                            <div class="row mt-3">
                                <div class="col-md-8">
                                    {{-- <label for="form-label">Descripion</label> --}}
                                    <textarea name="description" id="description" class="form-control text-start d-none"  rows="4"></textarea> 
                                </div>
                                
                                <div class="col-md-4 d-flex align-items-center">
                                    <table id="summary-table" class="table">
                                        <tr class="">
                                            <th width="50%">Sub Total</th>
                                            <td width="50%">
                                                <input type="number" name="sub_total" id="sub-total" value="0" class="form-control text-end" readonly>
                                            </td>
                                        </tr>  
                                        <tr class="">
                                            <th>Freight </th>
                                            <td>
                                                <input type="number" name="shipping" class="form-control text-end"  autocomplete="off">
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Discount</th>
                                            <td>
                                                <input type="number" name="discount_total" id="discount-total" value="0" class="form-control text-end" readonly>
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
      
        // appendNewRow();

    });

       //  Detect Enter key in input fields
    $('#sale-invoice-store').on('keydown', function(e) {
        if (e.key === 'Enter') {
        e.preventDefault(); // Prevent the default behavior (form submission)
        }
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

  
   $(document).on('keyup','.item-total-quantity, .item-per-unit-price, .item-discount-unit-price',function(){
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


        // Discount Calculation: start
        let discount_unit_price = parseFloat(row.find('.item-discount-unit-price').val()) || 0;

        let after_discount = 0;
        let discount_amount = 0;


        if(discount_unit_price > 0 && discount_unit_price < per_unit_price)
        {
            after_discount = quantity * discount_unit_price;
            discount_amount = total_price-after_discount;

        }else{
            after_discount = total_price;
            discount_amount = 0;
        }
        if(discount_unit_price > per_unit_price)
        {
            alert('Wrong input: discount unit price cannot be greater than the original unit price.');
        }

        row.find('.item-discount-amount').val(discount_amount.toFixed(2));
        row.find('.item-after-discount').val(after_discount.toFixed(2));

        // Discount Calculation: end

        summaryCalculation();

    }

    function summaryCalculation()
    {
        let sub_total = 0;
        let grand_total = 0;
        let discount_total = 0;
        let discount_grand_total =0;

        $('.item-total-price').each(function(){
            let item_total_price = parseFloat($(this).val()) || 0;
            sub_total+= item_total_price;
        });
        $('#sub-total').val(sub_total.toFixed(2));

        $('.item-after-discount').each(function(){
            let item_discount_value = parseFloat($(this).val()) || 0;
            grand_total+= item_discount_value;
        });
        $('#grand-total').val(grand_total.toFixed(2));


        discount_grand_total = sub_total-grand_total;
        if(discount_grand_total > 0){
            $('#discount-total').val(discount_grand_total.toFixed(2));
        }




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
