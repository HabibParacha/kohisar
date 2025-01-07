<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance Sheet</title>
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
</head>
<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td colspan="2">
                <div align="center" class="style1">{{ env('COMPANY_NAME') }} </div>
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
                <th colspan="3">BALANCE SHEET</th>
            </tr>
            <tr bgcolor="#CCCCCC">
                <th>Levels</th>
                <th>Account</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $firstLevel)
                <tr>
                    <td  style="font-weight: bold;">{{ $firstLevel['first'] }}</td>
                    <td colspan="2"></td>
                </tr>

                @foreach($firstLevel['second'] as $secondLevel)
                    <tr>
                        <td style="padding-left: 20px; font-weight: bold;">{{ $secondLevel['second'] }}</td>
                        <td colspan="2"></td>
                    </tr>

                    @foreach($secondLevel['third'] as $thirdLevel)
                        <tr>
                            <td style="padding-left: 40px; font-weight: bold;text-align:right">{{ $thirdLevel['third'] }}</td>
                            <td colspan="2"></td>
                        </tr>

                        @foreach($thirdLevel['fourth'] as $fourthLevel)
                            <tr >
                                <td></td>
                                <td style="">{{ $fourthLevel['name'] }}</td>
                               
                                <td  style="text-align: right;">{{ number_format($fourthLevel['balance'], 2) }}</td>
                            </tr>
                        @endforeach
                                
                    @endforeach
                @endforeach
            @endforeach
        </tbody>
    </table>
    <br>
    <hr>

    <table width="100%" border="1" cellpadding="3" cellspacing="0" style="border-collapse:collapse;">
        <thead>
            <tr bgcolor="#CCCCCC">
                <th colspan="3">SUPPLIER BALANCE</th>
            </tr>
            <tr bgcolor="#CCCCCC">
                <th width='60%' style="text-align:center;">NAME</th>

                <th width='15%'></th>
                <th width='25%' style="text-align:right;">BALANCE</th>
                
            </tr>
        </thead>
        <tbody>     
          
                @foreach ($supplierJournals as $journal)
                    <tr>
                    
                        <td>{{ $journal->supplier->business_name ?? 'N/A' }}</td>
                      
                        <td style="text-align:center;">
                            @if ($journal->total_debit < $journal->total_credit)
                                <span>CR</span>
                            @else
                                <span><b>DR</b></span>

                            @endif
                        </td>    
                        <td style="text-align:right;">{{  number_format($journal->total_debit - $journal->total_credit, 2)  }}</td>

                    </tr>
                @endforeach
        

                <tr  bgcolor="#CCCCCC">
                    <td colspan="2"><b>TOTAL</b></td>
                    <td style="text-align:right;font-weight:bold">
                        {{ number_format($supplierJournals->sum('total_debit') -  $supplierJournals->sum('total_credit'), 2) }}
                    </td> 
                </tr>
            
           
        </tbody>
    </table>
    <br>
    <hr>

    <table width="100%" border="1" cellpadding="3" cellspacing="0" style="border-collapse:collapse;">
        <thead>
            <tr bgcolor="#CCCCCC">
                <th colspan="3">CUSTOMER BALANCE</th>
            </tr>
            <tr bgcolor="#CCCCCC">
                <th width='60%' style="text-align:center;">NAME</th>
                <th  width='15%'></th>
                <th width='25%' style="text-align:right;">BALANCE</th> 
            </tr>
        </thead>
        <tbody>     
          
                @foreach ($customerJournals as $journal)
                    <tr>
                    
                        <td>{{ $journal->customer->business_name ?? 'N/A' }}</td>
                        <td style="text-align:center;">
                            @if ($journal->total_debit < $journal->total_credit)
                                <span><b>CR</b></span>
                            @else
                                <span>DR</span>

                            @endif
                        </td>   
                        <td style="text-align:right;">{{  number_format($journal->total_debit - $journal->total_credit, 2)  }}</td>

                    </tr>
                @endforeach
        

                <tr  bgcolor="#CCCCCC">

                    <td colspan="2"><b>TOTAL</b></td>
                   
                    <td style="text-align:right;font-weight:bold">
                        {{ number_format($customerJournals->sum('total_debit') -  $customerJournals->sum('total_credit'), 2) }}
                    </td>
                    
                </tr>
            
           
        </tbody>
    </table>
</body>
</html>
