<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MachineSeries;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        $class = new MachineSeries;
            $class->class_id='class'.time();
            $class->class_name=$request->class_name;
            $result = $class->save();
            if( $result)
            {
                return ["Result"=>"Data has been saved"];
            }
            else
            {
                return ["Result"=>"Error"];
            }
    }

    public function update(Request $request, MachineSeries $class_id)
    {
        $class = MachineSeries::find($request->class_id);
        $class->class_name=$request->class_name;
        $result = $class->save();
        if( $result)
        {
            return ["Result"=>"Data has been saved"];
        }
        else
        {
            return ["Result"=>"Error"];
        }
    }

    public function destroy(Request $request, MachineSeries $class_id)
    {
        $class = MachineSeries::find($request->class_id);
        $class->deleted_at= Carbon::now();
        $result = $class->save();
        if( $result)
        {
            return ["Result"=>"Data has been delete"];
        }else
        {
            return ["Result"=>"Error"];
        }
    }
}
