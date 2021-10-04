<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RAM;
use App\Models\CapacityRam;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\ulitilize\UUID;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

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
       
       foreach($request->all() as $item)
       {
            $validator = Validator::make($item,$rules);
            if($validator->fails())
            {
                return $validator->errors();
            }else
            {
                $ram = new RAM;
                $ram->ram_id='ram'.time();
                $ram->capacity_ram_id=$item['capacity_ram_id'];
                $ram->ram_detail=$item['ram_detail'];

                $result = $ram->save();
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
    public function update(Request $request,  $id)
    {
        
        $rules = array(
            "capacity_ram_id"=>[
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
            $ram =  RAM::where('ram_id',$id);
            $result = $ram->update($request->all());
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
    public function destroy(Request $request, $id)
    {
        if (RAM::where('ram_id', $id)->exists()) {
            $ram = RAM::find($id);
    
            if($ram->deleted_at != NULL) return ["Result" => "RAM deleted"];
            $ram->deleted_at = Carbon::now();
            $ram->save();
    
            return response()->json([
              "message" => "records updated successfully"
            ], 200);
          } else {
            return response()->json([
              "message" => "Book not found"
            ], 404);
          }
            
    }
}
