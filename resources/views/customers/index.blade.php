@extends('template.tmp')
@section('title', 'kohisar')

@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h3 class="mb-sm-0 font-size-18">All Customers</h3>

                            <div class="page-title-right d-flex">

                                <div class="page-btn">
                                    <a href="#" class="btn btn-added btn-primary" data-bs-toggle="modal" data-bs-target="#add-customer"><i class="me-2"></i>Add New Customer</a>
                                </div>  
                                <button type="button" id="importButton" class="btn btn-secondary mr-2 mx-2 text-end mb-2"
                                data-bs-toggle="modal" data-bs-target="#import-model">Import
                            </button> 
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
                                            <th>Contact Person</th>
                                            <th>Mobile No</th>
                                            <th>Image</th>
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

        <!-- Add Customer -->
            <div class="modal fade" id="add-customer">
                <div class="modal-dialog custom-modal-two">
                    <div class="modal-content">
                        <div class="page-wrapper-new p-0">
                            <div class="content">
                                <div class="modal-header border-0 custom-modal-header">
                                    <div class="page-title">
                                        <h4>Create Customer</h4>
                                    </div>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body custom-modal-body">
                                    <form id="customer-store" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Contact Person</label>
                                            <input type="text" name="contact_person" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Mobile No</label>
                                            <input type="number" name="mobile_no" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Image</label>
                                            <input type="file" name="image" id="image" class="form-control">
                                        </div>
                                        
                                        <div class="mb-3 ">
                                            <label class="col-form-label">Status</label>
                                            <select name="is_active" id="is_active" class="form-select form-control" style="width:100%">
                                                <option selected value="1" >Active</option>
                                                <option value="0">Inactive</option>
                                               
                                            </select>
                                        </div>
            
                                    
                                        <div class="modal-footer-btn">
                                            <button type="button" class="btn btn-cancel me-2 btn-dark" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" id="submit-customer-store" class="btn btn-submit btn-primary">Create Customer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- /Add Customer -->

         <!-- Edit Customer -->
            <div class="modal fade" id="edit-customer">
                <div class="modal-dialog custom-modal-two">
                    <div class="modal-content">
                        <div class="page-wrapper-new p-0">
                            <div class="content">
                                <div class="modal-header border-0 custom-modal-header">
                                    <div class="page-title">
                                        <h4>Edit Customer</h4>
                                    </div>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body custom-modal-body">
                                    <form id="customer-update" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT') <!-- For PUT method -->
                                        <input type="hidden" name="id" id="customer_id"> <!-- Hidden field to store the customer ID -->
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" id="edit_name" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Contact Person</label>
                                            <input type="text" name="contact_person" id="edit_contact_person" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Mobile No</label>
                                            <input type="number" name="mobile_no" id="edit_mobile_no" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">image</label>
                                            <input type="file" name="image" id="edit_image" class="form-control">
                                        </div>
                                        <div class="mb-3 ">
                                            <label class="col-form-label">Status</label>
                                            <select name="is_active" id="edit_is_active" class="form-select form-control" style="width:100%">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                               
                                            </select>
                                        </div>
                                        

            
                                      
                                        <div class="modal-footer-btn">
                                            <button type="button" class="btn btn-cancel me-2 btn-dark" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" id="submit-customer-update" class="btn btn-submit btn-primary">Update Customer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <!-- /Edit Customer -->

     <!-- Delete Customer -->
        <div class="modal fade" id="delete-customer">
            <div class="modal-dialog custom-modal-two">
                <div class="modal-content">
                    <div class="page-wrapper-new p-0">
                        <div class="content">
                            <div class="modal-header border-0 custom-modal-header">
                                <div class="page-title">
                                    <h4>Delete Customer</h4>
                                </div>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            
                                <div class="modal-body custom-modal-body pt-3 pb-0">
                                    <p class="text-center">Are you sure you want to delete this customer?</p>
                                </div>
                                <div class="modal-footer-btn p-3 mt-2">
                                    <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-submit shadow-sm btn-danger" id="submit-customer-destroy">Delete</button>
                                </div>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
     
    <!-- /Delete Customer -->


    <!-- /import CSV File -->
        <div class="modal fade exampleModal" id="import-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import Customers</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <form action="{{ route('customer.uploadFile') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-body">
                                    <span>Click <a
                                            href="{{ route('customer.downloadSampleFile') }}">here</a>
                                        to download the sample CSV file.</span>
                                    <hr>
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="">Upload File *</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="file" name="csv_file" required
                                                        accept=".csv">
                                                    <label class="custom-file-label" for="file">Choose file</label>
                                                </div>
                                            </div>
                                            {{-- <div class="alert-warning alert alert-warning fade show" role="alert"><h5 class="alert-heading">Dear User</h5>
                                                <p>
                                                    Please double-check the drivers' mobile numbers before uploading the CSV file.
                                                </p><hr class="border-success-subtle"><p class="mb-0">Otherwise, the field will be empty, and you'll need to assign it manually</p>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- /import CSV File -->


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
                ajax: "{{ route('customer.index') }}",
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'contact_person' },
                    { data: 'mobile_no' },
                    { data: 'image', orderable: false, searchable: false },
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

          
            $('#customer-store').on('submit', function(e) {
                e.preventDefault();
                var submit_btn = $('#submit-customer-store');
                let createformData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('customer.store') }}",
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
                        
                        submit_btn.prop('disabled', false).html('Create Customer');  

                        if(response.success == true){
                            $('#add-customer').modal('hide'); 
                            $('#customer-store')[0].reset();  // Reset all form data
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
                        submit_btn.prop('disabled', false).html('Create Customer');
                    
                        notyf.error({
                            message: e.responseJSON.message,
                            duration: 5000
                        });
                    }
                });
            });
            
            $('#customer-update').on('submit', function(e) {
                e.preventDefault();
                var submit_btn = $('#submit-customer-update');
                let customer_id = $('#customer_id').val(); // Get the ID of the customer being edited

                let editFormData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('customer.update', ':id') }}".replace(':id', customer_id), // Using route name
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
                        
                        submit_btn.prop('disabled', false).html('Update Customer');  

                        if(response.success == true){
                            $('#edit-customer').modal('hide'); 
                            $('#customer-update')[0].reset();  // Reset all form data
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
                        submit_btn.prop('disabled', false).html('Update Customer');
                    
                        notyf.error({
                            message: e.responseJSON.message,
                            duration: 5000
                        });
                    }
                });
            });


            $('#submit-customer-destroy').click(function() {
                let customer_id = $(this).data('id');
                var submit_btn = $('#submit-customer-destroy');

                $.ajax({
                    type: 'DELETE',
                    url: "{{ route('customer.destroy', ':id') }}".replace(':id', customer_id), // Using route name
                    data: {
                        _token: "{{ csrf_token() }}" // Add CSRF token
                    },
                    beforeSend: function() {
                            submit_btn.prop('disabled', true);
                            submit_btn.html('Processing');
                        },
                    success: function(response) {
                        
                        submit_btn.prop('disabled', false).html('Delete Customer');  

                        if(response.success == true){
                            $('#delete-customer').modal('hide'); 
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
                        submit_btn.prop('disabled', false).html('Delete Customer');
                    
                        notyf.error({
                            message: e.responseJSON.message,
                            duration: 5000
                        });
                    }
                });
            });

        });

        // Handle the delete button click
       

        function editCustomer(id) {
            $.get("{{ route('customer.edit', ':id') }}".replace(':id', id), function(response) {
                $('#customer_id').val(response.id);
                $('#edit_name').val(response.name);
                $('#edit_contact_person').val(response.contact_person);
                $('#edit_mobile_no').val(response.mobile_no);
                $('#edit_is_active').val(response.is_active).trigger('change');              


                $('#edit-customer').modal('show');
            }).fail(function(xhr) {
                alert('Error fetching customer details: ' + xhr.responseText);
            });
        }

        function deleteCustomer(id) {
            $('#submit-customer-destroy').data('id', id);
            $('#delete-customer').modal('show');
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
