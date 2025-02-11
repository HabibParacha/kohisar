<?php

namespace App\Http\Controllers;
use PDF;
use URL;

use File;
use Excel;
use Image;
use Session;
use DateTime;
use Carbon\Carbon;
// for excel export
use App\Models\Item;
use App\Models\Party;
// end for excel export
use App\Mail\SendMail;
use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use App\Models\InvoiceMaster;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Exports\SupplierLedgerExcel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportController extends Controller
{
   
    public function fetchRawMaterailStock()
    {
        $data = DB::table('v_raw_material_avg_unit_price')->get();

        return view('reports.raw_material_stock', compact('data'));

        
        
    }

    public function fetchFinishedGoodsStock()
    {
        $data = DB::table('v_finished_goods_stock_report')
        ->whereIn('category_id',[1,2,3,4])
        ->get();

        return view('reports.finished_goods_stock', compact('data'));

    }

    public function fetchEmptyBagsStock()
    {
        $data = DB::table('v_finished_goods_stock_report')
        ->where('category_id',6)
        ->get();

        return view('reports.empty_bags_stock', compact('data'));
    }
    

    public function productionRequest(Request $request)
    {
        $categories = Category::all();

        return view('reports.production.request', compact('categories'));
    }
    public function productionShow1(Request $request)
    {

        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $categories = Category::all();

        return view('reports.production.show', compact('categories','startDate','endDate'));

    }

    public function productionShow(Request $request)
{
    $startDate = $request->startDate;
    $endDate = $request->endDate;

    $date = new DateTime($startDate);
    $currentMonthStartDate = $date->format('Y-m-01');  // The first date of the current month
    $previousMonthEndDate = $date->modify('last day of last month')->format('Y-m-d');  // Last date of the previous month

    // Fetch all items where type is 'Good' and order them by category
    $items = Item::where('type', 'Good')
    ->when($request->category_id, function ($query) use ($request) {
        return $query->where('category_id', $request->category_id);
    })
    ->orderBy('category_id')->get();

    // Group items by category
    $groupedByCategory = $items->groupBy('category_id');
    $data = [];

    // Loop through each category
    foreach ($groupedByCategory as $categoryId => $itemsInCategory) {
        $category = Category::find($categoryId);
        
        $categoryData = [
            'category_name' => $category ? $category->name : 'N/A',
            'items' => [],
        ];

        // with point values result
        /*
            foreach ($itemsInCategory as $item) {
                // Collect data for each item
                $categoryData['items'][] = [
                    'name' => $item->name,
                    'code' => $item->code,
                    'category' => $category ? $category->name : 'N/A',
                    'before_start_date_production' => DB::table('invoice_detail')
                        ->where('type', 'output')
                        ->where('item_id', $item->id)
                        ->where('date', '<', $startDate)
                        ->sum('total_quantity'),

                    'before_start_date_sales' => DB::table('invoice_detail')
                        ->where('type', 'invoice')
                        ->where('item_id', $item->id)
                        ->where('date', '<', $startDate)
                        ->sum('total_quantity'),

                    'between_dates_production' => DB::table('invoice_detail')
                        ->where('type', 'output')
                        ->where('item_id', $item->id)
                        ->whereBetween('date', [$startDate, $endDate])
                        ->sum('total_quantity'),

                    'between_dates_sales' => DB::table('invoice_detail')
                        ->where('type', 'invoice')
                        ->where('item_id', $item->id)
                        ->whereBetween('date', [$startDate, $endDate])
                        ->sum('total_quantity'),

                    'cumulative_sale' => DB::table('invoice_detail')
                        ->where('type', 'invoice')
                        ->where('item_id', $item->id)
                        ->whereBetween('date', [$currentMonthStartDate, $startDate])
                        ->sum('total_quantity'),

                    'cumulative_prod' => DB::table('invoice_detail')
                        ->where('type', 'output')
                        ->where('item_id', $item->id)
                        ->whereBetween('date', [$currentMonthStartDate, $startDate])
                        ->sum('total_quantity'),
                ];
            }
        */

        // dropping after point value using floor
        foreach ($itemsInCategory as $item) {
            // Collect data for each item
            $categoryData['items'][] = [
                'name' => $item->name,
                'code' => $item->code,
                'category' => $category ? $category->name : 'N/A',
                
                'before_start_date_production' => floor(DB::table('invoice_detail')
                    ->where('type', 'output')
                    ->where('item_id', $item->id)
                    ->where('date', '<', $startDate)
                    ->sum('total_quantity')),
        
                'before_start_date_sales' => floor(DB::table('invoice_detail')
                    ->where('type', 'invoice')
                    ->where('item_id', $item->id)
                    ->where('date', '<', $startDate)
                    ->sum('total_quantity')),
        
                'between_dates_production' => floor(DB::table('invoice_detail')
                    ->where('type', 'output')
                    ->where('item_id', $item->id)
                    ->whereBetween('date', [$startDate, $endDate])
                    ->sum('total_quantity')),
        
                'between_dates_sales' => floor(DB::table('invoice_detail')
                    ->where('type', 'invoice')
                    ->where('item_id', $item->id)
                    ->whereBetween('date', [$startDate, $endDate])
                    ->sum('total_quantity')),
        
                'cumulative_sale' => floor(DB::table('invoice_detail')
                    ->where('type', 'invoice')
                    ->where('item_id', $item->id)
                    ->whereBetween('date', [$currentMonthStartDate, $startDate])
                    ->sum('total_quantity')),
        
                'cumulative_prod' => floor(DB::table('invoice_detail')
                    ->where('type', 'output')
                    ->where('item_id', $item->id)
                    ->whereBetween('date', [$currentMonthStartDate, $startDate])
                    ->sum('total_quantity')),
            ];
        }
        
        // Add category data to the final data array
        $data[] = $categoryData;
    }

    // Return the data to the view (you can also return as JSON for API response)
    return view('reports.production.show', compact('data', 'startDate', 'endDate'));
}



    public function rawMaterialHistoryRequest()
    {
        $items = Item::where('type','Raw')->get();

        return view('reports.raw_material_history.request', compact('items'));
    }
    public function rawMaterialHistroyShow(Request $request)
    {

        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $item_id = $request->item_id;

        $receipts = InvoiceDetail::where('item_id', $item_id )
        ->where('type','receipt')
        ->whereBetween('date',[ $startDate, $endDate])
        ->get();
        $productions = InvoiceDetail::where('item_id', $item_id )
        ->where('type','production')
        ->whereBetween('date',[ $startDate, $endDate])
        ->get();

      
        // $pdf = PDF::loadView('reports.raw_material_history.pdf', compact('item','receipts','productions','startDate','endDate'));
        // $pdf->setpaper('A4', 'landscape');

        // return $pdf->stream();
        return view('reports.raw_material_history.show', compact('receipts','productions','startDate','endDate'));

    }

    public function materialReceivedHistoryRequest()
    {
        $items = Item::where('type','Raw')->get();
        $suppliers = Party::where('party_type','Supplier')->get();

        return view('reports.material_received_history.request', compact('items','suppliers'));
    }
    public function materialReceivedHistoryShow(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $data = InvoiceMaster::where('type', 'receipt')
        ->whereBetween('date', [$startDate, $endDate])
        ->when($request->supplier_id, function ($query) use ($request) {
            return $query->where('party_id', $request->supplier_id);
        })
        ->with('invoiceDetails')
        ->orderBy('date','asc')
        ->get();
        

        $pdf = PDF::loadView('reports.material_received_history.pdf', compact('data','startDate','endDate'));
        $pdf->setpaper('A4', 'landscape');
        return $pdf->stream();

        // return view('reports.material_received_history.pdf', compact('data','startDate','endDate'));
    }

    public function rawMaterialStockLevelRequest()
    {
        $items = Item::where('type','Raw')->get();

        return view('reports.raw_material_stock_level.request', compact('items'));
    }

    public function rawMaterialStockLevelShow(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $item_id = $request->item_id;
        $items = Item::where('type','Raw')->get();

        $data= [];

        foreach($items as $item)
        {
            $data[] = [
                'name' => $item->name,
                'receipts' => InvoiceDetail::where('item_id', $item->id )
                ->where('type','receipt')
                ->where('date','<', $startDate)
                ->sum('net_weight'),

                'productions' => InvoiceDetail::where('item_id', $item->id )
                ->where('type','production')
                ->where('date','<', $startDate)
                ->sum('net_weight'),

                'received' => InvoiceDetail::where('item_id', $item->id )
                ->where('type','receipt')
                ->whereBetween('date', [$startDate, $endDate])
                ->sum('net_weight'),

                'usage' => InvoiceDetail::where('item_id', $item->id )
                ->where('type','production')
                ->whereBetween('date', [$startDate, $endDate])
                ->sum('net_weight'),

                'purchased_worth' => InvoiceDetail::Where('item_id', $item->id)
                ->where('type','receipt')
                ->where('date','<=', $endDate)
                ->sum('total_price_stock'),

                'purchased_net_wgt' => InvoiceDetail::where('item_id', $item->id)
                ->where('type','receipt')
                ->where('date','<=', $endDate)
                ->sum('net_weight'),

            ];
        }

        return view('reports.raw_material_stock_level.show', compact('data','startDate','endDate'));
    }

    
}
