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
                                <h4 class="card-title mb-4 text-primary">Expense Voucher #: {{ $expense->expense_no }}</h4>
                    
                                <div class="row gy-3">
                                    <!-- Left Column (Description) -->
                                    <div class="col-md-8">
                                        <label class="form-label fw-bold">Description</label>
                                        <div class="form-control-plaintext">{{ $expense->description }}</div>
                                    </div>
                                
                                    <!-- Right Column (Date, Supplier, Paid By) -->
                                    <div class="col-md-4">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th class="text-end">Date</th>
                                                <td class="text-end">{{ date('d-m-Y', strtotime($expense->date)) }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-end">Supplier</th>
                                                <td class="text-end">{{ $expense->party->business_name }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-end">Paid By</th>
                                                <td class="text-end" class="form-control-plaintext">{{ $expense->chartOfAccount->account_name }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                </div>
                                
                                <!-- Expense Details Table -->
                                <div class="table-responsive mt-4">
                                    <table id="table" class="table table-hover table-striped align-middle">
                                        <thead class="table-dark">
                                            <tr>
                                                <th scope="col" width="50px">#</th>
                                                <th scope="col" width="150px">Account Name</th> 
                                                <th scope="col" width="300px">Description</th> 
                                                <th scope="col" width="100px">Tax Rate (%)</th> 
                                                <th scope="col" width="150px" class="text-end">Exclusive Value</th> 
                                                <th scope="col" width="150px" class="text-end">{{ __('tax.name') }}</th> 
                                                <th scope="col" width="150px" class="text-center">Inclusive Value</th> 
                                            </tr>
                                        </thead>
                                        <tbody id="sortable-table">
                                            @foreach ($expense->details as $detail)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $detail->chartOfAccount->account_name }}</td> 
                                                    <td>{{ $detail->description }}</td> 
                                                    <td>{{ $detail->tax_percentage }}%</td> 
                                                    <td class="text-end">{{ number_format($detail->amount_exclusive_tax, 2) }}</td> 
                                                    <td class="text-end">{{ number_format($detail->calculated_tax_amount, 2) }}</td> 
                                                    <td class="text-end">{{ number_format($detail->amount_inclusive_tax, 2) }}</td> 
                                                </tr>
                                            @endforeach
                                           
                                        </tbody>
                                        <!-- Expense Summary -->
                                        
                                    </table>
                                </div>
                                <div class="col-md-8 offset-md-4">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th class="text-end">Subtotal</th>
                                            <td class="text-end">{{ number_format($expense->details->sum('amount_exclusive_tax'), 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-end">Total Tax:</th>
                                            <td class="text-end">{{ number_format($expense->details->sum('calculated_tax_amount'), 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-end">Total Inclusive Value:</th>
                                            <td class="text-end" class="form-control-plaintext">{{ number_format($expense->details->sum('amount_inclusive_tax'), 2) }}</td>
                                        </tr>
                                    </table>
                                </div>

                                {{-- <tfoot class="p-1">
                                    <tr class="">
                                        <td colspan="6" class="text-end fw-bold border-0">Subtotal:</td>
                                        <td colspan="3" class="text-end border-0"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="text-end fw-bold border-0">Total Tax:</td>
                                        <td colspan="3" class="text-end border-0"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="text-end fw-bold border-0">Total Inclusive Value:</td>
                                        <td colspan="3" class="text-end border-0">{{ number_format($expense->details->sum('amount_inclusive_tax'), 2) }}</td>
                                    </tr>
                                </tfoot> --}}
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
            
         </div>
    </div>

    

   


    


@endsection
