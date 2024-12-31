<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kohisar</title>
    <style type="text/css">
        .style1 {
            font-size: 20px
        }

        body,
        td,
        th {
            font-size: 12px;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>

    
        <div align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td colspan="2">
                        <div align="center" class="style1">{{ env('COMPANY_NAME') }} </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div align="center"><strong>Supplier Balance - {{ ucfirst(request()->balance_report_type) ?? '' }}</strong></div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">From {{ request()->startDate }} TO {{ request()->endDate }}</td>
                    <td width="50%">
                        <div align="right">DATED: {{ date('d-m-Y') }}</div>
                    </td>

                </tr>

            </table>
           
                <table width="100%" border="1" cellpadding="3" cellspacing="0" style="border-collapse:collapse;">
                    <thead>
                        <tr bgcolor="#CCCCCC">
                            <th width='10%' style="text-align:center;">CODE</th>
                            <th width='20%' style="text-align:center;">NAME</th>
                            <th width='20%' style="text-align:right;">DEBIT / PAYMENT</th>
                            
                        </tr>
                    </thead>
                    <tbody>     
                      
                            @foreach ($debitors as $journal)
                                <tr>
                                
                                    <td>{{ $journal->supplier->id ?? 'N/A' }}</td>
                                    <td>{{ $journal->supplier->business_name ?? 'N/A' }}</td>
                                    <td style="text-align:right;">{{  number_format($journal->total_debit - $journal->total_credit, 2)  }}</td>

                                </tr>
                            @endforeach
                    

                            <tr  bgcolor="#CCCCCC">

                                <td colspan="2"><b>TOTAL</b></td>
                               
                                <td style="text-align:right;font-weight:bold">
                                    {{ number_format($debitors->sum('total_debit') -  $debitors->sum('total_credit'), 2) }}
                                </td>
                                
                            </tr>
                        
                       
                    </tbody>
                </table>
                <br>
                <hr>
                <br>
                <table width="100%" border="1" cellpadding="3" cellspacing="0" style="border-collapse:collapse;">
                    <thead>
                        <tr bgcolor="#CCCCCC">
                            <th width='10%' style="text-align:center;">CODE</th>
                            <th width='20%' style="text-align:center;">NAME</th>
                            <th width='20%' style="text-align:right;">CREDIT / INVOICE</th>
                            
                        </tr>
                    </thead>
                    <tbody>     
                      
                            @foreach ($creditors as $journal)
                                <tr>
                                
                                    <td>{{ $journal->supplier->id ?? 'N/A' }}</td>
                                    <td>{{ $journal->supplier->business_name ?? 'N/A' }}</td>
                                    <td style="text-align:right;">{{  number_format($journal->total_debit - $journal->total_credit, 2)  }}</td>

                                </tr>
                            @endforeach
                    

                            <tr  bgcolor="#CCCCCC">

                                <td colspan="2"><b>TOTAL</b></td>
                                
                                <td style="text-align:right;font-weight:bold">
                                    {{ number_format($creditors->sum('total_debit') -  $creditors->sum('total_credit'), 2) }}
                                </td>
                                
                            </tr>
                        
                       
                    </tbody>
                </table>
            
        </div>
    
    
</body>

</html>



