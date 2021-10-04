<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\ulitilize\UUID;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BrandResource;
use App\Http\Resources\BrandCollection;


class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brand = DB::table('tbl_brand')
                    ->simplePaginate(10);
        return $brand;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
            foreach ($request->all() as $item) 
            {
                $brand = new Brand();
                $uuid = new UUID();
                $brand->brand_id = $uuid->gen_uuid();
                $brand->brand_name = $item['brand_name'];
                $result=$brand->save();
            }
           
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
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
    public function update(Request $request, Brand $brand_id)
    {
        $brand = Brand::find($brand_id);
         $brand->brand_name=$request->brand_name;
        $result = $brand->save();
        if( $result)
        {
            return ["Result"=>"Data has been saved"];
        }
        else
        {
            return ["Result"=>"Error"];
        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $brand_id)
    {
        if (Brand::where('brand_id',$brand_id)->exists()) {
            $brand = Brand::find($brand_id);
            if($brand->deleted_at != NULL) return ["Result" => "Đã xóa rồi"];
            $brand->deleted_at = Carbon::now();
            $brand->save();
    
            return response()->json([
              "message" => "records updated successfully"
            ], 200);
          } else {
            return response()->json([
              "message" => "Book not found"
            ], 404);
          }

       
    }
}
