<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CapacityRam extends Model
{
    protected $table = "tbl_capacityram";
    protected $primaryKey = "capacity_ram_id";

    public function ram()
    {
        return $this->hasMany('App\Models\RAM','capacity_ram_id','capacity_ram_id');
    }
}
