<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    protected $table = "tbl_screen";

    public function product()
    {
        return $this->hasMany('App\Models\Product','screen_id','screen_id');
    }

    public function category_screen()
    {
        return $this->belongsTo('App\Models\CategoryScreen','category_screen_id','screen_id');
    }
}
