<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MachineSeries;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\ulitilize\UUID;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class MachineSeriesController extends Controller
{
    public function index()
    {
        $class = DB::table('tbl_class')
                    ->simplePaginate(10);
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
            return ["Result"=>"Data has been saved"];
        }
        else
        {
            return ["Result"=>"Error"];
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
