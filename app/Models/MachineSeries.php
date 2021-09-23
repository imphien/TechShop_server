<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineSeries extends Model
{
    protected $table = "tbl_class";
    protected $primaryKey = 'class_id';

    public function product()
    {
        return $this->hasMany('App\Models\Product','class_id','class_id');
    }
}
