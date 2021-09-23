<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MachineSeries;

class MachineSeriesController extends Controller
{
    function list($id = null){
        return $id?MachineSeries::find($id):MachineSeries::all();
    }
}
