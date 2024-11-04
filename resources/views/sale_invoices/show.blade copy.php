@extends('template.tmp')

@section('title', 'pagetitle')


@section('content')



    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->


                <div class="card">
                    <div class="card-body">
                       <div class="col-md-6">
                        <table width="100%" class="table">
                            <tr >
                                <th  class=""> Date</th>
                                <td>{{ $saleInvoice->date }}</td>

                                <th  class=""> Invoice No</th>
                                <td>{{ $saleInvoice->invoice_no }}</td>
                            </tr>
                           
                            <tr>
                                <th  class=""> Customer Name</th>
                                <td>{{ $saleInvoice->party->business_name }}</td>
                                
                                <th  class=""> Vehicle No</th>
                                <td>{{ $saleInvoice->vehicle_no }}</td>
                                
                            </tr>
                          
                        </table>
                       </div>
                    
                       
                        <table class="table table-bordered table-sm mt-3">
                            <tr>
                                <th class="text-center" width="50"></th>
                                <th class="text-center" width="150">Item</th> 
                                <th class="text-center" width="150">Unit Weight</th> 
                                <th class="text-center" width="150">Qty</th> 
                                <th class="text-center" width="150">Total Weight</th> 
                                <th class="text-center" width="150">Unit Price</th> 
                                <th class="text-center" width="150">Total Price</th> 
                                
                    
                            
                            </tr>
                            @php
                                $i=1;
                            @endphp
                            @foreach ($saleInvoice->invoiceDetails as $detail)
                               

                                <tr>
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $detail->item->name }}</td>
                                        <td class="text-end">{{ $detail->unit_weight }}</td>

                                        <td class="text-end">{{ $detail->total_quantity }}</td>
                                    
                                        <td class="text-end">{{ $detail->net_weight }}</td>
                                        <td class="text-end">{{ $detail->per_unit_price }}</td>
                                        
                                        
                                        
                                        <td class="text-end">{{ $detail->grand_total }}</td>
                                    </tr>
                                    
                                   

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
                                <td colspan="1" ></td>
                               
                                <td style="text-align: right">
                                    <b>{{ number_format($saleInvoice->invoiceDetails->sum('grand_total'),2) }}</b>
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>

            </div>
        </div>

    </div>
    </div>
    </div>
    <!-- END: Content-->

@endsection
