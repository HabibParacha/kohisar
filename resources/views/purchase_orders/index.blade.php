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
                                            <th>Vehcile No</th>
                                            <th>Supplier Name</th>
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


    <script>
         $(document).ready(function() {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('purchase-order.index') }}",
                columns: [
                    { data: 'date' },
                    { data: 'invoice_no' },
                    { data: 'vehicle_no' },
                    { data: 'party_business_name' },
                    { data: 'shipping' },
                    { data: 'grand_total' },
                   
                    { data: 'action', orderable: false, searchable: false },
                ],
                order: [[0, 'desc']],
            });
        });

        
        
    </script>

@endsection    
