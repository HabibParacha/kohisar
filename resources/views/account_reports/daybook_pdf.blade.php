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
                    <div align="center"><strong>DAY BOOK REPORT</strong></div>
                </td>
            </tr>
            <tr>
                <td width="50%">From {{ request()->startDate }} TO {{ request()->endDate }}</td>
                <td width="50%">
                    <div align="right">DATED: {{ date('d-m-Y') }}</div>
                </td>

            </tr>

        </table>
       
       <div>
        <table  width="100%">
            <tr width="100%">

                <td width="50%" style="vertical-align: top">
                    <table  width="100%" border="1" cellpadding="3" cellspacing="0" style="border-collapse:collapse;">
                        <tbody>
                            <tr bgcolor="#CCCCCC">
                                <th width='20%' style="text-align:center;">DATE</th>
                                <th width='20%' style="text-align:center;">VHNO</th>
                                <th width='60%' style="text-align:center;">NAME</th>
                                <th width='20%' style="text-align:center;">AMOUNT</th>
                            </tr>
                        </tbody>
                        @if ($invoices->isNotEmpty())
                        <tbody>
                            @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->date }}</td>
                                <td>{{ $invoice->invoice_no }}</td>
                                <td>{{ $invoice->party->business_name }}</td>
                                <td style="text-align:right;">{{ ($invoice->grand_total) ? number_format($invoice->grand_total, 2) : ''  }}</td>
                        
                            </tr>
                            @endforeach  
        
                            <tr>
                                <td colspan="3" bgcolor="#CCCCCC"><b>TOTAL</b></td>
                                <td style="text-align:right;" bgcolor="#CCCCCC">
                                    <b>{{ number_format($invoices->sum('grand_total'), 2) }}</b>
                                </td>
                            </tr>  
                        </tbody>
                        @else
                            <tfoot>
                                <tr>
                                    <td colspan="4" style="color: red; text-align:center"><b>No Data Found</b></td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </td>

                <td width="50%">
                    <table  width="100%"  border="1" cellpadding="3" cellspacing="0" style="border-collapse:collapse;">
                        <tbody>
                            <tr bgcolor="#CCCCCC">
                                <th width='15%' style="text-align:center;">DATE</th>
                                <th width='10%' style="text-align:center;">VHNO</th>
                                <th width='45%' style="text-align:center;">NARRATION</th>
                                <th width='15%' style="text-align:center;">RECIPT</th>
                                <th width='15%' style="text-align:center;">PAYMENT</th>
                            </tr>
                        </tbody>
                        @if ($journals->isNotEmpty())
                            <tbody>
                                @foreach ($journals as $journal)
                                <tr>
                                    <td>{{ $journal->date }}</td>
                                    <td>{{ $journal->voucher_no }}</td>
                                    <td style="font-size: 9px">{{ $journal->narration }}</td>
                                    <td style="text-align:right;">{{ ($journal->debit) ? number_format(($journal->debit), 2) : ''  }}</td>
                                    <td style="text-align:right;">{{ ($journal->credit) ? number_format($journal->credit, 2) : ''  }}</td>                        
                                </tr>
                                @endforeach

                                <tr>
                                    <td colspan="3" bgcolor="#CCCCCC"><b>TOTAL</b></td>
                                    <td style="text-align:right;" bgcolor="#CCCCCC">
                                        <b> {{ number_format($journals->sum('debit'), 2) }}</b>
                                    </td>
                                    <td style="text-align:right;" bgcolor="#CCCCCC">
                                        <b> {{ number_format($journals->sum('credit'), 2) }}</b>
                                    </td>
                                </tr> 
                            </tbody>
                        @else
                            <tfoot>
                                <tr>
                                    <td colspan="5" style="color: red; text-align:center"><b>No Data Found</b></td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </td>
            </tr>
        </table>
            
       </div>
    </div>
</body>

</html>



