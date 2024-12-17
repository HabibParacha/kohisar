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
                            <h3 class="mb-sm-0 font-size-18">opeing Balance</h3>

                            <div class="page-title-right d-flex">

                                <div class="page-btn">
                                    <a href="{{ route('finished-goods-stock.create') }}" class="btn btn-added btn-primary" i class="me-2"></i>Opening Balance</a>
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
                                            <th>ID</th>
                                            <th>Inovice No</th>
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



 


    <!-- END: Content-->

    

    <script>

        $(document).ready(function() {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('finished-goods-stock.index') }}",
                columns: [
                    { data: 'id' },
                    { data: 'invoice_no' },
                    { data: 'action', orderable: false, searchable: false },

                ],
                order: [[0, 'desc']],
            });
        });

       

       

    </script>

 
@endsection

{{-- 
Brands

brand_id

editBrand
deleteBrand
brand
Brand 
--}}