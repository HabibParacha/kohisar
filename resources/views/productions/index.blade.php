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
                            {{-- <h3 class="mb-sm-0 font-size-18">All Productions</h3> --}}
                            <h3 class="mb-sm-0 font-size-18">All Production</h3>

                            <div class="page-title-right d-flex">

                                <div class="page-btn">
                                    <a href="{{ route('production.create') }}" class="btn btn-added btn-primary"><i class="me-2 bx bx-plus"></i>Production Plan</a>
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
                                                <label class="form-label">Recipes</label>
                                                <select name="recipe_id" id="recipe_id" class="select2 form-control" autofocus>                                                
                                                    <option value="">Choose...</option>
                                                    @foreach ($recipes as $recipe)
                                                        <option value="{{$recipe->id}}">{{ $recipe->name }}</option>
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
                                            <th>Recipe</th>
                                            <th>Production No</th>
                                            {{-- <th>batch No</th> --}}
                                            <th>Batches</th>
                                            <th>Production <sub>QTY</sub> </th>
                                            <th>Output <sub>QTY</sub> </th>
                                            <th>Surplus <sub>QTY</sub> </th>
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

     <!-- Delete Production -->
     <div class="modal fade" id="delete-production">
        <div class="modal-dialog custom-modal-two">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                <h4>Delete Production</h4>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                
                            </button>
                        </div>
                        
                            <div class="modal-body custom-modal-body pt-3 pb-0">
                                <h5 class="text-center text-danger">This action cannot be undone</h5>
                                <p class="text-center">Are you sure you want to permanently delete this production?</p>
                            </div>
                            <div class="modal-footer-btn p-3 mt-2">
                                <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-submit shadow-sm btn-danger" id="submit-production-destroy">Delete</button>
                            </div>
                            
                    </div>
                </div>
            </div>
        </div>
    </div>
 
<!-- /Delete Production -->



    <script>
         $(document).ready(function() {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('production.index') }}",
                    data: function (d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        d.recipe_id = $('#recipe_id').val();
                    }
                },
                columns: [
                    { data: 'date' },
                    { data: 'recipe_name' },
                    { data: 'invoice_no' },
                    { 
                        data: 'production_material_tons',
                        render:function(data, type,row)
                        {
                            return data ? Math.round(data) : data;
                        }
                     },
                    // { data: 'batch_no' },
                    { data: 'production_qty' },
                    { data: 'output_qty' },
                    { data: 'surplus_qty' },
                   
                   
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
                $('#recipe_id').val('').trigger('change');
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
            

            $('#submit-production-destroy').click(function() {
                let invoice_master_id = $(this).data('id');
                var submit_btn = $('#submit-production-destroy');

                $.ajax({
                    type: 'DELETE',
                    url: "{{ route('production.destroy', ':id') }}".replace(':id', invoice_master_id), // Using route name
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
                            $('#delete-production').modal('hide'); 
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
            $('#submit-production-destroy').data('id', id);
            $('#delete-production').modal('show');
        }


        

        
        
    </script>

@endsection    
