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
                            {{-- <h3 class="mb-sm-0 font-size-18">All Purchase Orders</h3> --}}
                            <h3 class="mb-sm-0 font-size-18">All Bill Receipt</h3>

                            <div class="page-title-right d-flex">

                                <div class="page-btn">
                                    <a href="{{ route('purchase-order.create') }}" class="btn btn-added btn-primary"><i class="me-2 bx bx-plus"></i>Bill Receipt </a>
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
                                            <th>Date</th>
                                            <th>Receipt No</th>
                                            <th>Reference No</th>
                                            <th>Supplier Name</th>
                                            <th>Vehcile No</th>
                                            <th>Total bags</th>
                                            <th>Shipping</th>
                                            <th>Total Amount</th>
                                           
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

     <!-- Delete Purchase Order -->
     <div class="modal fade" id="delete-purchase-order">
        <div class="modal-dialog custom-modal-two">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                <h4>Delete Purchase Order</h4>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                
                            </button>
                        </div>
                        
                            <div class="modal-body custom-modal-body pt-3 pb-0">
                                <h5 class="text-center text-danger">This action cannot be undone</h5>
                                <p class="text-center">Are you sure you want to permanently delete this purchase order?</p>
                            </div>
                            <div class="modal-footer-btn p-3 mt-2">
                                <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-submit shadow-sm btn-danger" id="submit-purchase-order-destroy">Delete</button>
                            </div>
                            
                    </div>
                </div>
            </div>
        </div>
    </div>
 
<!-- /Delete Purchase Order -->



    <script>
         $(document).ready(function() {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('purchase-order.index') }}",
                columns: [
                    { data: 'date' },
                    { data: 'invoice_no' },
                    { data: 'reference_no' },
                    { data: 'party_business_name' },
                    { data: 'vehicle_no' },
                    { data: 'total_bags' },
                    { data: 'shipping' },
                    { data: 'grand_total' },
                   
                    { data: 'action', orderable: false, searchable: false },
                ],
                order: [[0, 'desc']],
            });

            $('#submit-purchase-order-destroy').click(function() {
                let invoice_master_id = $(this).data('id');
                var submit_btn = $('#submit-purchase-order-destroy');

                $.ajax({
                    type: 'DELETE',
                    url: "{{ route('purchase-order.destroy', ':id') }}".replace(':id', invoice_master_id), // Using route name
                    data: {
                        _token: "{{ csrf_token() }}" // Add CSRF token
                    },
                    beforeSend: function() {
                            submit_btn.prop('disabled', true);
                            submit_btn.html('Processing');
                        },
                    success: function(response) {
                        
                        submit_btn.prop('disabled', false).html('Delete');  

                        if(response.success == true){
                            $('#delete-purchase-order').modal('hide'); 
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
                        submit_btn.prop('disabled', false).html('Delete');
                    
                        notyf.error({
                            message: e.responseJSON.message,
                            duration: 5000
                        });
                    }
                });
            });
        });
        function deletePurchaseOrder(id) {
            $('#submit-purchase-order-destroy').data('id', id);
            $('#delete-purchase-order').modal('show');
        }


        

        
        
    </script>

@endsection    
