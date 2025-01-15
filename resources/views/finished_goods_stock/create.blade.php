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
                <form id="finished-goods-stock-store" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Finished Goods Stock Opening Balance</h4>

                            <div class="row">

                                  <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Date</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bx-calendar" ></span> </div>
                                            <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}">
                                        </div>
                                       
                                    </div> 
                                </div>

                                {{-- <div class="col-md-3">
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
                                        <label class="form-label">Farm / Warehouse</label>
                                        <select name="party_warehouse_id"  id="party_warehouse_id" class="select2 form-control">                                                
                                            
                                        </select>
                                    </div>                                        
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Saleman</label>
                                        <select name="saleman_id"  id="saleman_id" class="select2 form-control">                                                
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
                                </div> --}}
                               
                                
                              
                                
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
                                            <th  width="10" class="text-start" ></th>
                                            <th  width="200" class="text-start" >Item</th> 
                                            <th  width="50" class="text-center">Unit wgt.</th> 
                                            <th  width="50" class="text-center">Qty</th> 
                                            <th  width="50" class="text-center">Total  wgt.</th> 
                                            <th  width="50" class="text-center">Selling</th> 
                                            <th  width="50" class="text-center">Total Price</th> 
                                         
                                            <th class="text-center" width="20"></th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody id="sortable-table">

                                       
                        
                                       
                                    </tbody> 
                                </table>

                                <button id="btn-add-more" class="btn btn-primary"><span class="bx bx-plus"></span> Add More</button>
                            </div> 
                           

                        

                        </div>

                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            {{-- <label for="form-label">Descripion</label> --}}
                        </div>
                        
                       
                        <div class="col-md-6 d-flex align-items-top">
                            <table id="summary-table" class="table">

                                <tr class="">
                                    <th width="50%">Total Amount  </th>
                                    <td width="50%">
                                        <input type="number" name="grand_total" id="grand-total" step="0.001" value="0" class="form-control text-end" readonly>
                                    </td>
                                </tr>  
                                <tr class="">
                                    <th width="50%">Total Weight</th>
                                    <td width="50%">
                                        <input type="number" name="net_weight" id="total-wgt" value="0" step="0.001" class="form-control text-end" readonly>
                                    </td>
                                </tr>           
                            </table>
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
                            <button type="submit" id="submit-finished-goods-stock-store" class="btn btn-success w-md">Save</button>
                            <a href="{{ route('dashboard') }}"class="btn btn-secondary w-md ">Cancel</a>
        
                        </div>

                    </div>
                    
                    

                </form>       
             
            </div>
         </div>
    </div>


    {{-- @include('opeining_balances.js') --}}

<script>  
    $(document).ready(function () {
      
        appendNewRow();

    });


    $(document).on('change', '.item-dropdown', function(e){
        
        let selected_item = $(this).find('option:selected');
        
        let unit_id = selected_item.data('unit-id');
        let unit_weight = parseFloat(selected_item.data('unit-weight')) || 0;
        let sell_price = parseFloat(selected_item.data('sell-price')) || 0;


        let row =  $(this).closest('tr');
        
        let unit_dropdown = row.find('.item-unit-dropdown');
        row.find('.item-unit-weight').val(unit_weight.toFixed(2));
        row.find('.item-per-unit-price').val(sell_price.toFixed(0));//remove decimal



        unit_dropdown.val(unit_id).trigger('change');
        $(this).select2('close');
        
        calculation(row);  
    });

    $(document).on('keyup','.item-total-quantity',function(){
        let row = $(this).closest('tr');

        calculation(row);  
    });

    function calculation(row) {

        let quantity = parseFloat(row.find('.item-total-quantity').val()) || 0;
        let unit_weight = parseFloat(row.find('.item-unit-weight').val()) || 0;
        let per_unit_price = parseFloat(row.find('.item-per-unit-price').val()) || 0;

        let net_weight = quantity*unit_weight;
        row.find('.item-net-weight').val(net_weight.toFixed(2));

        let total_price = quantity * per_unit_price;
        row.find('.item-total-price').val(total_price.toFixed(2));

        summaryCalculation();
    }

    $('#btn-add-more').on('click', function(e){
        e.preventDefault();

        appendNewRow();
       
    });

    function summaryCalculation()
    {
        let grand_total = 0;
        let total_weight = 0;


        $('.item-total-price').each(function(){
            grand_total += parseFloat($(this).val()) || 0;
        });
        $('#grand-total').val(grand_total);

        $('.item-net-weight').each(function(){
            total_weight += parseFloat($(this).val()) || 0;
        });
        $('#total-wgt').val(total_weight);


    }
    
   
   

    function appendNewRow(){
        let tableBody = $('#table tbody');

        let row = `
            <tr class="">
                <td class="text-end"><a style="cursor:grab"><i style="font-size:25px" class="mdi mdi-drag handle text-dark"></i></a> </td>

                <td class=""> 
                    <select  name="item_id[]" class="form-control select2 item-dropdown" style="width:100%">                                                
                        <option value="" >Choose...</option>
                        @foreach ($itemGoods as $item)
                            <option 
                            value="{{$item->id}}" 
                            data-stock="{{ $item->balance }}"  
                            data-unit-weight="{{ $item->unit_weight }}"
                            data-sell-price="{{ $item->sell_price }}"

                            
                            >{{ $item->code.'-'.$item->category_name .'-'.$item->name }}</option>
                        @endforeach

                    </select>

                </td> 
                
                <td class="text-end">
                    <input type="number" name="unit_weight[]" step="0.0001" class=" text-end form-control item-unit-weight" readonly>  
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
                
                <td class="text-center">  
                    <a href="#"><span style="font-size:18px" class="bx bx-trash text-danger remove-item"></span></a>
                </td>
                
            </tr>

        `;
      
        tableBody.append(row);
        $('.select2', '#table').select2();

    }



</script>
<script>
    $('#finished-goods-stock-store').on('submit', function(e) {
        e.preventDefault();
        var submit_btn = $('#submit-finished-goods-stock-store');
        let createformData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "{{ route('finished-goods-stock.store') }}",
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
                    $('#finished-goods-stock-store')[0].reset();  // Reset all form data
                
                    notyf.success({
                        message: response.message, 
                        duration: 3000
                    });

                    // Redirect after success notification
                    setTimeout(function() {
                        window.location.href = '{{ route("finished-goods-stock.create") }}';
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
