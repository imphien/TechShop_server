<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Screen;
use App\Models\CategoryScreen;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\ulitilize\UUID;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;


class ScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $screen = DB::table('tbl_screen')
                    ->get();
        return $screen;
    }

    public function get_screen_active()
    {
      $screen = DB::table('tbl_screen')
              ->whereNull('deleted_at')
              ->select('screen_id','screen_detail','created_at','deleted_at','updated_at')
              ->orderBy('screen_detail','asc')
              ->get();
      return $screen;
    }

    public function get_screen_deleted()
    {
      $screen = DB::table('tbl_screen')
              ->whereNotNull('deleted_at')
              ->select('screen_id','screen_detail','created_at','deleted_at','updated_at')
              ->orderBy('screen_detail','asc')
              ->get();
      return $screen;
    }

    public function get_count_screen_active()
    {
      $screen = DB::table('tbl_screen')
              ->whereNull('deleted_at')
              ->count();
      return $screen;
    }

    public function get_count_screen_deleted()
    {
      $screen = DB::table('tbl_screen')
              ->whereNotNull('deleted_at')
              ->count();
      return $screen;
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
        $rules = array(
            "category_screen_id"=>[
                'required',
                Rule::exists('tbl_categoryscreen')->where(function ($query) {
                    $query->get('category_screen_id');
                }),
            ]
        );
        $index = [];
        $i = 0;
        foreach($request->all() as $item)
        {
            $i++;
            $validator = Validator::make($item,$rules);
            
            if($validator->fails())
            {
                array_push($index,$i);
                continue;
            }
            else
            {
                $screen = new Screen;
                $screen_id = new UUID();
                $screen->screen_id=$screen_id->gen_uuid();
                $screen->category_screen_id=$item['category_screen_id'];
                $screen->screen_detail=$item['screen_detail'];

                $screen->save();
            }
        }
        $errors_index = '';
        foreach($index as $i)
        {
            $errors_index = $errors_index.$i.' ';
        }
        if($errors_index == '')
            return response()->json(["message"=>"Data has been saved "],200);
        return response()->json(["message"=>"Invalid category_screen_id in position ".$errors_index." in payload"],404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($screen_id)
    {
        $screen = DB::table('tbl_screen')
        ->where('screen_id','=',$screen_id)
        ->first();
        if(!$screen)
        {
        return response()->json('Invalid screen_id ',404);
        }
        return $screen;
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
    public function update(Request $request, $screen_id)
    {
        $rules = array(
            "category_screen_id"=>[
                Rule::exists('tbl_categoryscreen')->where(function ($query) {
                    $query->get('category_screen_id');
                }),
            ]
        );
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return response()->json($validator->errors(),404);
        }
        else
        {
            $screen =  Screen::where('screen_id',$screen_id);
            $result = $screen->update($request->all());
            if( $result)
            {
                return response()->json([
                    "message" => " Data has been saved"
                  ], 200);
            }
            else
            {
                return response()->json([
                    "message" => "Book not found"
                  ], 404);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,  $screen_id)
    {
        
       
        if (Screen::where('screen_id', $screen_id)->exists()) {
            $screen = Screen::find($screen_id);
    
            if($screen->deleted_at != NULL) return ["Result" => "Screen deleted"];
            $screen->deleted_at = Carbon::now();
            $screen->save();
    
            return response()->json([
              "message" => " Deleted successfully"
            ], 200);
          } else {
            return response()->json([
              "message" => "Book not found"
            ], 404);
          }
         
    }
}
