<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagesProduct extends Model
{
    protected $table = "tbl_imagesproduct";
    protected $primaryKey = "image_id";
    protected $hidden = ['image_id','product_id','created_at','deleted_at','updated_at'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id','image_id');
    }
}
