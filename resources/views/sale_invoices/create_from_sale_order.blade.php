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

                                                        <option 
                                                        
                                                        

                                                        value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                                            
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
                                                <input type="text" class="form-control" value="{{ $saleOrder->saleman->name ?? '' }}" readonly>

        
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
                                            <th  width="50" class="text-center">Unit wgt.</th> 
                                            <th  width="50" class="text-center">Stock Bal.</th> 
                                            <th  width="50" class="text-center">Qty</th> 
                                            <th  width="100" class="text-center">Total  wgt.</th> 
                                            <th  width="50" class="text-center">Unit Price</th> 
                                            <th  width="100" class="text-center">Total Price  </th> 

                                            <th  width="50" class="text-center">Discount</th>
                                            <th  width="50" class="text-center">Discount Type</th>
                                            
                                            <th  width="50" class="text-center">Discount Unit Price </th>
                                            <th  width="100" class="text-center">Discount Amount</th>
                                            <th  width="100" class="text-center">Total After Discount</th>
                                            <th class="text-center" width="20"></th>

                                            
                                
                                        
                                        </tr>
                                    </thead>
                                    <tbody id="sortable-table">
                                        @foreach ($saleOrder->invoiceDetails  as $detail) 
                                            

                                            <tr class="">
                                                <td class="text-end"><a style="cursor:grab"><i style="font-size:25px" class="mdi mdi-drag handle text-dark"></i></a> </td>
                                
                                                <td class=""> 
                                                    <select  name="item_id[]" class="form-control select2 item-dropdown" style="width:100%">                                                
                                                        <option value="" >Choose...</option>
                                                        @foreach ($itemGoods as $item)
                                                            <option 
                                                            
                                                                @if($detail->item_id == $item->id) selected @endif

                                                                value="{{$item->id}}"
                                                                data-stock="{{ $item->balance }}"  
                                                                data-unit-weight="{{ $item->unit_weight }}"
                                                                data-sell-price="{{ $item->sell_price }}"
                                                                data-purchase-price="{{ $item->purchase_price }}"
                                                            >
                                                             {{ $item->code.'-'.$item->category_name .'-'.$item->name }}</option>
                                                        @endforeach
                                
                                                    </select>
                            
                                                </td> 
                                                
                                                <td class="text-end">
                                                    <input type="number" name="unit_weight[]" step="0.0001" class=" text-end form-control item-unit-weight" readonly>  
                                                </td>
                                                <td class="text-end">
                                                    <input type="number"  step="0.0001" class=" text-end form-control item-stock-balance" readonly>  
                                                </td>
                                                <td class="text-end">
                                                    <input type="number" name="total_quantity[]" step="0.0001" class=" text-end form-control item-total-quantity" >  
                                                </td>
                                                <td class="text-end">
                                                    <input type="number" name="net_weight[]" step="0.0001" class=" text-end form-control item-net-weight" readonly>  
                                                </td>
                                                <td class="text-end">
                                                    <input type="number" name="purchase_unit_price[]" step="0.0001" class="text-end form-control item-purchase-unit-price" readonly>  

                                                    <input type="number" name="per_unit_price[]" step="0.0001" class=" text-end form-control item-per-unit-price">  
                                                </td>
                                                <td class="text-end">
                                                    <input type="number" name="total_price[]" step="0.0001" class=" text-end form-control item-total-price" readonly>  
                                                </td>
                            
                                                <td>
                                                    <input type="number" name="discount_value[]" value="0" step="0.01" class="form-control item-discount-value" >
                                                </td>
                                
                                                <td>
                                                    <select name="discount_type[]"  class="form-select item-discount-type">                                                
                                                        <option selected value="percentage">%</option>
                                                        <option  value="fixed">Fixed</option>
                                                    </select>
                                                </td>
                                                <td class="text-end">
                                                    <input type="number" name="discount_unit_price[]" value="0" step="0.01" class=" text-end form-control item-discount-unit-price" readonly>
                                                </td>
                                                
                                                
                                                <td class="text-end">
                                                    <input type="number" name="discount_amount[]" value="0" step="0.01" class=" text-end form-control item-discount-amount" readonly>
                                                </td>
                            
                                                
                            
                                                <td class="text-end"> 
                                                    <input type="number" name="total_purchase_price[]" step="0.0001" class="text-end form-control item-total-purchase-price" readonly>  

                                                    <input type="number" name="after_discount_total_price[]" class=" text-end form-control item-after-discount" readonly>  
                                                </td>
                                                
                                                
                                                
                                                <td class="text-center">  
                                                    <a href="#"><span style="font-size:18px" class="bx bx-trash text-danger remove-item"></span></a>
                                                </td>
                                            </tr>
                                        @endforeach 
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th class="text-end" id="qty"></th>
                                            <th class="text-end" id="total-weight"></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot> 
                                </table>

                            </div> 
                           

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    {{-- <label for="form-label">Descripion</label> --}}
                                    <textarea name="description" id="description" class="form-control text-start"  rows="4"></textarea> 
                                </div>
                                
                               
                                <div class="col-md-6 d-flex align-items-top">
                                    <table id="summary-table" class="table">
                                        <tr class="">
                                            <th width="50%">Sub Total</th>
                                            <td width="50%">
                                                <input type="number" name="sub_total" id="sub-total" value="0" step="0.001" class="form-control text-end" readonly>
                                            </td>
                                        </tr>  
                                        <tr>
                                            <th>Discount</th>
                                            <td>
                                                <input type="number" name="discount_total" id="discount-total" step="0.001" value="0" class="form-control text-end" readonly>
                                            </td>
                                        </tr>
                                        <tr class="d-none">
                                            <th>Withholding Tax </th>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" name="wth_rate" id="wth-rate" step="0.001" class="form-control" placeholder="percentage">
                                                    <input type="number" name="wth_amount" id="wth-amount" step="0.001" class="form-control text-end" value="0">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="d-none">
                                            <th>GST</th>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" name="gst_rate" id="gst-rate" step="0.001" class="form-control" placeholder="percentage">
                                                    <input type="number" name="gst_amount" id="gst-amount" step="0.001" class="form-control text-end" value="0">
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- <tr class="">
                                            <th>Freight</th>
                                            <td>
                                                <div class="input-group">
                                                    <select name="freight_type" id="freight-type" class="form-control">
                                                        <option value="">Choose...</option>
                                                        <option value="inclusive">Inclusive <span>party will not pay</span></option>
                                                        <option value="exclusive">Exclusive <sub>party will pay</sub> </option>
                                                    </select>
                                                    <input type="number" name="shipping" id="shipping" step="0.001" class="form-control text-end"  autocomplete="off">
                                                </div>
                                            </td>
                                        </tr> --}}
                                        <tr>
                                            <th>Freight </th>
                                            <td>
                                                <input type="hidden" name="is_x_freight" id="is-x-freight" value="0" readonly>
                                                <div class="row">
                                                    <div class="col-md-3 my-2">
                                                        <label class="label mx-1">X</label>
                                                        <input type="checkbox"  id="x-freight-checkbox" class="form-check-input">

                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="number" step="0.001" name="shipping" id="total-freight" class="form-control text-end" autocomplete="off">

                                                    </div>
                                                </div>         
                                            </td>
                                        </tr>


                                        <tr class="d-none">
                                            <th>Commission</th>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" name="commission_rate" step="0.001" id="commission-rate" class="form-control" placeholder="percentage">
                                                    <input type="number" name="commission_amount" step="0.001" id="commission-amount" class="form-control text-end"  autocomplete="off">
                                                </div>
                                            </td>
                                        </tr>

                                        

                                        <tr class="">
                                            <th width="50%">Grand Total <sub>[sub total + GST + WTH]</sub> </th>
                                            <td width="50%">
                                                <input type="number" name="grand_total" id="grand-total" step="0.001" value="0" class="form-control text-end" readonly>
                                            </td>
                                        </tr>  

                                        <tr class="">
                                            <th width="50%">Inventory</th>
                                            <td width="50%">
                                                <input type="text" id="inventory" name="inventory" class="form-control text-end"  step="0.001" readonly>
                                            </td>
                                        </tr>  

                                        <tr class="">
                                            <th width="50%">Cost</th>
                                            <td width="50%">
                                                <input type="number" id="grand-total-purchase-price" name="grand_total_purchase_price" class="form-control text-end"  step="0.001" readonly>
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

@include('sale_invoices.js')
<script>  
    $(document).ready(function () {
        
        $('.item-dropdown').each(function(){
            $(this).trigger('change');
        })
        // appendNewRow();

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
