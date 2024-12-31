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
                                <td>{{ $invoice_master->date }}</td>

                                <th  class=""> Receipt No</th>
                                <td>{{ $invoice_master->invoice_no }}</td>
                            </tr>
                           
                            <tr>
                                <th  class=""> Supplier Name</th>
                                <td>{{ $invoice_master->party->business_name }}</td>
                                
                                <th  class=""> Vehicle No</th>
                                <td>{{ $invoice_master->vehicle_no }}</td>
                                
                            </tr>
                            <tr>
                                <th>Reference No</th>
                                <td>{{  $invoice_master->reference_no }}</td>
                            </tr>
                          
                        </table>
                       </div>
                    
                       
                        <table class="table table-bordered table-sm mt-3">
                            <tr class="bg-light">
                                
                                <th class="text-center" width="150">Item</th> 
                                <th class="text-center" width="100">
                                    Gross wgt <i class="bx bxs-help-circle mr-1" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Total Weight in KG's"></i> 
                                </th>
                                
                                <th class="text-center" width="50">Cut(%)</th>
                                <th class="text-center" width="100">
                                    Cut Value <i class="bx bxs-help-circle mr-1" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="( cut% / 100 ) x gross wgt"></i>
                                </th>
                                <th class="text-center" width="100">
                                    After Cut <i class="bx bxs-help-circle mr-1" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="gross wgt - cut value"></i>
                                </th>


                                <th class="text-center" width="100">Total Bags </th>
                                <th class="text-center" width="100">Per Empty <br> bag  wgt</th>
                                <th class="text-center" width="100">Total Empty <br> bag wgt</th>
                                <th class="text-center" width="100">
                                    Net wgt <i class="bx bxs-help-circle mr-1" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="gross wgt - (after cut + Total Empty bag wgt )">
                                </th>



                                <th class="text-center" width="100">Per Kg Price <br>Supplier</th>
                                <th class="text-center" width="100">Total Price <br>Supplier</th>
                                <th class="text-center" width="100">Per Kg Price <br>Stock</th>
                                <th class="text-center" width="100">Total Price <br>Stock</th>
                                

                            </tr>
                            @foreach ($invoice_detail as $detail)
                               

                                <tr>
                                    <tr>
                                        <td>{{ $detail->item->name }}</td>
                                        <td class="text-end" >{{ $detail->gross_weight }}</td>

                                        
                                    
                                        @if($detail->cut_percentage > 0)
                                            <td>{{ $detail->cut_percentage }}</td>
                                            <td>{{ $detail->cut_value }}</td>
                                            <td>{{ $detail->after_cut_total_weight }}</td>
                                        @else
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        @endif

                                        <td class="text-end">{{ $detail->total_quantity }}</td>
                                        <td class="text-end">{{ $detail->per_package_weight }}</td>
                                        <td class="text-end">{{ $detail->total_package_weight }}</td>
                                        <td class="text-end">{{ $detail->net_weight }}</td>
                                        
                                        {{-- 
                                            The old value is stored when a new record is inserted.
                                            If new fields are added during record editing, the old value will be null.
                                        --}}
                                        <td class="text-end"> 

                                            @php
                                                $current = $detail->per_unit_price;
                                                $old = $detail->per_unit_price_old_value;
                                                $new = $detail->per_unit_price_new_value;
                                            @endphp

                                            {{-- 
                                            
                                                Create : new will be null
                                                update the price: will add value in new column and old will be retain in old column
                                                add new item in edit: old will be null
                                            --}}

                                            @if($new == NULL)
                                                {{ $detail->per_unit_price }}
                                            
                                            @elseif($old == NULL)
                                                <span class="text-warning" >{{ $detail->per_unit_price }}</span> 
                                            
                                            @elseif($old != $new)
                                                <span class="text-danger text-decoration-line-through" >{{ $detail->per_unit_price_old_value }}</span>  
                                                {{ $detail->per_unit_price }}
                                            @else    
                                            {{ $detail->per_unit_price }}

                                            @endif
                                            
                                        </td> 
                                        <td class="text-end">{{ $detail->total_price }}</td>


                                        <td class="text-end">{{ $detail->per_unit_price_stock }}</td>
                                        <td class="text-end">{{ $detail->total_price_stock }}</td>
                                    </tr>
                                    
                                   
                                    

                                </tr>
                               
                            @endforeach
                            <tr>
                                <td colspan="5">
                                    <b> Total</b>
                                 </td>
                                <td style="text-align: right">
                                    <b>{{ number_format($invoice_detail->sum('total_quantity'),2) }}</b>
                                </td>
                                <td colspan="4" ></td>
                               
                                <td style="text-align: right">
                                    <b>{{ number_format($invoice_detail->sum('grand_total'),2) }}</b>
                                </td>
                            </tr>
                        </table>
                    </div>



                    <div class="row m-3">
                        <div class="col-md-8">
                            @if($invoice_master->description != '')
                                <label for="form-label">Descripion</label> <br>
                           
                                  {!! $invoice_master->description  !!}  
                            @endif
                          
                        </div>
                        
                        <div class="col-md-4 d-flex align-items-center">
                            <table id="summary-table" class="table">
                                <tr>
                                    <th class="text-end" width="50%">Sub Total Booked in Supplier</th>
                                    <td class="text-end"  width="50%">
                                       {{ $invoice_master->sub_total }}
                                    </td>
                                </tr>  
                                <tr>
                                    <th class="text-end" width="50%">Sub Total Booked in Stock</th>
                                    <td class="text-end"  width="50%">
                                       {{ $invoice_master->sub_total_stock }}
                                    </td>
                                </tr>  
                            
                                <tr>
                                    <th class="text-end">Freight </th>
                                    <td>
                                        <input type="hidden" name="is_x_freight" id="is-x-freight" value="0" readonly>
                                        <div class="row">
                                            <div class="col-md-6 text-center">
                                                <label class="label mx-1">X</label>
                                                <input type="checkbox" @checked($invoice_master->is_x_freight == 1)  disabled>

                                            </div>
                                            <div class="col-md-6 text-end">
                                                {{ $invoice_master->shipping  }}

                                            </div>
                                        </div>         
                                    </td>
                                </tr>
                                <tr class="text-end">
                                    <th width="50%">Total Bags</th>
                                    <td width="50%">
                                        <div class="row">
                                            <div class="col-md-6">
                                               {{ $invoice_master->bag_type_name }}
                                            </div>
                                            <div class="col-md-6">
                                                {{ $invoice_master->total_bags }}

                                            </div>
                                        </div>
                                    </td>
                                </tr>  

                                <tr >
                                    <th class="text-end"  width="50%">Grand Total</th>
                                    <td class="text-end"  width="50%">
                                        {{ $invoice_master->grand_total }}
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
    </div>
    <!-- END: Content-->

@endsection
