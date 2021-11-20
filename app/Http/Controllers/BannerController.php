<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\ulitilize\UUID;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = DB::table('tbl_banner')->whereNull('deleted_at')->get();
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
            $banner = new Banner;
            $id = new UUID;
            $banner->banner_id = $id->gen_uuid();
            $banner->banner_image = $item['banner_image'];
            $banner->link = $item['link'];
            $banner->save();
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
    public function update(Request $request, $banner_id)
    {
        $banner =  Banner::where('banner_id',$banner_id);
        $result = $banner->update($request->all());
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
    public function destroy($banner_id)
    {
        if (Banner::where('banner_id',$banner_id)->exists()) {
            $banner = Banner::find($banner_id);
            if($banner->deleted_at != NULL) return ["Result" => "Đã xóa rồi"];
            $banner->deleted_at = Carbon::now();
            $banner->save();
    
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
