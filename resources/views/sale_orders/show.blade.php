@extends('template.tmp')

@section('title', 'pagetitle')


@section('content')



    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->


                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title">
                            <h4 class="float-end font-size-16">Date: {{ date('d-m-Y',strtotime($saleOrder->date)) }}</h4>
                            <div class="auth-logo mb-4">
                             
                                <h4># {{ $saleOrder->invoice_no }}</h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <address>
                                    <h5>Billed To:</h5><br>
                                   <span class="fw-bold">Customer: </span>  {{ $saleOrder->party->business_name }}<br>
                                   <span class="fw-bold">Contact: </span> {{ $saleOrder->party->mobile}}<br>
                                   <span class="fw-bold">City: </span> {{  $saleOrder->party->city  }}<br>
                                   <span class="fw-bold">Address: </span>{{  $saleOrder->party->address_line_1 }}
                                </address>
                            </div>
                            
                        </div>
                        {{-- <div class="row">
                            <div class="col-sm-6 mt-3">
                                <address>
                                    <strong>Payment Method:</strong><br>
                                    Visa ending **** 4242<br>
                                    jsmith@email.com
                                </address>
                            </div>
                            <div class="col-sm-6 mt-3 text-sm-end">
                                <address>
                                    <strong>Order Date:</strong><br>
                                    October 16, 2019<br><br>
                                </address>
                            </div>
                        </div> --}}
                        <div class="py-2 mt-3">
                            <h3 class="font-size-15 fw-bold">Order summary</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-nowrap" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width:10%">No.</th>
                                        <th style="width:45%">Item</th>
                                        <th style="width:15%" class="text-end">Unit Weight</th>
                                        <th style="width:15%" class="text-end">Qty</th>
                                        <th style="width:15%" class="text-end">Total Weight</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i=1;
                                    @endphp
                                    @foreach ($saleOrder->invoiceDetails as $detail)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $detail->item->category->name.'-'.$detail->item->name }}</td>
                                            <td class="text-end">{{ $detail->unit_weight }}</td>
                                            <td class="text-end">{{ $detail->total_quantity }}</td>
                                            <td class="text-end">{{ $detail->net_weight }}</td>
                                            
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td colspan="3">
                                            <b> Total</b>
                                         </td>
                                        <td style="text-align: right">
                                            <b>{{ number_format($saleOrder->invoiceDetails->sum('total_quantity'),2) }}</b>
                                        </td>
                                        <td style="text-align: right">
                                            <b>{{ number_format($saleOrder->invoiceDetails->sum('net_weight'),2) }}</b>
                                        </td>
                                        <td colspan="4" ></td>
                                       
                                       
                                    </tr>
                                  
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
    <!-- END: Content-->

@endsection
