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
            <div class="container-fluid">
               
                <!-- start page title -->
                <form id="finished-goods-stock-store" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Finished Goods Stock Opening Balance</h4>

                       
                        </div> 
                    </div>
                 

                    <div class="card">
                      
                        <div class="card-body">
                            <h4 class="card-title mb-4">Invoice Details</h4>
                            <div class="table-responsive">
                                <table id="table" class="table table-border" style="border-collapse:collapse;">
                                    <thead>
                                        <tr>
                                            <th  width="10" class="text-start" ></th>
                                            <th  width="200" class="text-start" >Item</th> 
                                            <th  width="50" class="text-center">Unit wgt.</th> 
                                            <th  width="50" class="text-center">Qty</th> 
                                            <th  width="100" class="text-center">Total  wgt.</th> 
                                         
                                            <th class="text-center" width="20"></th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody id="sortable-table">
                                        @foreach ($data->invoiceDetails as $detail)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $detail->item->category->name.'-'.$detail->item->name }}</td>
                                            <td class="text-end">{{ $detail->unit_weight }}</td>
                                            <td class="text-end">{{ $detail->total_quantity }}</td>
                                            <td class="text-end">{{ $detail->net_weight }}</td>
                                        </tr>
                                    @endforeach

                        
                                       
                                    </tbody> 
                                </table>

                            </div> 
                           

                        

                        </div>

                    </div>
                  
                    

                </form>       
             
            </div>
         </div>
    </div>







@endsection
