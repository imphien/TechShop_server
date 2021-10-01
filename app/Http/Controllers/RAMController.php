<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RAM;
use App\Models\CapacityRam;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RAMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ram = DB::table('tbl_ram')
                    ->simplePaginate(10);
        return $ram;
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
        $rules = array(
            "capacity_ram_id"=>[
                'required',
                Rule::exists('tbl_capacityram')->where(function ($query) {
                    $query->get('capacity_ram_id');
                }),
            ]
        );
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->errors();
        }
        else
        {
            $ram = new RAM;
            $ram->ram_id='ram'.time();
            $ram->capacity_ram_id=$request->capacity_ram_id;
            $ram->ram_detail=$request->ram_detail;

            $result = $ram->save();
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
    public function update(Request $request, RAM $ram_id)
    {
        $rules = array(
            "capacity_ram_id"=>[
                'required',
                Rule::exists('tbl_capacityram')->where(function ($query) {
                    $query->get('capacity_ram_id');
                }),
            ]
        );
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->errors();
        }
        else
        {
            $ram = RAM::find($request->ram_id);
            $ram->capacity_ram_id=$request->capacity_ram_id;
            $ram->ram_detail=$request->ram_detail;

            $result = $ram->save();
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, RAM $ram_id)
    {
        $ram = RAM::find($request->ram_id);
            $ram->deleted_at=$request->Carbon::now();

            $result = $ram->save();
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
