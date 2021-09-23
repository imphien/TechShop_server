<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryHardDisk extends Model
{
    protected $table = "tbl_categoryharddisk";

    public function harddisk()
    {
        return $this->hasMany('App\Models\HardDisk','harddisk_cpu_id','harddisk_cpu_id');
    }
}
