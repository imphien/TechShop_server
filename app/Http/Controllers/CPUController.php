<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CPU;
use App\Models\CategoryCPU;
use Illuminate\Support\Facades\DB;

class CPUController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cpu_id = DB::table('tbl_categorycpu')
                    ->select('category_cpu_id')
                    ->get();
        $CPU = new CPU;
        $CPU->cpu_id = 'cpu'.time();
        $CPU->cpu_name=$request->cpu_name;
        $CPU->category_cpu_id=
        $result = $brand->save();
        if( $result)
        {
            return ["Result"=>"Data has been saved"];
        }else
        {
            return ["Result"=>"Error"];
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
}
