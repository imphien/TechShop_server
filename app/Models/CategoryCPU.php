<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryCPU extends Model
{
    protected $table = "tbl_categorycpu";
    protected $primaryKey = "category_cpu_id";

    public function cpu()
    {
        return $this->hasMany('App\Models\CPU','category_cpu_id','category_cpu_id');
    }
}
