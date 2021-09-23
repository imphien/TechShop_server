<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = "tbl_brand";
    protected $primaryKey = 'brand_id';

    public function product()
    {
        return $this->hasMany('App\Models\Product','brand_id','brand_id');
    }
}
