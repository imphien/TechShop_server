<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "tbl_order";
    protected $primaryKey = "order_id";
    protected $keyType = 'string';
    //protected $hidden = array('privot.product_id');

    public function product(){
         return $this->belongsToMany(Product::class,'tbl_orderdetail','order_id','product_id')->select(array('product_name','price'))->withPivot('quantity');
    }

    
}
