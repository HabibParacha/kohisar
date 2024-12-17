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
                            <h3 class="mb-sm-0 font-size-18">All Sale Orders</h3>

                            <div class="page-title-right d-flex">

                                <div class="page-btn">
                                    <a href="{{ route('sale-order.create') }}" class="btn btn-added btn-primary"><i class="me-2 bx bx-plus"></i>Sale Order </a>
                                </div>  
                            </div>



                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="filterRow">
                                   <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Start Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><span class="bx bx-calendar" ></span> </div>
                                                    <input type="date" name="start_date" id="start_date" class="form-control" value="">
                                                </div>
                                            
                                            </div> 
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">End Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><span class="bx bx-calendar" ></span> </div>
                                                    <input type="date" name="end_date" id="end_date" class="form-control" value="">
                                                </div>
                                            
                                            </div> 
                                        </div>

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Saleman</label>
                                                <select name="saleman_id" id="saleman_id" class="select2 form-control" autofocus>                                                
                                                    <option value="">Choose...</option>
                                                    @foreach ($userSalemen as $saleman)
                                                        <option value="{{$saleman->id}}">{{ $saleman->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>                                        
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <button type="button" class="btn btn-danger  mt-4" id="filter-btn">
                                                <i class="mdi mdi-filter"></i> Filter
                                            </button>
                                            <button type="button" class="btn btn-primary  mt-4" id="reset-filter-btn">
                                                <i class="fas fa-sync-alt"></i> Reset
                                            </button>
                                        </div>  
                                    </div>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </div>              
                </div>
                <div class="row">
                    <div class="col-12">

                       

                        <div class="card">

                            <div class="card-body">
                                <table id="table" class="table table-striped table-sm " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Receipt No</th>
                                            <th>Customer Name</th>
                                            <th>Saleman Name</th>
                                           
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

     <!-- Delete Sale Order -->
     <div class="modal fade" id="delete-sale-order">
        <div class="modal-dialog custom-modal-two">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                <h4>Delete Sale Order</h4>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                
                            </button>
                        </div>
                        
                            <div class="modal-body custom-modal-body pt-3 pb-0">
                                <h5 class="text-center text-danger">This action cannot be undone</h5>
                                <p class="text-center">Are you sure you want to permanently delete this sale order?</p>
                            </div>
                            <div class="modal-footer-btn p-3 mt-2">
                                <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-submit shadow-sm btn-danger" id="submit-sale-order-destroy">Delete</button>
                            </div>
                            
                    </div>
                </div>
            </div>
        </div>
    </div>
 
<!-- /Delete Sale Order -->



    <script>
         $(document).ready(function() {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('sale-order.index') }}",
                    data: function (d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        d.saleman_id = $('#saleman_id').val();
                    }
                },
                columns: [
                    { data: 'date' },
                    { data: 'invoice_no' },
                    { data: 'party_business_name' },
                    { data: 'saleman_name' },
                   
                    { data: 'action', orderable: false, searchable: false },
                ],
                order: [[0, 'desc']],
            });

            $('#filter-btn').on('click', function(){
                table.draw();
            });
            $('#reset-filter-btn').on('click', function(){
                $('#start_date').val('');
                $('#end_date').val('');
                $('#saleman_id').val('').trigger('change');
                table.draw();
            });
            $('#start_date').on('change', function() {
                let startDate = $(this).val();
                
                // Set the end date to the start date if it's empty or less than the start date
                let endDate = $('#end_date').val();
                if (!endDate || endDate < startDate) {
                    $('#end_date').val(startDate);
                }
                
                // Set the min attribute of the end date to the start date
                $('#end_date').attr('min', startDate);
            });
            

            $('#submit-sale-order-destroy').click(function() {
                let invoice_master_id = $(this).data('id');
                var submit_btn = $('#submit-sale-order-destroy');

                $.ajax({
                    type: 'DELETE',
                    url: "{{ route('sale-order.destroy', ':id') }}".replace(':id', invoice_master_id), // Using route name
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
                            $('#delete-sale-order').modal('hide'); 
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
            $('#submit-sale-order-destroy').data('id', id);
            $('#delete-sale-order').modal('show');
        }


        

        
        
    </script>

@endsection    
