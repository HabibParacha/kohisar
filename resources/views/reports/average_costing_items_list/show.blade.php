@extends('template.tmp')
@section('title', 'Raw Material Average Price List')

@section('content')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid ">
               
                <div class="card">
                    <div class="tab-content p-1 text-muted">
                        <div class="tab-pane active" id="home1" role="tabpanel">
                            <div class="table-responsive" style="max-height: 700px;">
                                <table id="table" class="table table-sm">
                                    <thead class="table-dark sticky-top" style="z-index: 1;">
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
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
                                                <td>{{ $value['name'] }}</td>
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
