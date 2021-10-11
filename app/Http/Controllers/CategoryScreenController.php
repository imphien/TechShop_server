<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryScreen;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\ulitilize\UUID;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class CategoryScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoryscreen = DB::table('tbl_categoryscreen')
        ->get();
        return $categoryscreen;
    }

    public function get_categoryscreen_active()
    {
      $categoryscreen = DB::table('tbl_categoryscreen')
              ->whereNull('deleted_at')
              ->orderBy('screen_size','asc')
              ->get();
      return $categoryscreen;
    }

    public function get_categoryscreen_deleted()
    {
      $categoryscreen = DB::table('tbl_categoryscreen')
              ->whereNotNull('deleted_at')
              ->orderBy('screen_size','asc')
              ->get();
      return $categoryscreen;
    }

    public function get_count_categoryscreen_active()
    {
      $categoryscreen = DB::table('tbl_categoryscreen')
              ->whereNull('deleted_at')
              ->count();
      return $categoryscreen;
    }

    public function get_count_categoryscreen_deleted()
    {
      $categoryscreen = DB::table('tbl_categoryscreen')
              ->whereNotNull('deleted_at')
              ->count();
      return $categoryscreen;
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
        $categoryscreen = new CategoryScreen;
        $category_screen_id = new UUID();
        $categoryscreen->category_screen_id = $category_screen_id->gen_uuid();
        $categoryscreen->screen_size=$item['screen_size'];
        $result = $categoryscreen->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($category_screen_id)
    {
        $categoryscreen = DB::table('tbl_categoryscreen')
              ->where('category_screen_id','=',$category_screen_id)
              ->first();
       if(!$categoryscreen)
       {
        return response()->json('Invalid category_screen_id ',404);
       }
      return $categoryscreen;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $category_screen_id)
    {
        $category_screen =  CategoryScreen::where('category_screen_id',$category_screen_id);
        $result = $category_screen->update($request->all());
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
    public function destroy(Request $request, $category_screen_id)
    {
        if (CategoryScreen::where('category_screen_id',$category_screen_id)->exists()) {
            $category_screen= CategoryScreen::find($category_screen_id);
            if($category_screen->deleted_at != NULL) return ["Result" => "Category_screen deleted"];
            $category_screen->deleted_at = Carbon::now();
            $category_screen->save();
    
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
