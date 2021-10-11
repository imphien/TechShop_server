<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MachineSeries;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\ulitilize\UUID;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;


class MachineSeriesController extends Controller
{
    public function index()
    {
        $class = DB::table('tbl_class')
                    ->get();
        return $class;
    }

    public function get_class_active()
    {
      $class = DB::table('tbl_class')
              ->whereNull('deleted_at')
              ->select('class_id','class_name')
              ->orderBy('class_name','asc')
              ->get();
      return $class;
    }

    public function get_class_deleted()
    {
      $class = DB::table('tbl_class')
              ->whereNotNull('deleted_at')
              ->select('class_id','class_name')
              ->orderBy('class_name','asc')
              ->get();
      return $class;
    }

    public function get_count_class_active()
    {
      $class = DB::table('tbl_class')
              ->whereNull('deleted_at')
              ->count();
      return $class;
    }

    public function get_count_class_deleted()
    {
      $class = DB::table('tbl_class')
              ->whereNotNull('deleted_at')
              ->count();
      return $class;
    }

    public function show($class_id)
    {
      $class = DB::table('tbl_class')
      ->where('class_id','=',$class_id)
      ->first();
      if(!$class)
      {
      return response()->json('Invalid class_id ',404);
      }
      return $class;
    } 

    public function store(Request $request)
    {
       foreach($request->all() as $item)
       {
        $class = new MachineSeries();
        $class_id = new UUID();
        $class->class_id=$class_id->gen_uuid();
        $class->class_name=$item['class_name'];
        $result = $class->save();

       }
    }

    public function update(Request $request, $class_id)
    {
        $class =  MachineSeries::where('class_id',$class_id);
        $result = $class->update($request->all());
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

    public function destroy(Request $request,  $class_id)
    {
        if (MachineSeries::where('class_id',$class_id)->exists()) {
            $class= MachineSeries::find($class_id);
            if($class->deleted_at != NULL) return ["Result" => "Class deleted"];
            $class->deleted_at = Carbon::now();
            $class->save();
    
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
