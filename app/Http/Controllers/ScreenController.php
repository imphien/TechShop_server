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
                    ->simplePaginate(10);
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
        
        foreach($request->all() as $item)
        {
            $validator = Validator::make($item,$rules);
            
            if($validator->fails())
            {
                return response()->json($validator->errors(),404);
            }
            else
            {
                $screen = new Screen;
                $screen_id = new UUID();
                $screen->screen_id=$screen_id->gen_uuid();
                $screen->category_screen_id=$item['category_screen_id'];
                $screen->screen_detail=$item['screen_detail'];

                $result = $screen->save();
            }
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
