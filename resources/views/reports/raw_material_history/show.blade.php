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
                                        <h4 class="mb-0">{{ $receipts[0]->item->name ?? ''  }}</h4>
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
                                        <p class="text-muted fw-medium">Purchase Net Wgt.</p>
                                        <h4 class="mb-0">{{ number_format($receipts->sum('net_weight'), 2) }}</h4>
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
                                        <p class="text-muted fw-medium">Production</p>
                                        <h4 class="mb-0">{{ number_format($productions->sum('net_weight'), 2) }}</h4>
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
                                        <p class="text-muted fw-medium">Balance</p>
                                        <h4 class="mb-0">{{ number_format($receipts->sum('net_weight') - $productions->sum('net_weight'), 2) }}</h4>
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
                
               <div class="row">
                <div class="col-md-4">
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab" aria-selected="true">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Purchases</span> 
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab" aria-selected="false" tabindex="-1">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Productions</span> 
                            </a>
                        </li>
                       
                    </ul>
                </div>
               </div>
                <div class="card">
                    <div class="tab-content p-1 text-muted">
                        <div class="tab-pane active" id="home1" role="tabpanel">
                            <div class="table-responsive" style="max-height: 700px;">
                                <table id="table" class="table table-sm">
                                    @if ($receipts->isNotEmpty())
        
                                        <thead class="table-dark sticky-top">
                                            <tr>
                                                <th></th>
                                                <th>Date</th>
                                                <th>Invoice No</th>
                                                <th class="text-end">Gross Wgt</th>
                                                <th class="text-end">Cut %</th>
                                                <th class="text-end">Cut Value</th>
                                                <th class="text-end">After Cut Wgt</th>
                                                <th class="text-end">Price</th>
                                                <th class="text-end">Bags</th>
                                                <th class="text-end">Empty Wgt</th>
                                                <th class="text-end">Tot Empty</th>
                                                <th class="text-end">Net Weight</th>
        
                                            </tr>
                                        </thead>
        
                                        <tbody>
                                            @foreach ($receipts as $value)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $value->date }}</td>
                                                    <td>{{ $value->invoice_no }}</td>
                                                    <td class="text-end">{{ $value->gross_weight }}</td>
                                                    <td class="text-end">{{ $value->cut_percentage }}</td>
                                                    <td class="text-end">{{ $value->cut_value }}</td>
                                                    <td class="text-end"> {{ $value->after_cut_total_weight }}</td>
                                                    <td class="text-end"> {{ $value->per_unit_price }}</td>
                                                    <td class="text-end">{{ number_format($value->total_quantity) }}</td>
                                                    <td class="text-end">{{ $value->per_package_weight }}</td>
                                                    <td class="text-end">{{ $value->total_package_weight }}</td>
                                                    <td class="text-end">{{ $value->net_weight }}</td>
        
                                                </tr>
                                            @endforeach
        
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="fw-bold text-end">
                                                    {{ number_format($receipts->sum('gross_weight'), 0) }}</td>
                                                <td></td>
                                                <td class="fw-bold text-end">
                                                    {{ number_format($receipts->sum('cut_value'), 0) }}</td>
                                                <td class="fw-bold text-end">
                                                    {{ number_format($receipts->sum('after_cut_total_weight'), 0) }}</td>
                                                <td class="fw-bold text-end">
                                                    {{ number_format($receipts->sum('total_quantity'), 0) }}</td>
                                                <td></td>
                                                <td class="fw-bold text-end">
                                                    {{ number_format($receipts->sum('total_package_weight'), 2) }}</td>
                                                <td class="fw-bold text-end">
                                                    {{ number_format($receipts->sum('net_weight'), 2) }}</td>
        
                                            </tr>
                                        </tfoot>
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center fw-bold text-danger mt-5">No Record Found
                                                ...</td>
        
                                        </tr>
                                    @endif
                                </table>
                            </div>
                            
                        </div>
                        <div class="tab-pane" id="profile1" role="tabpanel">
                            <div class="table-responsive" style="max-height: 700px;">
                                <table id="table" class="table table-hover table-sm">
                                    @if ($productions->isNotEmpty())
        
                                        <thead class="table-dark sticky-top">
                                            <tr>
                                                <th width="5"></th>
                                                <th width="100">Date</th>
                                                <th width="100">Invoice No</th>
        
                                                <th width="100">Net Weight</th>
        
                                            </tr>
                                        </thead>
        
                                        <tbody>
                                            @foreach ($productions as $value)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $value->date }}</td>
                                                    <td>{{ $value->invoice_no }}</td>
        
                                                    <td class="text-end">{{ $value->net_weight }}</td>
        
                                                </tr>
                                            @endforeach
        
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
        
                                                <td class="fw-bold text-end">
                                                    {{ number_format($productions->sum('net_weight'), 2) }}</td>
        
                                            </tr>
                                        </tfoot>
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center fw-bold text-danger mt-5">No Record Found
                                                ...</td>
        
                                        </tr>
                                    @endif
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
