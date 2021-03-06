<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryCard;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\ulitilize\UUID;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CategoryCardResource;
use Illuminate\Http\Response;



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
                    ->get();
        return $categorycard;
    }

    public function get_categorycard_active()
    {
      $categorycard = DB::table('tbl_categorycard')
              ->whereNull('deleted_at')
              ->orderBy('category_card_name','asc')
              ->get();
      return $categorycard;
    }

    public function get_categorycard_deleted()
    {
      $categorycard = DB::table('tbl_categorycard')
              ->whereNotNull('deleted_at')
              ->orderBy('category_card_name','asc')
              ->get();
      return $categorycard;
    }

    public function get_count_categorycard_active()
    {
      $categorycard = DB::table('tbl_categorycard')
              ->whereNull('deleted_at')
              ->count();
      return $categorycard;
    }

    public function get_count_categorycard_deleted()
    {
      $categorycard = DB::table('tbl_categorycard')
              ->whereNotNull('deleted_at')
              ->count();
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
        foreach($request->all() as $item)
        {
            $categorycard = new CategoryCard();
            $category_card_id = new UUID();
            $categorycard->category_card_id= $category_card_id->gen_uuid();
            $categorycard->category_card_name=$item['category_card_name'];
            $result = $categorycard->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($category_card_id)
    {
        $categorycard = DB::table('tbl_categorycard')
              ->where('category_card_id','=',$category_card_id)
              ->first();
       if(!$categorycard)
       {
        return response()->json('Invalid categoru_card_id ',404);
       }
      return $categorycard;
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
    public function update(Request $request,  $category_card_id)
    {
        $category_card =  CategoryCard::where('category_card_id',$category_card_id);
        $result = $category_card->update($request->all());
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
    public function destroy(Request $request, $category_card_id)
    {
        if (CategoryCard::where('category_card_id',$category_card_id)->exists()) {
            $categorycard = CategoryCard::find($category_card_id);
            if($categorycard->deleted_at != NULL) return ["Result" => "???? x??a r???i"];
            $categorycard->deleted_at = Carbon::now();
            $categorycard->save();
    
            return response()->json([
              "message" => "Deleted successfully"
            ], 200);
          } else {
            return response()->json([
              "message" => "Error"
            ], 404);
          }
    }
}
