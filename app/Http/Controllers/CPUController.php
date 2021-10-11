<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CPU;
use App\Models\CategoryCPU;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\ulitilize\UUID;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;


class CPUController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $cpu = DB::table('tbl_cpu')
                    ->get();
        return $cpu;
    }

    public function get_cpu_active()
    {
      $cpu = DB::table('tbl_cpu')
              ->whereNull('deleted_at')
              ->select('cpu_id','cpu_name','created_at','deleted_at','updated_at')
              ->orderBy('cpu_name','asc')
              ->get();
      return $cpu;
    }

    public function get_cpu_deleted()
    {
      $cpu = DB::table('tbl_cpu')
              ->whereNotNull('deleted_at')
              ->select('cpu_id','cpu_name','created_at','deleted_at','updated_at')
              ->orderBy('cpu_name','asc')
              ->get();
      return $cpu;
    }

    public function get_count_cpu_active()
    {
      $cpu = DB::table('tbl_cpu')
              ->whereNull('deleted_at')
              ->count();
      return $cpu;
    }

    public function get_count_cpu_deleted()
    {
      $cpu = DB::table('tbl_cpu')
              ->whereNotNull('deleted_at')
              ->count();
      return $cpu;
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
            "category_cpu_id"=>[
                'required',
                Rule::exists('tbl_categorycpu')->where(function ($query) {
                    $query->get('category_cpu_id');
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
            }
            else
            {
                $cpu = new CPU;
                $cpu_id = new UUID();
                $cpu->cpu_id = $cpu_id->gen_uuid();
                $cpu->category_cpu_id=$item['category_cpu_id'];
                $cpu->cpu_name=$item['cpu_name'];
                $result = $cpu->save();
            }
        }
        $errors_index = '';
        foreach($index as $i)
        {
            $errors_index = $errors_index.$i.' ';
        }
        if($errors_index == '')
            return response()->json(["message"=>"Data has been saved "],200);
        return response()->json(["message"=>"Invalid category_cpu_id in position ".$errors_index." in payload"],404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($cpu_id)
    {
        $cpu = DB::table('tbl_cpu')
        ->where('cpu_id','=',$cpu_id)
        ->first();
        if(!$cpu)
        {
        return response()->json('Invalid cpu_id ',404);
        }
        return $cpu;
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
    public function update(Request $request,  $cpu_id)
    {
        $rules = array(
            "category_cpu_id"=>[
                Rule::exists('tbl_categorycpu')->where(function ($query) {
                    $query->get('category_cpu_id');
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
            $cpu =  CPU::where('cpu_id',$cpu_id);
            $result = $cpu->update($request->all());
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,  $cpu_id)
    {
        if (CPU::where('cpu_id',$cpu_id)->exists()) {
            $cpu= CPU::find($cpu_id);
            if($cpu->deleted_at != NULL) return ["Result" => "CPU deleted"];
            $cpu->deleted_at = Carbon::now();
            $cpu->save();
    
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
