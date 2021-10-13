<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CPU;
use App\Models\HardDisk;
use App\Models\Brand;
use App\Models\RAM;
use App\Models\Screen;
use App\Models\Card;
use App\Models\MachineSeries;
use App\Models\ImageProduct;
use Illuminate\Support\Facades\DB;


class SearchController extends Controller
{
    public function search(Request $request)
    {
        $result = Product::with('image_product')
                ->join('tbl_cpu','tbl_cpu.cpu_id','=','tbl_product.cpu_id')
                ->join('tbl_harddisk','tbl_harddisk.harddisk_id','=','tbl_product.harddisk_id')
                ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
                ->join('tbl_ram','tbl_ram.ram_id','=','tbl_product.ram_id')
                ->join('tbl_screen','tbl_product.screen_id','=','tbl_screen.screen_id')
                ->join('tbl_card','tbl_product.card_id','=','tbl_card.card_id')
                ->join('tbl_class','tbl_product.class_id','=','tbl_class.class_id');

        if($name = $request->input('name'))
        {
            $result ->whereRaw("product_name LIKE '%". $name ."%'");
        }
        if($brand_id = $request->input('brand_id'))
        {
            $result ->whereRaw("tbl_product.brand_id = '". $brand_id . "'");
        }
        if($cpu_id = $request->input('cpu_id'))
        {
            $result ->whereRaw("tbl_product.cpu_id = '". $cpu_id . "'");
        }
        if($harddisk_id = $request->input('harddisk_id'))
        {
            $result ->whereRaw("tbl_product.harddisk_id = '".$harddisk_id."'");
        }
        if($ram_id = $request->input('ram_id'))
        {
            $result ->whereRaw("tbl_product.ram_id = '".$ram_id."'");
        }
        if($screen_id = $request->input('screen_id'))
        {
            $result ->whereRaw("tbl_product.screen_id = '".$screen_id."'");
        }
        if($card_id = $request->input('card_id'))
        {
            $result ->whereRaw("tbl_product.card_id = '".$card_id."'");
        }
        if($class_id = $request->input('class_id'))
        {
            $result ->whereRaw("tbl_product.class_id = '".$class_id."'");
        }
        if($price_min = $request->input('price_min') && $price_max = $request->input('price_max'))
        {
            $result ->whereRaw("price > ".$price_min." and price <".$price_max);
        }
        if($product_id = $request->input('product_id'))
        {
            $result ->whereRaw("tbl_product.product_id = '".$product_id."'");
        }
        $product =  $result->select('tbl_product.product_id','product_name','cpu_name','capacity_harddisk','brand_name','ram_detail','card_detail','class_name','screen_detail','mass',
        'price','discount','product_detail','tbl_product.created_at','tbl_product.deleted_at','tbl_product.updated_at')
        ->paginate(10);
        return $product;
    }
}
