<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryCard extends Model
{
    protected $table = "tbl_categorycard";

    public function card()
    {
        return $this->hasMany('App\Models\Card','category_card_id','category_card_id');
    }
}
