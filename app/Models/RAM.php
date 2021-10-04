<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RAM extends Model
{
    protected $table = "tbl_ram";
    protected $primaryKey = "ram_id";

    public function product()
    {
        return $this->hasMany('App\Models\Product','ram_id','ram_id');
    }

    public function capacity_ram()
    {
        return $this->belongsTo('App\Models\CapacityRam','capacity_ram_id','ram_id');
    }
}
