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
                                        <label class="form-label">Reference No</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bxs-receipt" ></span> </div>
                                            <input type="text" name="reference_no" id="reference_no" value="{{ $invoice_master->reference_no }}" class="form-control" autocomplete="off">
                                        </div> 
                                    </div> 
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Receipt No</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bx-receipt"></span> </div>
                                            <input type="text"  class="form-control" value="{{ $invoice_master->invoice_no }}" readonly>
                                        </div> 
                                    </div> 
                                </div>

                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Vehicle No</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bxs-truck" ></span> </div>
                                            <input type="text" name="vehicle_no" value="{{ $invoice_master->vehicle_no }}" class="form-control" autocomplete="off">
                                        </div> 
                                    </div> 
                                </div>
                               

                             
                                <div class="col-md-2">
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



                                            <th class="text-center" width="100">Per Kg Price <br>Supplier</th>
                                            <th class="text-center" width="100">
                                                Total Price <br>Supplier  <i class="bx bxs-help-circle mr-1" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="per kg price x after cut">
                                            </th>

                                            <th class="text-center" width="100">Per Kg Price <br>Stock</th>
                                            <th class="text-center" width="100">
                                                Total Price <br>Stock  <i class="bx bxs-help-circle mr-1" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="(per kg price + freigt x) x after cut">
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
                                            <input type="number" name="gross_weight[]" value="{{ $detail->gross_weight }}" step="0.0001" class="form-control item-gross-weight"  autocomplete="off">  
                                        </td>
                                    
                                        @if($detail->cut_percentage > 0)
                                            <td class="text-center"> 
                                                <input class="form-check-input cut-checkbox" type="checkbox" checked>
                                            </td>
                                            <td> 
                                                <input type="number" name="cut_percentage[]" value="{{ $detail->cut_percentage }}" step="0.0001" class="form-control item-cut-percentage"  autocomplete="off">  
                                            </td>
                                            <td> 
                                                <input type="number" name="cut_value[]" value="{{ $detail->cut_value }}" step="0.0001" class="form-control item-cut-value text-end" readonly>  
                                            </td>
                                            <td> 
                                                <input type="number" name="after_cut_total_weight[]" value="{{ $detail->after_cut_total_weight }}" step="0.0001" class="form-control item-after-cut-total-weight text-end" readonly>  
                                            </td>
                                        @else
                                            <td class="text-center"> 
                                                <input class="form-check-input cut-checkbox" type="checkbox">
                                            </td>
                                            <td> 
                                                <input type="number" name="cut_percentage[]" value="0" step="0.0001" class="form-control item-cut-percentage d-none"  autocomplete="off">  
                                            </td>
                                            <td> 
                                                <input type="number" name="cut_value[]" value="0" step="0.0001" class="form-control item-cut-value d-none text-end" readonly>  
                                            </td>
                                            <td> 
                                                <input type="number" name="after_cut_total_weight[]" value="{{ $detail->after_cut_total_weight }}" step="0.0001" class="form-control item-after-cut-total-weight d-none text-end" readonly>  
                                            </td>
                                        @endif
                                    
                                        <td> 
                                            <input type="number" name="total_quantity[]" value="{{ $detail->total_quantity }}" step="0.0001" class="form-control item-total-quantity"  autocomplete="off">  
                                        </td>
                                        <td> 
                                            <input type="number" name="per_package_weight[]" value="{{ $detail->per_package_weight }}" step="0.0001" class="form-control item-per-package-weight"  autocomplete="off">  
                                        </td>
                                        <td> 
                                            <input type="number" name="total_package_weight[]" value="{{ $detail->total_package_weight }}" step="0.0001" class="form-control item-total-package-weight text-end" readonly>  
                                        </td>
                                        <td> 
                                            <input type="number" name="net_weight[]" value="{{ $detail->net_weight }}" step="0.0001" class="form-control item-net-weight text-end" readonly>  
                                        </td>
                                        <td> 
                                            <input type="number" name="per_unit_price[]" value="{{ $detail->per_unit_price }}" step="0.0001" class="form-control item-per-unit-price"  autocomplete="off">  
                                            <input type="hidden" name="per_unit_price_old_value[]" value="{{ $detail->per_unit_price }}" step="0.0001" class="form-control">  
                                        
                                        </td>
                                        <td> 
                                            <input type="number" name="total_price[]" value="{{ $detail->total_price }}" step="0.0001" class="form-control item-total-price text-end" readonly>  
                                        </td>
                                        <td> 
                                            <input type="number" name="per_unit_price_stock[]" value="{{ $detail->per_unit_price_stock  }}" step="0.0001" class="form-control item-per-unit-price-stock text-end"  readonly>  
                                        </td>
                                        
                                
                                        <td > 
                                            <input type="number" name="total_price_stock[]" value="{{ $detail->total_price_stock  }}" step="0.0001" class="form-control item-total-price-stock text-end" readonly>  
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
                                            <th width="50%">Sub Total Booked in Supplier</th>
                                            <td width="50%">
                                                <input type="number" step="0.01" name="sub_total" id="sub-total" value="{{ $invoice_master->sub_total }}" class="form-control text-end" readonly>
                                            </td>
                                        </tr>  
                                        <tr>
                                            <th width="50%">Sub Total Booked in Stock</th>
                                            <td width="50%">
                                                <input type="number" step="0.01" name="sub_total_stock" id="sub-total-stock" value="{{ $invoice_master->sub_total_stock }}" class="form-control text-end" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Freight </th>
                                            <td>
                                                <input type="hidden" name="is_x_freight" id="is-x-freight" value="{{ $invoice_master->is_x_freight }}" readonly>
                                                <div class="row">
                                                    <div class="col-md-3 my-2">
                                                        <label class="label mx-1">X</label>
                                                        <input type="checkbox"  id="x-freight-checkbox" @checked($invoice_master->is_x_freight == 1)  class="form-check-input">

                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="number" step="0.001" name="shipping" value="{{ $invoice_master->shipping }}" id="total-freight" class="form-control text-end" autocomplete="off">

                                                    </div>
                                                </div>         
                                            </td>
                                        </tr>   
                                       

                                        <tr class="">
                                            <th width="50%">Grand Total</th>
                                            <td width="50%">
                                                <input type="number" step="0.01" name="grand_total" id="grand-total" value="{{ $invoice_master->grand_total }}" class="form-control text-end" readonly>
                                            </td>
                                        </tr>  
                                       
                                        <tr class="">
                                            <th width="50%">Total Bags</th>
                                            <td width="50%">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select class="form-control form-select" name="bag_type_name" id="">
                                                            <option @selected($invoice_master->bag_type_name == 'Jute') value="Jute">Jute</option>
                                                            <option @selected($invoice_master->bag_type_name == 'Plastic')  value="Plastic">Plastic</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="number" step="0.001" name="total_bags" id="total-bags" value="{{ number_format($invoice_master->total_bags,2) }}" class="form-control text-end" readonly>

                                                    </div>
                                                </div>
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

    



<script>  
    // $(document).ready(function () {
    //     summaryCalculation();
    // });
    //  // Detect Enter key in input fields
     $('#purchase-order-update').on('keydown', function(e) {
        if (e.key === 'Enter') {
        e.preventDefault(); // Prevent the default behavior (form submission)
        }
    });



</script>

@include('purchase_orders.js')



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


