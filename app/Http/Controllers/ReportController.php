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
use App\Mail\SendMail;
// end for excel export
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
        $data = DB::table('v_raw_material_stock_report')->get();

        return view('reports.raw_material_stock', compact('data'));

        
        
    }

    public function fetchFinishedGoodsStock()
    {
        $data = DB::table('v_finished_goods_stock_report')->get();

        return view('reports.finished_goods_stock', compact('data'));

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

        $items = Item::where('type','Good')->get();

        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $date = new DateTime($startDate);
        $startOfMonth = $date->format('Y-m-01');  // Month in two-digit format (01, 02, ..., 12)

        // dd($month);

       foreach($items as $item)
       {
            $data[] = [

                    
                    'name' => $item->name,
                    'code' => $item->code,
                    
                    'production' => DB::table('invoice_detail')
                                    ->select('item_id','date','type','total_quantity')
                                    ->where('type','output')
                                    ->where('item_id', $item->id)
                                    ->whereBetween('date',[$startDate,$endDate])
                                    ->sum('total_quantity'),

                    'bag_issued' => DB::table('invoice_detail')
                                    ->select('item_id','date','type','total_quantity')
                                    ->where('type','invoice')
                                    ->where('item_id', $item->id)
                                    ->whereBetween('date',[$startDate,$endDate])
                                    ->sum('total_quantity'),  

                    'cumulative_sale' => DB::table('invoice_detail')
                                    ->select('item_id','date','type','total_quantity')
                                    ->where('type','invoice')
                                    ->where('item_id', $item->id)
                                    ->whereBetween('date',[$startDate,$endDate])
                                    ->sum('total_quantity'),     


                ]; 
       }
       return response()->json($data);


        // $categories = Category::all();

        // return view('reports.production.show', compact('categories','startDate','endDate'));

    }
}
