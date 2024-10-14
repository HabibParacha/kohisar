<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverDashboard extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        $driver_orders = Order::with('vehicleAssignment')
            ->whereHas('vehicleAssignment', function ($query) {
                $query->where('driver_id', Auth::user()->id);
            })->get();

        // Count orders by status
        // Laravel collection, which allows you to count the orders for each status in PHP without hitting the database multiple times.
        $total_orders = $driver_orders->count();
        $pending_orders = $driver_orders->where('status', 0)->count();
        $completed_orders = $driver_orders->where('status', 1)->count();
        $rejected_orders = $driver_orders->where('status', 2)->count();

        return view('driverDashboard', 
            compact(
                'total_orders','pending_orders','completed_orders','rejected_orders'
            ));

    }
}
