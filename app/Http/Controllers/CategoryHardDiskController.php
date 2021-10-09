<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryHardDisk;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\ulitilize\UUID;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class CategoryHardDiskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoryharddisk = DB::table('tbl_categoryharddisk')
                    ->simplePaginate(10);
        return $categoryharddisk;
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
        $categoryharddisk = new CategoryHardDisk;
        $category_harddisk_id = new UUID();
        $categoryharddisk->category_harddisk_id = $category_harddisk_id->gen_uuid();
        $categoryharddisk->category_harddisk_name=$item['category_harddisk_name'];
        $result = $categoryharddisk->save();
       
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
    public function update(Request $request,  $category_harddisk_id)
    {
        $category_harddisk =  CategoryHardDisk::where('category_harddisk_id',$category_harddisk_id);
        $result = $category_harddisk->update($request->all());
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
    public function destroy(Request $request, $category_harddisk_id)
    {
        if (CategoryHardDisk::where('category_harddisk_id',$category_harddisk_id)->exists()) {
            $category_harddisk= CategoryHardDisk::find($category_harddisk_id);
            if($category_harddisk->deleted_at != NULL) return ["Result" => "Category_harddisk deleted"];
            $category_harddisk->deleted_at = Carbon::now();
            $category_harddisk->save();
    
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
