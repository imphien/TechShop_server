<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\ulitilize\UUID;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;



class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function get_newest_article()
    {
        $result = DB::table('tbl_news')
                    ->whereNull('deleted_at')
                    ->orderby('created_at','desc')
                    ->first();
        return $result->news_id;
    }
    public function get_article()
    {
        $ignore = $this->get_newest_article();
        $result = DB::table('tbl_news')
                    ->whereNull('deleted_at')
                    ->whereRaw("news_id <>'".$ignore."'")
                    ->orderby('created_at','desc')
                    ->paginate(1);
        return $result;
    }

    public function get_article_deleted()
    {
        $result = DB::table('tbl_news')
                    ->whereNotNull('deleted_at')
                    ->orderby('created_at','desc')
                    ->get();
        return $result;
    }

    public function get_count()
    {
        $result = DB::table('tbl_news')
                    ->whereNull('deleted_at')
                    ->count();
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
        foreach ($request->all() as $item) 
            {
                $news = new News();
                $uuid = new UUID();
                $news->news_id = $uuid->gen_uuid();
                $news->title = $item['title'];
                $news->thumbnail = $item['thumbnail'];
                $news->author = $item['author'];
                $news->short_description = $item['short_description'];
                $news->content = $item['content'];
                $result=$news->save();
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($news_id)
    {
        $article = DB::table('tbl_news')
              ->where('news_id','=',$news_id)
              ->first();
       if(!$article)
       {
        return response()->json('Invalid new_id ',404);
       }
      return $article;
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
    public function update(Request $request, $news_id)
    {
        $article =  News::where('news_id',$news_id);
        $result = $article->update($request->all());
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
    public function destroy($news_id)
    {
        if (News::where('news_id',$news_id)->exists()) {
            $article = News::find($news_id);
            if($article->deleted_at != NULL) return ["Result" => "Đã xóa rồi"];
            $article->deleted_at = Carbon::now();
            $article->save();
    
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
