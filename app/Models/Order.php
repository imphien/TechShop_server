<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "tbl_order";

    public function product(){
        return $this->belongsToMany('App\Models\Product','tbl_orderdetail','order_id','product_id');
    }
}
