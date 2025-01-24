@extends('template.tmp')
@section('title', 'kohisar')

@section('content')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid ">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mini-stats-wid card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Item</p>
                                        <h4 class="mb-0">{{ $item->name ?? ''  }}</h4>
                                    </div>
                                    <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-package font-size-24"></i> <!-- Package icon -->
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mini-stats-wid card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Date</p>
                                        <h4 class="mb-0">{{ date('d-m-Y', strtotime($date)) }}</h4>
                                    </div>
                                    <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-cart-alt font-size-24"></i> <!-- Shopping cart icon -->
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mini-stats-wid card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Current Avg Price</p>
                                        <h4 class="mb-0">{{ number_format($avg_cost, 2) }}</h4>
                                    </div>
                                    <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-building-house font-size-24"></i> <!-- Factory icon -->
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mini-stats-wid card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Balance Wgt</p>
                                        <h4 class="mb-0">{{ number_format($stock_weight, 2) }}</h4>
                                    </div>
                                    <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-equalizer font-size-24"></i> <!-- Equalizer icon -->
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="tab-content p-1 text-muted">
                        <div class="tab-pane active" id="home1" role="tabpanel">
                            <div class="table-responsive" style="max-height: 700px;">
                                <table id="table" class="table table-sm">
                                    <thead class="table-dark sticky-top">
                                        <tr>
                                            <th></th>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Qty In</th>
                                            <th>Qty Out</th>
                                            <th>Balance</th>
                                            <th>Avg Cost</th>
                                            <th>Stock Value</th>
                                            
    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $value)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $value['date'] }}</td>
                                                <td>{{ $value['type'] }}</td>
                                                <td>{{ $value['qty_in'] }}</td>
                                                <td>{{ $value['qty_out'] }}</td>
                                                <td>{{ $value['balance'] }}</td>
                                                <td>{{ $value['avg_cost'] }}</td>
                                                <td>{{ $value['stock_value'] }}</td>
                                               
    
                                            </tr>
                                        @endforeach
    
                                    </tbody>
                                    
                                </table>
                            </div>
                            
                        </div>
                     
                       
                    </div>
                </div>


            </div>
        </div>
    </div>
    </div>

   

@endsection
