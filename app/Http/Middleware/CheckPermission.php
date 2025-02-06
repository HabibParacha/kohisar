<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $routeName = $request->route()->getName(); // e.g., 'item.create'
        
        $hasPermission = DB::table('role_permissions')
        ->where('role_id', $user->role_id)
        ->where('route_name', $routeName) // Direct match
        ->where('is_allowed', 1)
        ->exists();

       
        if (!$hasPermission) {
            // abort(403, 'Unauthorized action.');
            // return view('403');
             // Return a JSON response with a success message
            return redirect()->back()->with('success','Your Are Not Authorized Please Contact Admin');
        }

        

        // dd(ucfirst($section),ucfirst($action));
        return $next($request);
    }
}
