<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = "tbl_card";

    public function product()
    {
        return $this->hasMany('App\Models\Product','card_id','card_id');
    }

    public function category_card()
    {
        return $this->belongsTo('App\Models\CategoryCard','category_card_id','card_id');
    }
}
