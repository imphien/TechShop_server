<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagesProduct extends Model
{
    protected $table = "tbl_imagesproduct";

    public function product()
    {
        return $this->belongsTo('App\Models\Product','image_id','image_id');
    }
}
