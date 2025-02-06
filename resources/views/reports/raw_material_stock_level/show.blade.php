@extends('template.tmp')
@section('title', 'kohisar')

@section('content')
<style>
    /* Hide the default search box */
.dataTables_filter {
    display: none;
}
</style>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h3 class="mb-sm-0 font-size-18">Raw Materail Stock Report</h3>
                            <h4>Date FROM : {{ date('d-m-Y', strtotime($startDate)) .' - '.  date('d-m-Y', strtotime($endDate)) }}</h4>


                        </div>
                    </div>
                </div>
                <div class="">

                </div>
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified col-md-4" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab"  id="show-all" role="tab" aria-selected="true">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">All</span> 
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="hide-zero" role="tab" aria-selected="false" tabindex="-1">
                                    
                                    <span class="d-none d-sm-block">Hide Zero</span> 
                                </a>
                            </li>
                            
                           
                        </ul>
                       
                        <div class="card">

                            <div class="card-body">
                                <table id="table" class="table table-striped table-sm " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-start"  width="10%">#</th>
                                            <th class="text-start"  width="10%">NAME</th>
                                            <th class="text-end"  width="10%">OPENING BALANCE <sub>KG's</sub> </th>
                                            <th class="text-end"  width="10%">RECEIVED <sub>KG's</sub> </th>
                                            <th class="text-end"  width="10%">USAGE <sub>KG's</sub></th>
                                            <th class="text-end"  width="10%">CLOSING BALANCE <sub>KG's</sub></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $price = 0; $totalPrice =0; @endphp

                                        @foreach ($data as $value)
                                            
                                            @php
                                                $openingBalance = $value['receipts'] - $value['productions'];
                                                $received = $value['received'];
                                                $usage = $value['usage'];
                                                $closingBalance = $openingBalance + $received - $usage;
                                                $purchased_worth = $value['purchased_worth'];
                                                $purchased_net_wgt = $value['purchased_net_wgt'];
                                                
                                                $avg_unit_price = ($purchased_net_wgt != 0) ? $purchased_worth / $purchased_net_wgt : 0;
                                                @endphp

                                            <tr>
                                                <td class="text-start">{{ $loop->iteration }}</td>
                                                <td class="text-start">{{ $value['name'] }}</td>
                                                <td class="text-end">{{ number_format($openingBalance,2)  }}</td>
                                                <td class="text-end">{{ number_format($received, 2) }}</td>
                                                <td class="text-end">{{ number_format($usage, 2) }}</td>
                                                <td class="text-end balance">{{ number_format($closingBalance, 2) }}</td>
                                            </tr>
                                            
                                        @endforeach
                                        
                                    </tbody>
                                    {{-- <tfoot>
                                        <tr>
                                            <th colspan="2">Total</th>
                                            <th class="text-end">{{ $data->sum('qty_in') }}</th>
                                            <th class="text-end">{{ $data->sum('qty_out') }}</th>
                                            <th class="text-end">{{ $data->sum('balance') }}</th>
                                            <th></th>
                                            <th class="text-end">{{  number_format( $totalPrice, 2)  }}</th>
                                        </tr>
                                    </tfoot> --}}
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

  
      

    <script>
        // Hide rows with zero balance
        $('#hide-zero').on('shown.bs.tab', function () {
            $('.balance').each(function () {
                const value = parseFloat($(this).text()) || 0;
                if (value === 0) {
                    $(this).closest('tr').addClass('d-none');
                }
            });
        });

        $('#show-all').on('shown.bs.tab', function () {
            $('tr').removeClass('d-none');
        });

    </script>

 


    <!-- END: Content-->



    <script>
        $(document).ready(function() {
            $('#table thead tr').clone(true).appendTo('#table thead');
            $('#table thead tr:eq(1) th').each(function(i) {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="  ' + title +
                    '"  class="form-control form-control-sm" />');


                // hide text field from any column you want too
                if (title == 'Action') {
                    $(this).hide();
                }





                $('input', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });

            });
            var table = $('#table').DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                retrieve: true,
                paging: false

            });
        });
    </script>
@endsection
