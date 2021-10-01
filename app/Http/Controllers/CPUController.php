<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CPU;
use App\Models\CategoryCPU;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
                    ->simplePaginate(10);
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
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->errors();
        }
        else
        {
            $cpu = new CPU;
            $cpu->cpu_id='cpu'.time();
            $cpu->category_cpu_id=$request->category_cpu_id;
            $cpu->cpu_name=$request->cpu_name;

            $result = $cpu->save();
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
    public function update(Request $request, CPU $cpu_id)
    {
        $rules = array(
            "category_cpu_id"=>[
                'required',
                Rule::exists('tbl_categorycpu')->where(function ($query) {
                    $query->get('category_cpu_id');
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
            $cpu = CPU::find($request->cpu_id);
            $cpu->category_cpu_id=$request->category_cpu_id;
            $cpu->cpu_name=$request->cpu_name;

            $result = $cpu->save();
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
    public function destroy(Request $request, CPU $cpu_id)
    {
        $cpu = CPU::find($request->cpu_id);
            $cpu->deleted_at=Carbon::now();
            $result = $cpu->save();
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
