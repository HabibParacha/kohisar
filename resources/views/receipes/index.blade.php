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
                            <h3 class="mb-sm-0 font-size-18">All Receipes</h3>

                            <div class="page-title-right d-flex">

                                <div class="page-btn">
                                    <a href="{{ route('receipe.create') }}" class="btn btn-added btn-primary"><i class="me-2 bx bx-plus"></i>Receipe</a>
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
                                            <th>Description</th>
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


     <!-- Delete Receipe -->
        <div class="modal fade" id="delete-receipe">
            <div class="modal-dialog custom-modal-two">
                <div class="modal-content">
                    <div class="page-wrapper-new p-0">
                        <div class="content">
                            <div class="modal-header border-0 custom-modal-header">
                                <div class="page-title">
                                    <h4>Delete Receipe</h4>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    
                                </button>
                            </div>
                            
                                <div class="modal-body custom-modal-body pt-3 pb-0">
                                    <p class="text-center">Are you sure you want to delete this receipe?</p>
                                </div>
                                <div class="modal-footer-btn p-3 mt-2">
                                    <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-submit shadow-sm btn-danger" id="submit-receipe-destroy">Delete</button>
                                </div>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
     
    <!-- /Delete Receipe -->


 


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
                ajax: "{{ route('receipe.index') }}",
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'description' },
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


            $('#submit-receipe-destroy').click(function() {
                let receipe_id = $(this).data('id');
                var submit_btn = $('#submit-receipe-destroy');

                $.ajax({
                    type: 'DELETE',
                    url: "{{ route('receipe.destroy', ':id') }}".replace(':id', receipe_id), // Using route name
                    data: {
                        _token: "{{ csrf_token() }}" // Add CSRF token
                    },
                    beforeSend: function() {
                            submit_btn.prop('disabled', true);
                            submit_btn.html('Processing');
                        },
                    success: function(response) {
                        
                        submit_btn.prop('disabled', false).html('Delete Receipe');  

                        if(response.success == true){
                            $('#delete-receipe').modal('hide'); 
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
                        submit_btn.prop('disabled', false).html('Delete Receipe');
                    
                        notyf.error({
                            message: e.responseJSON.message,
                            duration: 5000
                        });
                    }
                });
            });

        });

        // Handle the delete button click

        function deleteReceipe(id) {
            $('#submit-receipe-destroy').data('id', id);
            $('#delete-receipe').modal('show');
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
Receipes

receipe_id

editBrand
deleteBrand
receipe
Receipe 
--}}