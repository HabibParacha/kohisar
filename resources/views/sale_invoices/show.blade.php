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
                            <h4 class="float-end font-size-16">Date: {{ date('d-m-Y',strtotime($saleInvoice->date)) }}</h4>
                            <div class="auth-logo mb-4">
                                {{-- <img src="assets/images/logo-dark.png" alt="logo" class="auth-logo-dark" height="20">
                                <img src="assets/images/logo-light.png" alt="logo" class="auth-logo-light" height="20"> --}}
                                <h4># {{ $saleInvoice->invoice_no }}</h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <address>
                                    <h5>Billed To:</h5><br>
                                   <span class="fw-bold">Customer: </span>  {{ $saleInvoice->party->business_name }}<br>
                                   <span class="fw-bold">Contact: </span> {{ $saleInvoice->party->mobile}}<br>
                                   <span class="fw-bold">City: </span> {{  $saleInvoice->party->city  }}<br>
                                   <span class="fw-bold">Address: </span>{{  $saleInvoice->party->address_line_1 }}
                                </address>
                            </div>
                            <div class="col-sm-6 text-sm-end">
                                <address class="mt-2 mt-sm-0">
                                   
                                    <h5>Shipped To:</h5><br>
                                    <span class="fw-bold">City: </span> {{ $saleInvoice->partyWarehouse->city }}<br>
                                    <span class="fw-bold">Farm: </span> {{ $saleInvoice->partyWarehouse->name }}<br>
                                    <span class="fw-bold">Address: </span>{{ $saleInvoice->partyWarehouse->location }}
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
                            <table class="table table-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 70px;">No.</th>
                                        <th style="width: 200px;">Item</th>
                                        <th style="width: 70px;" class="text-end">Unit Weight</th>
                                        <th style="width: 70px;" class="text-end">Qty</th>
                                        <th style="width: 70px;" class="text-end">Total Weight</th>
                                        <th style="width: 70px;" class="text-end">Retail Price</th>
                                        <th style="width: 70px;" class="text-end">Discout Price</th>
                                        <th style="width: 70px;" class="text-end">Before Discount</th>
                                        <th style="width: 70px;" class="text-end">After Discount</th>
                                        <th style="width: 70px;" class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i=1;
                                    @endphp
                                    @foreach ($saleInvoice->invoiceDetails as $detail)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $detail->item->category->name.'-'.$detail->item->name }}</td>
                                            <td class="text-end">{{ $detail->unit_weight }}</td>
                                            <td class="text-end">{{ $detail->total_quantity }}</td>
                                            <td class="text-end">{{ $detail->net_weight }}</td>
                                            <td class="text-end">{{ $detail->per_unit_price }}</td> 
                                            <td class="text-end">{{ $detail->discount_value }}</td> 
                                            <td class="text-end">{{ $detail->total_price }}</td>
                                            <td class="text-end">{{ $detail->after_discount_total_price }}</td> 
                                            <td class="text-end">{{ $detail->after_discount_total_price }}</td> 
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td colspan="3">
                                            <b> Total</b>
                                         </td>
                                        <td style="text-align: right">
                                            <b>{{ number_format($saleInvoice->invoiceDetails->sum('total_quantity'),2) }}</b>
                                        </td>
                                        <td style="text-align: right">
                                            <b>{{ number_format($saleInvoice->invoiceDetails->sum('net_weight'),2) }}</b>
                                        </td>
                                        <td colspan="4" ></td>
                                       
                                        <td style="text-align: right">
                                            <b>{{ number_format($saleInvoice->invoiceDetails->sum('grand_total'),2) }}</b>
                                        </td>
                                    </tr>
                                    
                                   

                                    <tr>
                                        <td colspan="9" class="text-end">Sub Total</td>
                                        <td class="text-end">{{ number_format($saleInvoice->invoiceDetails->sum('total_price'),2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="9" class="text-end">Discount (-)</td>
                                        <td class="text-end">{{ number_format($saleInvoice->invoiceDetails->sum('discount_amount'),2) }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <td colspan="2" class="border-0 text-end">
                                            <strong>Shipping</strong></td>
                                        <td class="border-0 text-end">$13.00</td>
                                    </tr> --}}
                                    <tr>
                                        <td colspan="9" class="border-0 text-end">
                                            <strong>Total</strong></td>
                                        <td class="border-0 text-end"><h4 class="m-0">{{ number_format($saleInvoice->invoiceDetails->sum('grand_total'),2) }}</h4></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {{-- <div class="d-print-none">
                            <div class="float-end">
                                <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i></a>
                                <a href="javascript: void(0);" class="btn btn-primary w-md waves-effect waves-light">Send</a>
                            </div>
                        </div> --}}
                    </div>
                </div>

            </div>
        </div>

    </div>
    </div>
    </div>
    <!-- END: Content-->

@endsection
