<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CapacityRam;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\ulitilize\UUID;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CapacityRamResource;
use Illuminate\Http\Response;

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
       foreach($request->all() as $item)
       {
        $capacityram = new CapacityRam;
        $capacity_ram_id = new UUID();
        $capacityram->capacity_ram_id = $capacity_ram_id->gen_uuid();
        $capacityram->capacity_ram=$item['capacity_ram'];
        $result = $capacityram->save();
       
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
    public function update(Request $request,  $capacity_ram_id)
    {
        $capacity_ram =  CapacityRAM::where('capacity_ram_id',$capacity_ram_id);
        $result = $capacity_ram->update($request->all());
        if( $result)
        {
            return response()->json([
                "message" => "Data has been saved"
              ], 200);
        }
        else
        {
            return response()->json([
                "message" => "Error"
              ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,  $capacity_ram_id)
    {
        if (CapacityRam::where('capacity_ram_id',$capacity_ram_id)->exists()) {
            $capacity_ram = CapacityRam::find($capacity_ram_id);
            if($capacity_ram->deleted_at != NULL) return ["Result" => "CapacityRam deleted"];
            $capacity_ram->deleted_at = Carbon::now();
            $capacity_ram->save();
    
            return response()->json([
              "message" => "Deleted successfully"
            ], 200);
          }
        else {
            return response()->json([
              "message" => "Error"
            ], 404);
          }
    }
}
