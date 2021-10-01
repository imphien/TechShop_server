<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\CategoryCard;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoryCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorycard = DB::table('tbl_categorycard')
                    ->simplePaginate(10);
        return $categorycard;
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
        $categorycard = new CategoryCard;
            $categorycard->category_card_id='category_card'.time();
            $categorycard->category_card_name=$request->category_card_name;
            $result = $categorycard->save();
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
    public function update(Request $request, CategoryCard $category_card_id)
    {
        $categorycard = CategoryCard::find($request->category_card_id);
        $categorycard->category_card_name=$request->category_card_name;
        $result = $categorycard->save();
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
    public function destroy(Request $request, CategoryCard $category_card_id)
    {
        $categorycard = CategoryCard::find($request->category_card_id);
        $categorycard->deleted_at=Carbon::now();
        $result = $categorycard->save();
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
