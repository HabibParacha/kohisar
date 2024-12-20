<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SalemanDashboard extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $total_users = User::count();
        


        return view('saleman_dashboard', 
            compact(
                'total_users'
        ));
    }
}
