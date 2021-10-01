<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HardDisk;
use App\Models\CategoryHardDisk;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HardDiskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $harddisk = DB::table('tbl_harddisk')
                    ->simplePaginate(10);
        return $yharddisk;
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
            "category_harddisk_id"=>[
                'required',
                Rule::exists('tbl_categoryharddisk')->where(function ($query) {
                    $query->get('category_harddisk_id');
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
            $harddisk = new HardDisk;
            $harddisk->harddisk_id='harddisk'.time();
            $harddisk->category_harddisk_id=$request->category_harddisk_id;
            $harddisk->capacity_harddisk=$request->capacity_harddisk;

            $result = $harddisk->save();
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
    public function update(Request $request, HardDisk $harddisk_id)
    {
        $rules = array(
            "category_harddisk_id"=>[
                'required',
                Rule::exists('tbl_categoryharddisk')->where(function ($query) {
                    $query->get('category_harddisk_id');
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
            $harddisk = HardDisk::find($request->harddisk_id);
            $harddisk->category_harddisk_id=$request->category_harddisk_id;
            $harddisk->capacity_harddisk=$request->capacity_harddisk;

            $result = $harddisk->save();
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
    public function destroy(Request $request, HardDisk $harddisk_id)
    {
        $harddisk = HardDisk::find($request->harddisk_id);
        $harddisk->deleted_at=$request->Carbon::now();

        $result = $harddisk->save();
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
