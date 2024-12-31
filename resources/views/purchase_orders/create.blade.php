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
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h3 class="mb-sm-0 font-size-18">All Items</h3>
                        <h3 class="mb-sm-0 font-size-18 text-danger">New Module Test Page</h3>

                        <div class="page-title-right d-flex">

                            {{-- <div class="page-btn">
                                <a href="#" class="btn btn-added btn-primary" data-bs-toggle="modal" data-bs-target="#add-item"><i class="me-2 bx bx-plus"></i>Item</a>
                            </div>   --}}
                        </div>



                    </div>
                </div>
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
                                        <select name="party_id"  id="party_id" class="select2 form-control" autofocus>                                                
                                            <option value="">Choose...</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{$supplier->id}}">
                                                    {{ $supplier->id .'-'.$supplier->business_name }}
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
                                            <input type="text" name="reference_no" id="reference_no" class="form-control" autocomplete="off">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Receipt No</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bx-receipt"></span> </div>
                                            <input type="text"  class="form-control" value="{{ $newInvoiceNo }}" readonly>
                                        </div> 
                                    </div> 
                                </div>

                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Vehicle No</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bxs-truck" ></span> </div>
                                            <input type="text" name="vehicle_no" id="vehicle_no" class="form-control" autocomplete="off">
                                        </div> 
                                    </div> 
                                </div>
                               

                             
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Date</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><span class="bx bx-calendar" ></span> </div>
                                            <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}">
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
                                            <th width="50%">Sub Total Booked in Supplier</th>
                                            <td width="50%">
                                                <input type="number" step="0.01" name="sub_total" id="sub-total" value="0" class="form-control text-end" readonly>
                                            </td>
                                        </tr>  
                                        <tr>
                                            <th width="50%">Sub Total Booked in Stock</th>
                                            <td width="50%">
                                                <input type="number" step="0.01" name="sub_total_stock" id="sub-total-stock" value="0" class="form-control text-end" readonly>
                                            </td>
                                        </tr>  
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

                                        <tr class="">
                                            <th width="50%">Grand Total</th>
                                            <td width="50%">
                                                <input type="number" step="0.01" name="grand_total" id="grand-total" value="0" class="form-control text-end" readonly>
                                            </td>
                                        </tr>  
                            
                                        <tr class="">
                                            <th width="50%">Total Bags</th>
                                            <td width="50%">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select class="form-control form-select" name="bag_type_name" id="">
                                                            <option value="Jute">Jute</option>
                                                            <option value="Plastic">Plastic</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="number" step="0.001" name="total_bags" id="total-bags" value="0" class="form-control text-end" readonly>

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



     <!-- Add Item -->
     <div class="modal fade" id="add-item">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                <h4>Create Item</h4>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                
                            </button>
                        </div>
                        <div class="modal-body custom-modal-body">
                            <form id="item-store" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Types</label>
                                            <select name="type" class="form-select" style="width:100%">
                                                <option value="">Choose...</option>
                                                @foreach ($itemTypes as $type)
                                                    <option value="{{ $type }}">{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </div>                                            
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label  class="form-label">Item Code</label>
                                            <input name="code" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label  class="form-label">Item Name</label>
                                            <input name="name" type="text" class="form-control">
                                        </div>
                                    </div>
                                    
                                   
                                    
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label  class="form-label">Low Stock Alert Qunatity</label>
                                            <input type="number" name="stock_alert_qty" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-12 d-none">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="is_active" id="is_active" class="form-select form-control" style="width:100%">
                                                <option selected value="1" >Active</option>
                                                <option value="0">Inactive</option>
                                            
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="modal-footer-btn">
                                    <button type="button" class="btn btn-cancel me-2 btn-dark" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" id="submit-item-store" class="btn btn-submit btn-primary">Create Item</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- /Add Item -->

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
        // Event listener for the select2:open event
        $('#table').on('select2:open', '.item-dropdown-list', function(e) {
        e.preventDefault();

        let itemDropdown = $(this); // Reference to the clicked dropdown

        // Only fetch items if the dropdown is empty
        if (itemDropdown.children('option').length === 0) {
            $.ajax({
                url: '{{ route('items.getAll') }}',
                type: 'GET',
                beforeSend: function() {
                    itemDropdown.append('<option value="">Loading...</option>');
                },
                success: function(data) {
                    itemDropdown.empty(); // Clear current options
                    console.log(data);

                    itemDropdown.append('<option selected value="">Choose...</option>');
                    
                    // Check if data is empty
                    if (data.length === 0) {
                        itemDropdown.append('<option disabled>No records found</option>');
                    } else {
                        // Append the new items
                        $.each(data, function(index, item) {
                            itemDropdown.append(new Option(item.name, item.id));
                        });
                    }

                    // Close the dropdown
                    itemDropdown.select2('close');
                    // Notify select2 about the change
                    itemDropdown.trigger('change');
                    itemDropdown.select2('open');
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", status, error);
                    alert('Failed to load items. Please try again.'); // Optional user feedback
                }
            });
        }
    });


});
</script>



<script>  
    $(document).ready(function () {
      
        appendNewRow();

    });

       //  Detect Enter key in input fields
    $('#purchase-order-store').on('keydown', function(e) {
        if (e.key === 'Enter') {
        e.preventDefault(); // Prevent the default behavior (form submission)
        }
    });

</script>

@include('purchase_orders.js')

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
