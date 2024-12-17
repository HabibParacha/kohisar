<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RolePermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = DB::table('roles')->get();
        $permissions = DB::table('permissions')->get();

        return view('roles_permissions.index', compact('roles','permissions'));
    }
    // public function index()
    // {
    //     $roles = DB::table('roles')->get();

    //     return view('roles_permissions.index', compact('roles'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $sections = DB::table('permissions')->select('section')->distinct()->get();
        $sections = DB::table('permissions')->select('section')->distinct()->get();

        return view('roles_permissions.create', compact('sections'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $role_id = DB::table('roles')->insertGetId([
                'name' => $request->input('role')
            ]);
    
            for($i=0; $i< count($request->is_allowed); $i++)
            {
                DB::table('role_permissions')->insert([
    
                    'role_id' =>  $role_id,
                    'permission_id' =>  $request->permission_id[$i],
                    'section' => $request->section[$i],
                    'action' => $request->action[$i],
                    'route_name' => $request->route_name[$i],
                    'is_allowed' => $request->is_allowed[$i],
                    'created_by' => Auth::user()->id,
                    'created_at' => now(),
                ]);
            }
           
            DB::commit();

            return redirect()->route('role-permissions.index');

        } catch (\Exception $e) {
             DB::rollback();
             dd($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function show($id)
    {
        $sections = DB::table('role_permissions')
        ->where('role_id',$id)
        ->select('section')
        ->distinct()
        ->get();

        $role_id = $id;
        $role = DB::table('roles')->where('id',$role_id)->first('name');
       
        

        return view('roles_permissions.show', compact('sections','role_id','role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sections = DB::table('role_permissions')
        ->where('role_id',$id)
        ->select('section')
        ->distinct()
        ->get();

        $role_id = $id;
        $role = DB::table('roles')->where('id',$role_id)->first('name');
       
        

        return view('roles_permissions.edit', compact('sections','role_id','role'));
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

       
        $role_id = $id;

        for($i=0; $i< count($request->is_allowed); $i++)
        {
            DB::table('role_permissions')->where('id',$request->id[$i])->update([

                'is_allowed' => $request->is_allowed[$i],
                'updated_by' => Auth::user()->id,
                'updated_at' => now(),
            ]);
        }
        return redirect()->route('role-permissions.index');

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

    public function ajax(Request $request)
    {


        $id = $request->id;
        $role_id = $request->role_id;

        $section = $request->section;
        $action = $request->action;
        $route_name = $request->route_name;
        $value = $request->value;
        $permission_id = $request->permission_id;

        if($id == 0){
            DB::table('role_permissions')->insert([
                'role_id' => $role_id,
                'permission_id' => $permission_id,
                'section' => $section,
                'action' => $action,
                'route_name' => $route_name,
                'is_allowed' => $value,
            ]);

        }else{

            DB::table('role_permissions')->where('id', $id)->update([
                'is_allowed' => $value
            ]);
        }
        return response()->json([
            'message' => 'Done'
        ]);
        
        
    }

    
    
}
