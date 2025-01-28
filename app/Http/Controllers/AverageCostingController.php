<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;

class AverageCostingController extends Controller
{
    public function itemHistoryRequest()
    {
        $items = Item::where('type','Raw')->get();
        return view('reports.average_costing_item_history.request', compact('items'));
    }
    public function itemHistoryShow(Request $request)
    {
        $item = Item::find($request->item_id);
        
        $transactions = InvoiceDetail::where('item_id',$item->id)
        ->whereIn('type',['receipt','production'])
        ->where('date','<=',$request->date)
        ->orderBy('date','asc')
        ->orderBy('id','asc')
        ->get();

        $stock_weight = 0;
        $stock_value = 0;
        $avg_cost = 0;

        $data = [];
        
        foreach($transactions as $transaction)
        {

            if($transaction->type == 'receipt')
            {
                $stock_value += $transaction->total_price_stock;
                $stock_weight += $transaction->net_weight;

                $avg_cost = $stock_value / $stock_weight;
                
            }
            else if($transaction->type == 'production')
            {           
                $stock_value -= $transaction->net_weight * $avg_cost;
                $stock_weight -= $transaction->net_weight;
 
            }


            $data[] = [
                'date' => $transaction->date,
                'type' => $transaction->type,
                'qty_in' => ($transaction->type == 'receipt') ? $transaction->net_weight : '-',
                'qty_out' => ($transaction->type == 'production') ? $transaction->net_weight : '-',
                'balance' => $stock_weight,
                'balance' => number_format($stock_weight, 2),
                'avg_cost' => ($transaction->type == 'receipt') ? number_format($avg_cost, 2):'-',
                'stock_value' => number_format($stock_weight*$avg_cost, 2),
            ];


           
        }
        
        $date = $request->date;

        return view('reports.average_costing_item_history.show', 
            compact('data','item','date','stock_weight','stock_value','avg_cost')
        );
    }



    public function itemsListRequest()
    {
        return view('reports.average_costing_items_list.request');
    }


    public function itemsListShow(Request $request)
    {
        $items = Item::where('type','Raw')->get();
        $data = [];
        foreach($items as $item)
        {
            $transactions = InvoiceDetail::where('item_id',$item->id)
            ->whereIn('type',['receipt','production'])
            ->where('date','<=',$request->date)
            ->orderBy('date','asc')
            ->orderBy('id','asc')
            ->get();

            $stock_weight = 0;
            $stock_value = 0;
            $avg_cost = 0;
            
            
            if($transactions->sum('net_weight') > 0)
            {
                foreach($transactions as $transaction)
                {
    
                    if($transaction->type == 'receipt')
                    {
                        $stock_value += $transaction->total_price_stock;
                        $stock_weight += $transaction->net_weight;
    
                        if($stock_weight > 0)
                            $avg_cost = $stock_value / $stock_weight;
                        
                    }
                    else if($transaction->type == 'production')
                    {           
                        $stock_value -= $transaction->net_weight * $avg_cost;
                        $stock_weight -= $transaction->net_weight;
         
                    }
    
                }
                $data[] =[
                    'name' => $item->name,
                    'qty_in' =>  $transactions->where('type','receipt')->sum('net_weight'),
                    'qty_out' =>  $transactions->where('type','production')->sum('net_weight'),
                    'balance' => number_format($stock_weight, 2),
                    'stock_value' => number_format($stock_weight*$avg_cost, 2),
                    'avg_cost' =>  number_format($avg_cost,2),
                ];     
            }
            else
            {
                $data[] =[
                    'name' => $item->name,
                    'qty_in' =>  '-',
                    'qty_out' =>  '-',
                    'balance' => '-',
                    'stock_value' => '-',
                    'avg_cost' =>  '-',
                ]; 
            }
           
           
        }
       
        return view('reports.average_costing_items_list.show', compact('data'));
    }


}
