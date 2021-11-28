<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "tbl_product";
    protected $primaryKey = "product_id"; 
    protected $keyType = 'string';

    public function cpu(){
        return $this->belongsTo('App\Models\CPU','cpu_id','product_id');
    }

    public function harddisk(){
        return $this->belongsTo('App\Models\HardDisk','harddisk_id','product_id');
    } 

    public function brand(){
        return $this->belongsTo('App\Models\Branch','branch_id','product_id');
    }

    public function ram(){
        return $this->belongsTo('App\Models\RAM','ram_id','product_id');
    }

    public function screen(){
        return $this->belongsTo('App\Models\Screen','screen_id','product_id');
    }

    public function card(){
        return $this->belongsTo('App\Models\Card','card_id','product_id');
    }

    public function machine_series(){
        return $this->belongsTo('App\Models\MachineSeries','class_id','product_id');
    }

    public function image_product(){
        return $this->hasMany('App\Models\ImagesProduct','product_id','product_id');
    }

    public function order(){
        return $this->belongsToMany(Order::class, 'tbl_orderdetail','product_id','order_id');
    }

}
