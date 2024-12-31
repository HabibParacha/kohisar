<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kohisar</title>
    <style type="text/css">
        html {
            margin: 0.25rem;
        }  
        body,td,th {
            font-size: 12px;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>

    
        <table style="border-collapse:collapse;" width="100%" border="0">
           <thead>
                <tr>
                    <td width="33%" align="left"><b>From {{ request()->startDate }} TO {{ request()->endDate }}</b></td>
                    <td width="33%" align="center"><b></b></td>
                    <td width="33%" align="right"><b>DATED: {{ date('d-m-Y') }}</b></td>
                </tr> 
           </thead>
        </table>
        <br>
        <table width="100%" border="1" cellpadding="3" cellspacing="0" style="border-collapse:collapse;">
            <thead>
                <tr bgcolor="#CCCCCC">
                    <th width="1%"></th> 
                    <th width="8%"><small>Name</small></th> 
                    <th width="5%">Date</th> 
                    <th width="5%">Invoice No</th> 
                    <th width="60%">
                        <table width="100%" border="0" cellpadding="1" cellspacing="0" style="border-collapse:collapse;">
                            
                                <tr>
                                    <th style="text-align:left" width="15%">Item</th> 
                                    <th style="text-align:right" width="10%">Gross Wgt</th> 
                                    <th style="text-align:right" width="7%"><small>Cut %</small></th> 
                                    <th style="text-align:right" width="7%"><small>Cut  Val.</small></th> 
                                    <th style="text-align:right" width="10%"><small>Cut Wgt.</small></th> 
                                    <th style="text-align:right" width="7%">Price</th> 
                                    <th style="text-align:right" width="6%"><small>No. <br>Bags </small></th> 
                                    <th style="text-align:right" width="10%">Bag Wgt</th> 
                                    <th style="text-align:right" width="10%">Total Wgt</th> 
                                    <th style="text-align:right" width="13%">Net Weight</th> 
                                </tr>
                            
                        </table>
                    </th>
                    {{-- <th width="65%">Detail</th> --}}
                    <th width="4%">Vehicle</th>
                    <th width="6%">Shippig</th>
                    <th width="7%">Total</th>
                    
                    
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $value )
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->party->business_name }}</td>
                        <td>{{ date('d-m-y', strtotime($value->date)) }}</td>
                        <td>{{ $value->invoice_no }}</td>
                        <td>
                            
                            <table width="100%" border="0" cellpadding="1" cellspacing="0" style="border-collapse:collapse;">
                              
                                @foreach ($value->invoiceDetails as $detail)
                                <tr>
                                    <td width="15%"  style="text-align: left">{{ $detail->item->name}}</td>
                                    <td width="10%"  style="text-align: right">{{ $detail->gross_weight}}</td>
                                    @if($detail->cut_value > 0 )
                                    <td width="7%" style="text-align: right">{{ $detail->cut_percentage }}</td>
                                    <td width="7%" style="text-align: right">{{ $detail->cut_value }}</td>
                                    <td width="10%" style="text-align: right"> {{ $detail->after_cut_total_weight }}</td>
                                    @else
                                    <td width="7%" style="text-align: right">-</td>
                                    <td width="7%" style="text-align: right">-</td>
                                    <td width="10%" style="text-align: right">-</td>
                                    @endif
                                    <td width="7%" style="text-align: right"> {{ $detail->per_unit_price }}</td>
                                    <td width="6%" style="text-align: right">{{ number_format($detail->total_quantity,0) }}</td>
                                    <td width="10%" style="text-align: right">{{ $detail->per_package_weight }}</td>
                                    <td width="10%" style="text-align: right">{{ $detail->total_package_weight }}</td>
                                    <td width="13%" style="text-align: right">{{ $detail->net_weight }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                        <td style="text-align: left">{{ $value->vehicle_no }}</td>
                        <td style="text-align: right">{{ number_format($value->shipping,0) }}</td>
                        <td style="text-align: right">{{ number_format($value->grand_total,0) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color:red" >No data found</td>
                    </tr>
                
                
                @endforelse
            </tbody>
        </table>
    
</body>

</html>



