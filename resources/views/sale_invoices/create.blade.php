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
                                            <th  width="10" class="text-start" ></th>
                                            <th  width="200" class="text-start" >Item</th> 
                                            <th  width="50" class="text-center">Unit wgt.</th> 
                                            <th  width="50" class="text-center">Stock Bal.</th> 
                                            <th  width="50" class="text-center">Qty</th> 
                                            <th  width="100" class="text-center">Total  wgt.</th> 
                                            <th  width="50" class="text-center">Retail Price</th> 
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

                                <button id="btn-add-more" class="btn btn-primary"><span class="bx bx-plus"></span> Add More</button>
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
                                        <tr class="">
                                            <th>Withholding Tax </th>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" name="wth_rate" id="wth-rate" step="0.001" class="form-control" placeholder="percentage">
                                                    <input type="number" name="wth_amount" id="wth-amount" step="0.001" class="form-control text-end" value="0">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <th>GST</th>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" name="gst_rate" id="gst-rate" step="0.001" class="form-control" placeholder="percentage">
                                                    <input type="number" name="gst_amount" id="gst-amount" step="0.001" class="form-control text-end" value="0">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="">
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
                                        </tr>


                                        <tr class="">
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


    @include('sale_invoices.js')

<script>  
    $(document).ready(function () {
      
        appendNewRow();

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
