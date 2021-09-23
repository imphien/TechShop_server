<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardDisk extends Model
{
    protected $table = "tbl_harddisk";

    public function product()
    {
        return $this->hasMany('App\Models\Product','harddisk_id','harddisk_id');
    }

    public function category_harddick()
    {
        return $this->belongsTo('App\Models\CategoryHardDisk','category_harddisk_id','harddisk_id');
    }
}
