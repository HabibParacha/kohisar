
@extends('template.tmp')
@section('title', 'kohisar')

@section('content')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


<div class="main-content">
    <div class="page-content">
        <div class="container-fluid ">
            <!-- Single Card for Expense Voucher -->
            <div class="row">
                
                @foreach ($categories as $category)
                    <div class="col-md-6 ">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h4 class="card-title mb-4 text-primary">{{ $category->name }}</h4>

                                @php
                                    $productions = DB::table('v_production_output_items')
                                    ->whereBetween('date', [$startDate,$endDate])
                                    ->where('category_id', $category->id)
                                    ->get()
                                @endphp

                                <div class="table-responsive mt-4">
                                    <table id="table" class="table table-hover table-striped align-middle">
                                        @if ($productions->isNotEmpty())   

                                            <thead class="table-dark">
                                                <tr>
                                                    <th width="5"></th> 
                                                    <th width="100">PROD.</th> 
                                                    <th width="100">Item</th> 
                                                    <th class="text-center" width="100">Unit wgt.</th> 
                                                    <th class="text-center" width="50">Bags Qty.</th> 
                                                    <th class="text-center" width="150">Total wgt.</th> 
                                                    <th class="text-center" width="100">Unit Price</th>
                                                    <th class="text-center" width="150">Total</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($productions as $detail)
                                                    <tr>
                                                        <td class="text-end">
                                                            @if($detail->is_surplus == 1)
                                                            <span class="badge rounded-pill bg-primary mx-2 ">S</span>
                                                            @endif  
                                                        </td>
                                                        <td class="text-end"> {{ $detail->invoice_no}}</td>
                                                        <td class="text-end"> {{ $detail->name}}</td>
                                                    
                                                        <td class="text-center">{{ number_format($detail->unit_weight, 0) }}</td> 
                                                        
                                                        <td class="text-end">{{ number_format($detail->total_quantity, 0) }} </td> 
                                                        <td class="text-end"> {{ number_format($detail->net_weight, 2) }}</td> 
                                                        <td class="text-end"> {{ number_format($detail->per_unit_price, 2) }}</td>
                                                        <td class="text-end"> {{ number_format($detail->grand_total, 2) }}</td>
                                                        
                                                    </tr>
                                                @endforeach
                                                
                                            </tbody>
                                            <tfoot>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="fw-bold text-end">{{ number_format($productions->sum('total_quantity'),0) }}</td>
                                                <td class="fw-bold text-end">{{ number_format($productions->sum('net_weight'),2) }}</td>
                                                <td></td>
                                                <td class="fw-bold text-end">{{ number_format($productions->sum('grand_total'),2) }}</td>
                                            </tfoot>
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center fw-bold text-danger mt-5">No Output ...</td>

                                            </tr>
                                        @endif        
                                    </table>
                                </div>
                            </div>

                            
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>



@endsection