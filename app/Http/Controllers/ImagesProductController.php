<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImagesProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ImagesProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = DB::table('tbl_imagesproduct')
                ->simplePaginate(10);
         return $images;
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
        $imageProduct = new ImagesProduct;
        $imageProduct->image_id = 'image'.time();
        $imageProduct->product_id = $request->product_id;
        $imageProduct->url=$request->url;
        $result = $imageProduct->save();
        if( $result)
        {
            return ["Result"=>"Data has been saved"];
        }else
        {
            return ["Result"=>"Error"];
        }  
    }

    public function upload(Request $request)
    {
        $result = $request->file('file')->store('public/images');
        return ["result"=>$result];
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    
}
