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
                        <div align="center"><strong>Expense Report</strong></div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">From {{ request()->startDate }} TO {{ request()->endDate }}</td>
                    <td width="50%">
                        <div align="right">DATED: {{ date('d-m-Y') }}</div>
                    </td>

                </tr>

            </table>

           
                <table width="100%" border="1" cellpadding="3" cellspacing="0" style="border-collapse:collapse;margin-top:5px">
                    <tbody>
                        <tr bgcolor="#CCCCCC">
                            <th width='5%' style="text-align:center;">#</th>
                            <th width='15%' style="text-align:center;">DATE</th>
                            <th width='15%' style="text-align:center;">EXPENSE NO</th>
                            <th width='25%' style="text-align:center;">SUPPLIER</th>
                            <th width='25%' style="text-align:center;">ACCOUNT</th>
                            <th width='10%' style="text-align:center;">TAX</th>
                            <th width='15%' style="text-align:center;">AMOUNT</th>
                            
                        </tr>
                    </tbody>
                    <tbody>     
                        @if($expenses->isNotEmpty())
                      
                            @foreach ($expenses as $expense)
                                <tr>
                                
                                    <td>{{ $loop->iteration}}</td>
                                    <td>{{ $expense->date  }}</td>
                                    <td>{{ $expense->expense_no  }}</td>
                                    <td>{{ $expense->party->business_name ?? 'N/A' }}</td>
                                    <td>{{ $expense->chartOfAccount->name ?? 'N/A' }}</td>
                                    <td style="text-align:right;">{{ ($expense->calculated_tax_amount) ? number_format($expense->calculated_tax_amount, 2) : ''  }}</td>
                                    <td style="text-align:right;">{{ ($expense->amount_exclusive_tax) ? number_format($expense->amount_exclusive_tax, 2) : ''  }}</td>

                                </tr>
                            @endforeach
                    

                            <tr  bgcolor="#CCCCCC">

                                <td colspan="5"><b>TOTAL</b></td>
                                <td style="text-align:right; font-weight:bold">
                                    {{ number_format($expenses->sum('calculated_tax_amount'), 2) }}
                                </td>
                                <td style="text-align:right;font-weight:bold">
                                    {{ number_format($expenses->sum('amount_exclusive_tax'), 2) }}
                                </td>
                               
                                
                            </tr>
                        
                        @else
                            <tr>
                                <td colspan="100%" style="text-align:center; color:red;"><strong>No data found</strong></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            
        </div>
    
    
</body>

</html>



