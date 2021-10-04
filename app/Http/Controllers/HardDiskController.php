<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HardDisk;
use App\Models\CategoryHardDisk;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\ulitilize\UUID;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

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
        foreach($request->all() as $item)
        {
            $validator = Validator::make($item,$rules);
            if($validator->fails())
            {
                return $validator->errors();
            }else
            {
                $harddisk = new HardDisk;
                $harddisk_id = new UUID();
                $harddisk->harddisk_id = $harddisk_id->gen_uuid();
                $harddisk->category_harddisk_id=$item['category_harddisk_id'];
                $harddisk->capacity_harddisk=$item['capacity_harddisk'];
                $result = $harddisk->save();
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
    public function update(Request $request,  $harddisk_id)
    {
        $rules = array(
            "category_harddisk_id"=>[
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
            $harddisk =  HardDisk::where('harddisk_id',$harddisk_id);
            $result = $harddisk->update($request->all());
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
    public function destroy(Request $request,  $harddisk_id)
    {
        if (HardDisk::where('harddisk_id',$harddisk_id)->exists()) {
            $harddisk= HardDisk::find($harddisk_id);
            if($harddisk->deleted_at != NULL) return ["Result" => "Harddisk deleted"];
            $harddisk->deleted_at = Carbon::now();
            $harddisk->save();
    
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
