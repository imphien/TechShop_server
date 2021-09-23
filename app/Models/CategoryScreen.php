<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryScreen extends Model
{
    protected $table = "tbl_categoryscreen";

    public function screen()
    {
        return $this->hasMany('App\Models\Screen','category_screen_id','category_screen_id');
    }
}
