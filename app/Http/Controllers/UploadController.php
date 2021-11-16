<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        if($request->hasFile('image')){ 
            $tmp = $request->file('image');
            $image = array();
            foreach($tmp as $value)
            {
                $get_name_image = $value->getClientOriginalName();
                $new_name = current(explode('.',$get_name_image));
                $new_image = $new_name.rand(0,99).'.'.$value->getClientOriginalExtension();
                $value->move('upload',$new_image);
                array_push($image, (object)[
                    'url' => $new_image , 
                ]);
            }
            return $image;
        }

        if($request->hasFile('thumbnail'))
        {
            $image_thumbnail = $request->file('thumbnail');
            $get_name_thumbnail = $image_thumbnail->getClientOriginalName();
            $new_name_thumbnail = current(explode('.',$get_name_thumbnail));
            $new_image_thumbnail = $new_name_thumbnail.rand(0,99).'.'.$image_thumbnail->getClientOriginalExtension();
            $image_thumbnail->move('upload',$new_image_thumbnail);
            return $new_image_thumbnail;
        }

    }
}
