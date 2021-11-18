<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\ulitilize\UUID;
use Illuminate\Http\Response;
use App\Http\Controllers\PaginationController;
use App\Models\Taskbar;

class TaskbarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = DB::table('tbl_taskbar')->whereNull('deleted_at')->get();
        return $result;
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
        foreach($request->all() as $item)
        {
            $taskbar = new Taskbar;
            $tmp = new UUID;
            $taskbar->taskbar_id = $tmp->gen_uuid();
            $taskbar->taskbar_name = $item['taskbar_name'];
            $taskbar->taskbar_url = $item['taskbar_url'];
            $taskbar->save();
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
    public function update(Request $request, $taskbar_id)
    {
        $taskbar =  Taskbar::where('taskbar_id',$taskbar_id);
        $result = $taskbar->update($request->all());
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
    public function destroy($taskbar_id)
    {
        if (Taskbar::where('taskbar_id',$taskbar_id)->exists()) {
            $taskbar = Taskbar::find($taskbar_id);
            if($taskbar->deleted_at != NULL) return ["Result" => "Đã xóa rồi"];
            $taskbar->deleted_at = Carbon::now();
            $taskbar->save();
    
            return response()->json([
              "message" => "deleted successfully"
            ], 200);
          } else {
            return response()->json([
              "message" => "Error"
            ], 404);
          }
    }
}
