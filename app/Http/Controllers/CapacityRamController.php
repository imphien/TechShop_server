<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CapacityRam;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CapacityRamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $capacityram = DB::table('tbl_capacityram')
                    ->simplePaginate(10);
        return $capacityram;
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
        $capacityram = new CapacityRam;
        $capacityram->capacity_ram_id='capacity_ram'.time();
        $capacityram->capacity_ram=$request->capacity_ram;
        $result = $capacityram->save();
        if( $result)
        {
            return ["Result"=>"Data has been saved"];
        }
        else
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
    public function update(Request $request, CapacityRam $capacity_ram_id)
    {
        $capacityram =  CapacityRam::find($request->capacity_ram_id);
        $capacityram->capacity_ram=$request->capacity_ram;
        $result = $capacityram->save();
        if( $result)
        {
            return ["Result"=>"Data has been saved"];
        }
        else
        {
            return ["Result"=>"Error"];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CapacityRam $capacity_ram_id)
    {
        $capacityram =  CapacityRam::find($request->capacity_ram_id);
        $capacityram->deleted_at= Carbon::now();
        $result = $capacityram->save();
        if( $result)
        {
            return ["Result"=>"Data has been saved"];
        }
        else
        {
            return ["Result"=>"Error"];
        }
    }
}
