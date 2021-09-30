<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CPU extends Model
{
    protected $table = "tbl_cpu";
    protected $primaryKey = "cpu_id";

    public function product()
    {
        return $this->hasMany('App\Models\Product','cpu_id','cpu_id');
    }

    public function category_cpu()
    {
        return $this->belongsTo('App\Models\CategoryCPU','category_cpu_id','cpu_id');
    }
}
