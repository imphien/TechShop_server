<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryCard;
use App\Models\Card;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\ulitilize\UUID;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CategoryCardResource;
use Illuminate\Http\Response;


class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $card = DB::table('tbl_card')
                ->get();
        return $card;
    }

    public function get_card_active()
    {
      $card = DB::table('tbl_card')
              ->whereNull('deleted_at')
              ->select('card_id','card_detail')
              ->orderBy('card_detail','asc')
              ->get();
      return $card;
    }

    public function get_card_deleted()
    {
      $card = DB::table('tbl_card')
              ->whereNotNull('deleted_at')
              ->select('card_id','card_detail')
              ->orderBy('card_detail','asc')
              ->get();
      return $card;
    }

    public function get_count_card_active()
    {
      $card = DB::table('tbl_card')
              ->whereNull('deleted_at')
              ->count();
      return $card;
    }

    public function get_count_card_deleted()
    {
      $card = DB::table('tbl_card')
              ->whereNotNull('deleted_at')
              ->count();
      return $card;
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
            "category_card_id"=>[
                'required',
                Rule::exists('tbl_categorycard')->where(function ($query) {
                    $query->get('category_card_id');
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
                $card = new Card;
                $card_id = new UUID();
                $card->card_id = $card_id->gen_uuid();
                $card->category_card_id=$item['category_card_id'];
                $card->card_detail=$item['card_detail'];
    
                $card->save();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($card_id)
    {
        $card = DB::table('tbl_card')
        ->where('card_id','=',$card_id)
        ->first();
        if(!$card)
        {
        return response()->json('Invalid card_id ',404);
        }
        return $card;
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
    public function update(Request $request, $card_id)
    {
        $rules = array(
            "category_card_id"=>[
                Rule::exists('tbl_categorycard')->where(function ($query) {
                    $query->get('category_card_id');
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
            $card =  Card::where('card_id',$card_id);
            $result = $card->update($request->all());
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $card_id)
    {
        if (Card::where('card_id',$card_id)->exists()) {
            $card= Card::find($card_id);
            if($card->deleted_at != NULL) return ["Result" => "Card deleted"];
            $card->deleted_at = Carbon::now();
            $card->save();
    
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
