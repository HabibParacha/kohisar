@extends('template.tmp')
@section('title', 'kohisar')

@section('content')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>
    /* Chrome, Safari, Edge, Opera : remove spin input type number*/
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
      

    }

    .table>:not(caption)>*>* {
    padding: 0.15rem .15rem !important;
    }

    table tbody tr input.form-control{
    
        border-radius: 0rem !important;
        font-size: 11px;
    
    }

    #summary-table input.form-control{
        /* border: 0; */
        border-radius: 0.25rem !important;
    }

    .form-control:disabled, .form-control[readonly] {
    background-color: #eff2f780 !important;
    opacity: 1;
}

</style>
<style>
    .ui-state-highlight {
        height: 40px;
        background-color: #f0f0f0;
    }
</style>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid ">
                <!-- Single Card for Expense Voucher -->
                <div class="row">
                    <div class="col-md-12 ">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <!-- Expense Header -->
                                <h4 class="card-title mb-4 text-primary">Production #: {{ $production->invoice_no }}</h4>
                    
                                <div class="row gy-3">
                                    <!-- Left Column (Description) -->
                                    <div class="col-md-8">
                                        <label class="form-label fw-bold">Description</label>
                                        <div class="form-control-plaintext">{{ $production->description }}</div>
                                    </div>
                                
                                    <!-- Right Column (Date, Supplier, Paid By) -->
                                    <div class="col-md-4">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th class="text-end">Date</th>
                                                <td class="text-end">{{ date('d-m-Y', strtotime($production->date)) }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-end">Expiry Date</th>
                                                <td class="text-end">{{date('d-m-Y', strtotime($production->expiry_date)) }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-end">Total Tons</th>
                                                <td class="text-end" class="form-control-plaintext">{{ number_format($production->production_material_tons,2) }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                </div>
                                
                                <!-- Production Details Table -->
                                
                                

                              
                            </div>
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-md-7 ">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h4 class="card-title mb-4 text-primary">Output</h4>

                                
                                <div class="table-responsive mt-4">
                                    <table id="table" class="table table-hover table-striped align-middle">
                                        <thead class="table-dark">
                                            <tr>
                                                {{-- <th width="20">#</th> --}}
                                                <th width="5"></th> 
                                                <th width="100">Item</th> 
                                                <th width="100">Category</th> 
                                                <th class="text-center" width="100">Unit wgt.</th> 
                                                <th class="text-center" width="50">Bags Qty.</th> 
                                                <th class="text-center" width="150" class="">Total wgt.</th> 
                                                <th class="text-center" width="100">Unit Price</th>
                                                <th class="text-center" width="150">Total</th>
                                                
                                            </tr>
                                        </thead>


                                        
                                        @if ($production->outputDetails->isNotEmpty())   
                                            <tbody>
                                                @foreach ($production->outputDetails as $detail)
                                                    <tr>
                                                        {{-- <td class="text-right">{{ $loop->iteration }}</td> --}}
                                                        <td class="text-right">
                                                            @if($detail->is_surplus == 1)
                                                            <span class="badge rounded-pill bg-primary mx-2 ">S</span>
                                                            @endif  
                                                        </td>
                                                        <td class="text-right"> {{ $detail->item->name}}</td>
                                                        <td class="text-right">{{ $detail->item->category->name }}</td>
                                                    
                                                        <td class="text-center">{{ number_format($detail->unit_weight, 0) }}</td> 
                                                       
                                                        <td class="text-center">{{ number_format($detail->total_quantity, 0) }} </td> 
                                                        <td class="text-center"> {{ number_format($detail->net_weight, 2) }}</td> 
                                                        <td class="text-center"> {{ number_format($detail->per_unit_price, 2) }}</td>
                                                        <td class="text-end"> {{ number_format($detail->grand_total, 2) }}</td>
                                                       
                                                    </tr>
                                                @endforeach
                                                
                                            </tbody>
                                            <tfoot>
                                                {{-- <td></td> --}}
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="fw-bold text-center">{{ number_format($production->outputDetails->sum('total_quantity'),2) }}</td>
                                                <td class="fw-bold text-center">{{ number_format($production->outputDetails->sum('net_weight'),2) }}</td>
                                                <td></td>
                                                <td class="fw-bold text-end">{{ number_format($production->outputDetails->sum('grand_total'),2) }}</td>
                                            </tfoot>
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center fw-bold text-danger mt-5">output not added yet</td>

                                            </tr>
                                        @endif        
                                            
                                    </table>
                                </div>
                               
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 ">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h4 class="card-title mb-4 text-primary">Comsumption of Raw Items</h4>

                              
                                <div class="table-responsive mt-4">
                                    <table id="table" class="table table-hover table-striped align-middle">
                                        <thead class="table-dark">
                                            <tr>
                                                <th width="20">#</th>
                                                <th width="200">Item Name</th> 
                                                <th width="200" class="text-center">Comsumed </th> 
                                                <th width="200" class="text-center">Unit Cost </th> 
                                                <th width="200" class="text-center">Total</th> 
                                                
                                            </tr>
                                        </thead>
                                        <tbody >
                                            @foreach ($production->productionDetails as $detail)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $detail->item->name }}</td>
                                                    <td class="text-center">{{ number_format($detail->net_weight, 2) }}</td> 
                                                    <td class="text-center">{{ number_format($detail->per_unit_price, 2) }}</td> 
                                                    <td class="text-end">{{ number_format($detail->grand_total, 2) }}</td> 
                                                
                                                </tr>
                                            @endforeach
                                        
                                        </tbody>
                                        <tfoot>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center fw-bold">{{ number_format($production->productionDetails->sum('net_weight'),2) }}</td>
                                            <td></td>
                                            <td class="text-end fw-bold">{{ number_format($production->productionDetails->sum('grand_total'),2) }}</td>
                                        </tfoot>
                                        <!-- Expense Summary -->
                                        
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
