<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Models\Item;
use App\Models\Unit;
use App\Models\Party;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Party::whereIn('party_type',['supplier','both'])->get();
        $items = Item::all();
        $taxes = Tax::all();
        $units = Unit::all();

        $paymentTerms = $this->paymentTerms();
        
        
        return view('purchase_orders.create', 
        compact(
            'suppliers','items','taxes','units','paymentTerms'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('purchase_orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function paymentTerms(){
        $data = [
            [   'name' => 'net 07','value' => 07  ],
            [   'name' => 'net 10','value' => 10  ],
            [   'name' => 'net 15','value' => 15  ],
            [   'name' => 'net 20','value' => 20  ],
            [   'name' => 'net 45','value' => 30  ],
            [   'name' => 'net 45','value' => 45  ],
           
        ];

        return $data;
    }
}
