<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryCPU;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\ulitilize\UUID;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class CategoryCPUController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorycpu = DB::table('tbl_categorycpu')
                    ->get();
        return $categorycpu;
    }

    public function get_categorycpu_active()
    {
      $categorycpu = DB::table('tbl_categorycpu')
              ->whereNull('deleted_at')
              ->orderBy('category_cpu_name','asc')
              ->get();
      return $categorycpu;
    }

    public function get_categorycpu_deleted()
    {
      $categorycpu = DB::table('tbl_categorycpu')
              ->whereNotNull('deleted_at')
              ->orderBy('category_cpu_name','asc')
              ->get();
      return $categorycpu;
    }

    public function get_count_categorycpu_active()
    {
      $categorycpu = DB::table('tbl_categorycpu')
              ->whereNull('deleted_at')
              ->count();
      return $categorycpu;
    }

    public function get_count_categorycpu_deleted()
    {
      $categorycpu = DB::table('tbl_categorycpu')
              ->whereNotNull('deleted_at')
              ->count();
      return $categorycpu;
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
    public function store(Request $request, CategoryCPU $category_cpu_id)
    {
        foreach($request->all() as $item)
        {
            $categorycpu = new CategoryCPU;
            $category_cpu_id = new UUID();
            $categorycpu->category_cpu_id = $category_cpu_id->gen_uuid();
            $categorycpu->category_cpu_name=$item['category_cpu_name'];
            $result = $categorycpu->save();
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($category_cpu_id)
    {
        $categorycpu = DB::table('tbl_categorycpu')
              ->where('category_cpu_id','=',$category_cpu_id)
              ->first();
       if(!$categorycpu)
       {
        return response()->json('Invalid category_cpu_id ',404);
       }
      return $categorycpu;
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
    public function update(Request $request,  $category_cpu_id)
    {
        $category_cpu =  CategoryCPU::where('category_cpu_id',$category_cpu_id);
        $result = $category_cpu->update($request->all());
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
    public function destroy(Request $request, $category_cpu_id)
    {
        if (CategoryCPU::where('category_cpu_id',$category_cpu_id)->exists()) {
            $category_cpu= CategoryCPU::find($category_cpu_id);
            if($category_cpu->deleted_at != NULL) return ["Result" => "CapacityRam deleted"];
            $category_cpu->deleted_at = Carbon::now();
            $category_cpu->save();
    
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
