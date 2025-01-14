@extends('template.tmp')
@section('title', 'kohisar')

@section('content')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid ">
            <!-- Single Card for Expense Voucher -->
            <div class="row">
                
                @foreach ($data as $categoryData)
                    <h3>{{ $categoryData['category_name'] }}</h3>

                    <div class="col-md-12 ">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h4 class="card-title mb-4 text-primary"></h4>
                                <div class="table-responsive mt-4">
                                    <table id="table" class="table table-hover table-striped align-middle">
                                        <thead class="table-dark">
                                            <tr>
                                                <th width="5"></th> 
                                                <th width="100">Name</th> 
                                                <th width="100">Code</th> 
                                                {{-- <th width="100">Category</th>  --}}
                                                <th width="100">Opening Stock</th> 
                                                <th width="100">Production</th> 
                                                <th width="100">Total</th> 
                                                <th width="100">Bags Issued</th> 
                                                <th width="100">Closing Stock</th> 
                                                <th width="100">Cumulative Sales</th> 
                                                <th width="100">Cumulative Production</th> 
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($categoryData['items'] as $item)
                                            @php
                                            $opeing_stock = 0;
                                            $total = 0;
                                            $closing_stock = 0;
                                        
                                            // Calculate opening stock
                                            $opeing_stock = $item['before_start_date_production'] - $item['before_start_date_sales'];
                                        
                                            // Round the opening stock to 2 decimal places
                                            $opeing_stock = round($opeing_stock, 0);
                                        
                                            // Calculate total
                                            $total = $item['between_dates_production'] + $opeing_stock;
                                        
                                            // Round the total to 2 decimal places
                                            $total = round($total, 0);
                                        
                                            // Calculate closing stock
                                            $closing_stock = $total - $item['between_dates_sales'];
                                        
                                            // Round the closing stock to 2 decimal places
                                            $closing_stock = round($closing_stock, 2);
                                        @endphp
                                        
                                            <tr>
                                                <td></td>
                                                <td>{{ $item['name'] }}</td>
                                                <td>{{ $item['code'] }}</td>
                                                {{-- <td>{{ $item['category'] }}</td> --}}
                                                <td class="text-end">{{ ($opeing_stock > 0) ? number_format($opeing_stock, 0) : '-' }}</td>
                                                <td class="text-end">{{ number_format($item['between_dates_production'], 0) }}</td>
                                                <td class="text-end">{{ number_format($total, 0) }}</td>
                                                <td class="text-end">{{ number_format($item['between_dates_sales'], 0) }}</td>
                                                <td class="text-end">{{ number_format($closing_stock, 0) }}</td>
                                                <td class="text-end">{{ number_format($item['cumulative_sale'], 0) }}</td>
                                                <td class="text-end">{{ number_format($item['cumulative_prod'], 0) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>

                                        <tfoot>
                                            @php
                                                // Sum up the required fields using sum()
                                                $sumBeforeStartDateProduction = collect($categoryData['items'])->sum('before_start_date_production');
                                                $sumBeforeStartDateSales = collect($categoryData['items'])->sum('before_start_date_sales');
                                                $sumBetweenDatesProduction = collect($categoryData['items'])->sum('between_dates_production');
                                                $sumBetweenDatesSales = collect($categoryData['items'])->sum('between_dates_sales');
                                                $sumCumulativeSale = collect($categoryData['items'])->sum('cumulative_sale');
                                                $sumCumulativeProd = collect($categoryData['items'])->sum('cumulative_prod');

                                                // Calculate opening stock, total, and closing stock totals
                                                $sumOpeningStock = $sumBeforeStartDateProduction - $sumBeforeStartDateSales;
                                                $sumTotal = $sumBetweenDatesProduction + $sumOpeningStock;
                                                $sumClosingStock = $sumTotal - $sumBetweenDatesSales;
                                            @endphp

                                            <tr>
                                                <td colspan="3" class="text-end"><strong>Total for {{ $categoryData['category_name'] }}</strong></td>
                                                <td class="text-end">{{ ($sumOpeningStock > 0) ? number_format($sumOpeningStock) : '-' }}</td>
                                                <td class="text-end">{{ number_format($sumBetweenDatesProduction) }}</td>
                                                <td class="text-end">{{ number_format($sumTotal) }}</td>
                                                <td class="text-end">{{ number_format($sumBetweenDatesSales) }}</td>
                                                <td class="text-end">{{ number_format($sumClosingStock) }}</td>
                                                <td class="text-end">{{ number_format($sumCumulativeSale) }}</td>
                                                <td class="text-end">{{ number_format($sumCumulativeProd) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Total Summary for All Categories -->
                <div class="col-md-12 ">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4 class="card-title mb-4 text-primary">Total Summary for All Categories</h4>
                            <div class="table-responsive mt-4">
                                <table id="summary-table" class="table table-hover table-striped align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-start" width="100">Total Opening Stock</th> 
                                            <th class="text-end" width="100">Total Production</th> 
                                            <th class="text-end" width="100">Total</th> 
                                            <th class="text-end" width="100">Total Bags Issued</th> 
                                            <th class="text-end" width="100">Total Closing Stock</th> 
                                            <th class="text-end" width="100">Total Cumulative Sales</th> 
                                            <th class="text-end" width="100">Total Cumulative Production</th> 
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                            // Initialize totals for all categories
                                            $grandTotalOpeningStock = 0;
                                            $grandTotalProduction = 0;
                                            $grandTotal = 0;
                                            $grandTotalBagsIssued = 0;
                                            $grandTotalClosingStock = 0;
                                            $grandTotalCumulativeSales = 0;
                                            $grandTotalCumulativeProduction = 0;

                                            // Loop through all categories and sum up the totals
                                            foreach ($data as $categoryData) {
                                                $grandTotalOpeningStock += collect($categoryData['items'])->sum('before_start_date_production') - collect($categoryData['items'])->sum('before_start_date_sales');
                                                $grandTotalProduction += collect($categoryData['items'])->sum('between_dates_production');
                                                $grandTotal += collect($categoryData['items'])->sum('between_dates_production') + ($grandTotalOpeningStock);
                                                $grandTotalBagsIssued += collect($categoryData['items'])->sum('between_dates_sales');
                                                $grandTotalClosingStock += $grandTotal - $grandTotalBagsIssued;
                                                $grandTotalCumulativeSales += collect($categoryData['items'])->sum('cumulative_sale');
                                                $grandTotalCumulativeProduction += collect($categoryData['items'])->sum('cumulative_prod');
                                            }
                                        @endphp

                                        <tr>
                                            <td class="text-start">{{ number_format($grandTotalOpeningStock) }}</td>
                                            <td class="text-end">{{ number_format($grandTotalProduction) }}</td>
                                            <td class="text-end">{{ number_format($grandTotal) }}</td>
                                            <td class="text-end">{{ number_format($grandTotalBagsIssued) }}</td>
                                            <td class="text-end">{{ number_format($grandTotalClosingStock) }}</td>
                                            <td class="text-end">{{ number_format($grandTotalCumulativeSales) }}</td>
                                            <td class="text-end">{{ number_format($grandTotalCumulativeProduction) }}</td>
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

<script>
    $(document).ready(function () {
        // Optional: Add any jQuery functionality here if needed
    });
</script>

@endsection
