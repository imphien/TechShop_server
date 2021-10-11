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
use Illuminate\Http\Response;

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
                    ->get();
        return $ram;
    }

    public function get_ram_active()
    {
      $ram = DB::table('tbl_ram')
              ->whereNull('deleted_at')
              ->select('ram_id','ram_detail','created_at','deleted_at','updated_at')
              ->orderBy('ram_detail','asc')
              ->get();
      return $ram;
    }

    public function get_ram_deleted()
    {
      $ram = DB::table('tbl_ram')
              ->whereNotNull('deleted_at')
              ->select('ram_id','ram_detail','created_at','deleted_at','updated_at')
              ->orderBy('ram_detail','asc')
              ->get();
      return $ram;
    }

    public function get_count_ram_active()
    {
      $ram = DB::table('tbl_ram')
              ->whereNull('deleted_at')
              ->count();
      return $ram;
    }

    public function get_count_ram_deleted()
    {
      $ram = DB::table('tbl_ram')
              ->whereNotNull('deleted_at')
              ->count();
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
        $index = [];
        $i = 0;
       foreach($request->all() as $item)
       {
            $i++;
            $validator = Validator::make($item,$rules);
            if($validator->fails())
            {
                array_push($index,$i);
                continue;
            }else
            {
                $ram = new RAM;
                $ram_id = new UUID();
                $ram->ram_id=$ram_id->gen_uuid();
                $ram->capacity_ram_id=$item['capacity_ram_id'];
                $ram->ram_detail=$item['ram_detail'];

                $result = $ram->save();
            }
        }

        $errors_index = '';
        foreach($index as $i)
        {
            $errors_index = $errors_index.$i.' ';
        }
        if($errors_index == '')
            return response()->json(["message"=>"Data has been saved "],200);
        return response()->json(["message"=>"Invalid capacity_ram_id in position ".$errors_index." in payload"],404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($ram_id)
    {
        $ram = DB::table('tbl_ram')
        ->where('ram_id','=',$ram_id)
        ->first();
        if(!$ram)
        {
        return response()->json('Invalid ram_id ',404);
        }
        return $ram;
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
            return response()->json($validator->errors(),404);
        }
        else
        {
            $ram =  RAM::where('ram_id',$id);
            $result = $ram->update($request->all());
            if( $result)
            {
                return response()->json([
                    "message" => "Data has been saved"
                  ], 200);
            }
            else
            {
                return response()->json([
                    "message" => "Book not found"
                  ], 404);
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
              "message" => "Deleted successfully"
            ], 200);
          } else {
            return response()->json([
              "message" => "Book not found"
            ], 404);
          }
            
    }
}
