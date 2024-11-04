@extends('template.tmp')
@section('title', 'pagetitle')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                
                <form>
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h3 class="mb-sm-0 font-size-18">{{ $party->business_name }}</h3>
    
                                <div class="page-title-right d-flex">
    
                                    <div class="page-btn">
                                        <a href="#" class="btn btn-added btn-primary" data-bs-toggle="modal" data-bs-target="#add-party-warehouse"><i class="me-2 bx bx-plus"></i>Warehouse</a>
                                    </div>  
                                </div>
    
    
    
                            </div>
                        </div>
                    </div>
                   <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <h4 class="card-title mb-4">Contact Information</h4>

                                    

                                        <div class="row business">
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Business Name</label>
                                                    <input name="business_name" id="business_name" type="text" value="{{ $party->business_name }}" class="form-control">
                                                </div>   
                                            </div>
                                        </div>   
                                        
                                    </div>
                                </div>    
                            </div>
                        </div>
            
                        <div class="col-md-6">
                            <div class="card">

                                <div class="card-body">
                                    <h4 class="card-title mb-4">Warehouses</h4>

                                    <table id="table" class="table table-striped table-sm " style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>name</th>
                                                <th>location</th>
                                                <th>city</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($party->partyWarehouses as $warehouse )
                                               <tr>
                                                    <td>{{ $warehouse->name }}</td>
                                                    <td>{{ $warehouse->location }}</td>
                                                    <td>{{ $warehouse->city }}</td>
                                                    <td>
                                                        <a href="javascript:void(0)" onclick="editPartyWarehouse({{ $warehouse->id }})" class="dropdown-party-warehouse">
                                                            <i class="fas fas fa-pencil-alt font-size-16  me-1 text-primary "></i> 
                                                        </a>
                                                        <a href="javascript:void(0)" onclick="deletePartyWarehouse({{ $warehouse->id }})" class="dropdown-party-warehouse">
                                                            <i class="fas fa-trash-alt font-size-16 me-1 text-danger mx-2"></i> 
                                                        </a>
                                                    </td>
                                                   
                                               </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                   </div>
                   
                        
                  
                </form>
            </div>
         </div>
    </div>
    <!-- Add Warehouse -->
        <div class="modal fade" id="add-party-warehouse">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="page-wrapper-new p-0">
                        <div class="content">
                            <div class="modal-header border-0 custom-modal-header">
                                <div class="page-title">
                                    <h4>Add Warehouse</h4>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    
                                </button>
                            </div>
                            <div class="modal-body custom-modal-body">
                                <form id="party-warehouse-store" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="party_id" value="{{ $party->id }}">
                                    <div class="row">
                                    
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label  class="form-label">Name</label>
                                                <input name="name" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label  class="form-label">Location</label>
                                                <input name="location" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label  class="form-label">City</label>
                                                <input name="city" type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    

                                
                                    <div class="modal-footer-btn">
                                        <button type="button" class="btn btn-cancel me-2 btn-dark" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" id="submit-party-warehouse-store" class="btn btn-submit btn-primary">Add Warehouse</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- /Add Warehouse -->



    
    
    <!-- Edit Warehouse -->
        <div class="modal fade" id="edit-party-warehouse">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="page-wrapper-new p-0">
                        <div class="content">
                            <div class="modal-header border-0 custom-modal-header">
                                <div class="page-title">
                                    <h4>Edit Warehouse</h4>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    
                                </button>
                            </div>
                            <div class="modal-body custom-modal-body">
                                <form id="party-warehouse-update" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" id="party_warehouse_id">
                                    <div class="row">
                                    
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label  class="form-label">Name</label>
                                                <input name="name" id="edit_name" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label  class="form-label">Location</label>
                                                <input name="location" id="edit_location" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label  class="form-label">City</label>
                                                <input name="city" id="edit_city" type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    

                                
                                    <div class="modal-footer-btn">
                                        <button type="button" class="btn btn-cancel me-2 btn-dark" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" id="submit-party-warehouse-update" class="btn btn-submit btn-primary">Edit Warehouse</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- /Edit Warehouse -->


    <!-- Delete Warehouse -->
        <div class="modal fade" id="delete-party-warehouse">
            <div class="modal-dialog custom-modal-two">
                <div class="modal-content">
                    <div class="page-wrapper-new p-0">
                        <div class="content">
                            <div class="modal-header border-0 custom-modal-header">
                                <div class="page-title">
                                    <h4>Delete Party Warehouse</h4>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    
                                </button>
                            </div>
                            
                                <div class="modal-body custom-modal-body pt-3 pb-0">
                                    <p class="text-center">Are you sure you want to delete this party-warehouse?</p>
                                </div>
                                <div class="modal-footer-btn p-3 mt-2">
                                    <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-submit shadow-sm btn-danger" id="submit-party-warehouse-destroy">Delete</button>
                                </div>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- /Delete Warehouse -->
<script>

    $(document).ready(function () {
        $('#party-warehouse-store').on('submit', function(e) {
            e.preventDefault();
            var submit_btn = $('#submit-party-warehouse-store');
            let createformData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "{{ route('party-warehouse.store') }}",
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
                    
                    submit_btn.prop('disabled', false).html('Add Warehouse');  

                    if(response.success == true){
                        $('#add-party-warehouse').modal('hide'); 
                        $('#party-warehouse-store')[0].reset();  // Reset all form data
                        location.reload(true);                        
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
                    submit_btn.prop('disabled', false).html('Add Warehouse');
                
                    notyf.error({
                        message: e.responseJSON.message,
                        duration: 5000
                    });
                }
            });
        });


        $('#party-warehouse-update').on('submit', function(e) {
                e.preventDefault();
                var submit_btn = $('#submit-party-warehouse-update');
                let party_warehouse_id = $('#party_warehouse_id').val(); // Get the ID of the party-warehouse being edited

                let editFormData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('party-warehouse.update', ':id') }}".replace(':id', party_warehouse_id), // Using route name
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
                        
                        submit_btn.prop('disabled', false).html('Update Brand');  

                        if(response.success == true){
                            $('#edit-party-warehouse').modal('hide'); 
                            $('#party-warehouse-update')[0].reset();  // Reset all form data
                            location.reload(true);                        
                            
                        
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
                        submit_btn.prop('disabled', false).html('Update Brand');
                    
                        notyf.error({
                            message: e.responseJSON.message,
                            duration: 5000
                        });
                    }
                });
            });


            $('#submit-party-warehouse-destroy').click(function() {
                let party_warehouse_id = $(this).data('id');
                var submit_btn = $('#submit-party-warehouse-destroy');

                $.ajax({
                    type: 'DELETE',
                    url: "{{ route('party-warehouse.destroy', ':id') }}".replace(':id', party_warehouse_id), // Using route name
                    data: {
                        _token: "{{ csrf_token() }}" // Add CSRF token
                    },
                    beforeSend: function() {
                            submit_btn.prop('disabled', true);
                            submit_btn.html('Processing');
                        },
                    success: function(response) {
                        
                        submit_btn.prop('disabled', false).html('Delete Brand');  

                        if(response.success == true){
                            $('#delete-party-warehouse').modal('hide'); 
                            location.reload(true);                        
                        
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
                        submit_btn.prop('disabled', false).html('Delete Brand');
                    
                        notyf.error({
                            message: e.responseJSON.message,
                            duration: 5000
                        });
                    }
                });
            });
    });


        function editPartyWarehouse(id) {
            $.get("{{ route('party-warehouse.edit', ':id') }}".replace(':id', id), function(response) {
                $('#party_warehouse_id').val(response.id);
                $('#edit_name').val(response.name);
                $('#edit_location').val(response.location);
                $('#edit_city').val(response.city);

                $('#edit-party-warehouse').modal('show');
                
            }).fail(function(xhr) {
                alert('Error fetching party-warehouse details: ' + xhr.responseText);
            });
            
        }
        function deletePartyWarehouse(id) {
            $('#submit-party-warehouse-destroy').data('id', id);
            $('#delete-party-warehouse').modal('show');
        }
    
</script>

@endsection
