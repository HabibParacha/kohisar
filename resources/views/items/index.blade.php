@extends('template.tmp')
@section('title', 'pagetitle')

@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h3 class="mb-sm-0 font-size-18">All Items</h3>

                            <div class="page-title-right d-flex">

                                <div class="page-btn">
                                    <a href="#" class="btn btn-added btn-primary" data-bs-toggle="modal" data-bs-target="#add-item"><i class="me-2"></i>Add New Item</a>
                                </div>  
                            </div>



                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">

                        @if (session('error'))
                            <div class="alert alert-{{ Session::get('class') }} p-1" id="success-alert">

                                {{ Session::get('error') }}
                            </div>
                        @endif
                        @if (count($errors) > 0)

                            <div>
                                <div class="alert alert-danger pt-3 pl-0   border-3">
                                    <p class="font-weight-bold"> There were some problems with your input.</p>
                                    <ul>

                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                        @endif

                        <div class="card">

                            <div class="card-body">
                                <table id="table" class="table table-striped table-sm " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>Type</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>Unit</th>
                                            <th>Tax</th> 
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Add Item -->
            <div class="modal fade" id="add-item">
                <div class="modal-dialog modal-xl">
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
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Types</label>
                                                    <select name="type" class="select2 form-select" style="width:100%">
                                                        <option>Choose...</option>
                                                        @foreach ($itemTypes as $type)
                                                            <option value="{{ $type }}">{{ $type }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>                                            
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label  class="form-label">Item Code</label>
                                                    <input name="code" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label  class="form-label">Item Name</label>
                                                    <input name="name" type="text" class="form-control">
                                                </div>
                                            </div>
                                            
                                           
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Category</label>
                                                    <select name="category_id"  class="select2 form-select" style="width:100%">
                                                        <option >Choose...</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>                                        
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Brand</label>
                                                    <select  name="brand_id"  class="select2 form-select" style="width:100%">
                                                        <option >Choose...</option>
                                                        @foreach ($brands as $brand)
                                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>                                        
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Unit</label>
                                                    <select name="unit_id"  class="select2 form-select" style="width:100%">
                                                        <option >Choose...</option>
                                                        @foreach ($units as $unit)
                                                            <option value="{{$unit->id}}">{{ "Purchase: ".$unit->base_unit." | Sale: " .$unit->child_unit}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>                                        
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Warehouse</label>
                                                    <select name="warehouse_id"  class="select2 form-select" style="width:100%" >
                                                        <option >Choose...</option>
                                                        @foreach ($warehouses as $warehouse)
                                                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>                                        
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label  class="form-label">Low Stock Alert Qunatity</label>
                                                    <input type="number" name="stock_alert_qty" class="form-control">
                                                </div>
                                            </div>
                                    
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Tax</label>
                                                    <select id="tax-select" name="tax_id"  class="select2 form-select" style="width:100%">                                                
                                                        <option >Choose...</option>
                                                        @foreach ($taxes as $tax)
                                                            <option value="{{ $tax->id }}">{{ $tax->name."[".$tax->rate."]" }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>                                        
                                            </div>
                                            {{-- <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Type</label>
                                                    <select name="tax_type" class="form-select select2" style="width:100%">
                                                        <option >Choose...</option>
                                                        <option data-type="exclusive" value="exclusive">Exclusive</option>
                                                        <option data-type="inclusive" value="inclusive">Inclusive</option>                                            </select>
                                                </div>                                        
                                            </div> --}}
        
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label  class="form-label">Sell Price</label>
                                                    <input name="sell_price"  type="number" class="form-control" step="0.01">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label  class="form-label">Purchase Price</label>
                                                    <input name="purchase_price" type="number" class="form-control" step="0.01">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
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

         <!-- Edit Item -->
            <div class="modal fade" id="edit-item">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="page-wrapper-new p-0">
                            <div class="content">
                                <div class="modal-header border-0 custom-modal-header">
                                    <div class="page-title">
                                        <h4>Edit Item</h4>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        
                                    </button>
                                </div>
                                <div class="modal-body custom-modal-body">
                                    <form id="item-update" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT') <!-- For PUT method -->
                                        <input type="hidden" name="id" id="item_id"> <!-- Hidden field to store the item ID -->
                                        
                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Types</label>
                                                    <select name="type" id="edit_type" class="select2 form-select" style="width:100%">
                                                        <option>Choose...</option>
                                                        @foreach ($itemTypes as $type)
                                                            <option value="{{ $type }}">{{ $type }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>                                            
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label  class="form-label">Item Name</label>
                                                    <input name="name" id="edit_name" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label  class="form-label">Item Code</label>
                                                    <input name="code" id="edit_code" type="text" class="form-control">
                                                </div>
                                            </div>
                                           
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Category</label>
                                                    <select name="category_id" id="edit_category_id"  class="select2 form-select" style="width:100%">
                                                        <option >Choose...</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>                                        
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Brand</label>
                                                    <select  name="brand_id" id="edit_brand_id" class="select2 form-select" style="width:100%">
                                                        <option >Choose...</option>
                                                        @foreach ($brands as $brand)
                                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>                                        
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Unit</label>
                                                    <select name="unit_id" id="edit_unit_id" class="select2 form-select" style="width:100%">
                                                        <option >Choose...</option>
                                                        @foreach ($units as $unit)
                                                            <option value="{{$unit->id}}">{{ "Purchase: ".$unit->base_unit." | Sale: " .$unit->child_unit}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>                                        
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Tax</label>
                                                    <select id="edit_tax_id" name="tax_id"  class="select2 form-select" style="width:100%">                                                
                                                        <option >Choose...</option>
                                                        @foreach ($taxes as $tax)
                                                            <option value="{{ $tax->id }}">{{ $tax->name."[".$tax->rate."]" }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>                                        
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Warehouse</label>
                                                    <select name="warehouse_id" id="edit_warehouse_id"  class="select2 form-select" style="width:100%" >
                                                        <option >Choose...</option>
                                                        @foreach ($warehouses as $warehouse)
                                                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>                                        
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label  class="form-label">Low Stock Alert Qunatity</label>
                                                    <input type="number" name="stock_alert_qty" id="edit_stock_alert_qty"  class="form-control">
                                                </div>
                                            </div>
                                    
                                            
                                            {{-- <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Type</label>
                                                    <select name="tax_type" class="form-select select2" style="width:100%">
                                                        <option >Choose...</option>
                                                        <option data-type="exclusive" value="exclusive">Exclusive</option>
                                                        <option data-type="inclusive" value="inclusive">Inclusive</option>                                            </select>
                                                </div>                                        
                                            </div> --}}
        
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label  class="form-label">Sell Price</label>
                                                    <input name="sell_price" id="edit_sell_price"  type="number" class="form-control" step="0.01">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label  class="form-label">Purchase Price</label>
                                                    <input name="purchase_price" id="edit_purchase_price" type="number" class="form-control" step="0.01">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3 ">
                                                    <label class="col-form-label">Status</label>
                                                    <select name="is_active" id="edit_is_active" class="form-select form-control" style="width:100%">
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                       
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                      
                                        <div class="modal-footer-btn">
                                            <button type="button" class="btn btn-cancel me-2 btn-dark" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" id="submit-item-update" class="btn btn-submit btn-primary">Update Item</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <!-- /Edit Item -->

     <!-- Delete Item -->
        <div class="modal fade" id="delete-item">
            <div class="modal-dialog custom-modal-two">
                <div class="modal-content">
                    <div class="page-wrapper-new p-0">
                        <div class="content">
                            <div class="modal-header border-0 custom-modal-header">
                                <div class="page-title">
                                    <h4>Delete Item</h4>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    
                                </button>
                            </div>
                            
                                <div class="modal-body custom-modal-body pt-3 pb-0">
                                    <p class="text-center">Are you sure you want to delete this item?</p>
                                </div>
                                <div class="modal-footer-btn p-3 mt-2">
                                    <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-submit shadow-sm btn-danger" id="submit-item-destroy">Delete</button>
                                </div>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
     
    <!-- /Delete Item -->


 


    <!-- END: Content-->

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

        $(document).ready(function() {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('item.index') }}",
                columns: [

                    { data: 'id' },
                    { data: 'name' },
                    { data: 'code' },
                    { data: 'type' },
                    { data: 'category_name' },
                    { data: 'brand_name' },
                    { data: 'unit' },
                    { data: 'tax_name' },
                    
                    { 
                        data: 'is_active',
                        className: 'text-center', // This applies the text-center class to the entire column
                        render: function(data,type,row){
                            
                            if(data == 1)
                                return '<span class="badge bg-success font-size-12 text-center">Active</span>';
                            else
                                return '<span class="badge bg-danger font-size-12">Inactive</span>';
                    
                        }
                    
                     },
                    { data: 'action', orderable: false, searchable: false },
                ],
                order: [[0, 'desc']],
            });

          
            $('#item-store').on('submit', function(e) {
                e.preventDefault();
                var submit_btn = $('#submit-item-store');
                let createformData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('item.store') }}",
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
                        
                        submit_btn.prop('disabled', false).html('Create Item');  

                        if(response.success == true){
                            $('#add-item').modal('hide'); 
                            $('#item-store')[0].reset();  // Reset all form data
                            table.ajax.reload();
                        
                            notyf.success({
                                message: response.message, 
                                duration: 3000
                            });
                        }else{
                            notyf.error({
                                message: response.message,
                                duration: 5000
                            });
                        }   
                    },
                    error: function(e) {
                        submit_btn.prop('disabled', false).html('Create Item');
                    
                        notyf.error({
                            message: e.responseJSON.message,
                            duration: 5000
                        });
                    }
                });
            });
            
            $('#item-update').on('submit', function(e) {
                e.preventDefault();
                var submit_btn = $('#submit-item-update');
                let item_id = $('#item_id').val(); // Get the ID of the item being edited

                let editFormData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('item.update', ':id') }}".replace(':id', item_id), // Using route name
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
                        
                        submit_btn.prop('disabled', false).html('Update Item');  

                        if(response.success == true){
                            $('#edit-item').modal('hide'); 
                            $('#item-update')[0].reset();  // Reset all form data
                            table.ajax.reload();
                        
                            notyf.success({
                                message: response.message, 
                                duration: 3000
                            });
                        }else{
                            notyf.error({
                                message: response.message,
                                duration: 5000
                            });
                        }   
                    },
                    error: function(e) {
                        submit_btn.prop('disabled', false).html('Update Item');
                    
                        notyf.error({
                            message: e.responseJSON.message,
                            duration: 5000
                        });
                    }
                });
            });


            $('#submit-item-destroy').click(function() {
                let item_id = $(this).data('id');
                var submit_btn = $('#submit-item-destroy');

                $.ajax({
                    type: 'DELETE',
                    url: "{{ route('item.destroy', ':id') }}".replace(':id', item_id), // Using route name
                    data: {
                        _token: "{{ csrf_token() }}" // Add CSRF token
                    },
                    beforeSend: function() {
                            submit_btn.prop('disabled', true);
                            submit_btn.html('Processing');
                        },
                    success: function(response) {
                        
                        submit_btn.prop('disabled', false).html('Delete Item');  

                        if(response.success == true){
                            $('#delete-item').modal('hide'); 
                            table.ajax.reload();
                        
                            notyf.success({
                                message: response.message, 
                                duration: 3000
                            });
                        }else{
                            notyf.error({
                                message: response.message,
                                duration: 5000
                            });
                        }   
                    },
                    error: function(e) {
                        submit_btn.prop('disabled', false).html('Delete Item');
                    
                        notyf.error({
                            message: e.responseJSON.message,
                            duration: 5000
                        });
                    }
                });
            });

        });

        // Handle the delete button click
       

        function editItem(id) {
            $.get("{{ route('item.edit', ':id') }}".replace(':id', id), function(response) {
                $('#item_id').val(response.id);
                $('#edit_name').val(response.name);
                $('#edit_code').val(response.code);
                $('#edit_type').val(response.type).trigger('change');
                $('#edit_category_id').val(response.category_id).trigger('change');
                $('#edit_brand_id').val(response.brand_id).trigger('change');
                $('#edit_unit_id').val(response.unit_id).trigger('change');
                $('#edit_warehouse_id').val(response.warehouse_id).trigger('change');
                $('#edit_stock_alert_qty').val(response.stock_alert_qty);
                $('#edit_tax_id').val(response.tax_id).trigger('change');
                $('#edit_purchase_price').val(response.purchase_price);
                $('#edit_sell_price').val(response.sell_price);
                $('#edit_is_active').val(response.is_active).trigger('change');              

                






edit_purchase_price
edit_is_active
                $('#edit-item').modal('show');
            }).fail(function(xhr) {
                alert('Error fetching item details: ' + xhr.responseText);
            });
        }

        function deleteItem(id) {
            $('#submit-item-destroy').data('id', id);
            $('#delete-item').modal('show');
        }

    </script>

    <script>
        $(document).ready(function() {
            $('#table thead tr').clone(true).appendTo('#table thead');
            $('#table thead tr:eq(1) th').each(function(i) {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="  ' + title +
                    '"  class="form-control form-control-sm" />');


                // hide text field from any column you want too
                if (title == 'Action') {
                    $(this).hide();
                }





                $('input', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });

            });
            var table = $('#table').DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                retrieve: true,
                paging: false

            });
        });
    </script>
@endsection

{{-- 
Items

item_id

editItem
deleteItem
item
Item 
--}}