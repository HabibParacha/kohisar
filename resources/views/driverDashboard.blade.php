@extends('template.tmp')

@section('title', 'pagetitle')


@section('content')


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                            <div class="page-title-right ">
                                <strong class="text-danger">
                                    {{-- {{ session::get('UserID') }}-{{ session::get('UserType') }}-{{ session::get('Email') }} --}}
                                </strong>

                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="mini-stats-wid card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Total Orders</p>
                                        <h4 class="mb-0">{{ $total_orders }}</h4>
                                    </div>
                                    <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon"><span
                                            class="avatar-title rounded-circle bg-primary"><i
                                                class="bx bx-copy-alt font-size-24"></i></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mini-stats-wid card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Pending Order</p>
                                        <h4 class="mb-0">{{ $pending_orders }}</h4>
                                    </div>
                                    <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon"><span
                                            class="avatar-title rounded-circle bg-danger"><i
                                                class="bx bx-copy-alt font-size-24"></i></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mini-stats-wid card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Completed Orders</p>
                                        <h4 class="mb-0">{{ $completed_orders }}</h4>
                                    </div>
                                    <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon"><span
                                            class="avatar-title rounded-circle bg-success"><i
                                                class="bx bx-copy-alt font-size-24"></i></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mini-stats-wid card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Rejected Orders</p>
                                        <h4 class="mb-0">{{ $rejected_orders }}</h4>
                                    </div>
                                    <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon"><span
                                            class="avatar-title rounded-circle bg-warning"><i
                                                class="bx bx-copy-alt font-size-24"></i></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
            <!-- end row -->
        </div>
    </div>



    </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->


    </div>





@endsection
