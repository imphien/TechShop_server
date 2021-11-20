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
                ->join('tbl_class','tbl_product.class_id','=','tbl_class.class_id')
                ->join('tbl_categorycpu','tbl_categorycpu.category_cpu_id','=','tbl_cpu.category_cpu_id')
                ->join('tbl_categoryharddisk','tbl_categoryharddisk.category_harddisk_id','=','tbl_harddisk.category_harddisk_id')
                ->join('tbl_capacityram','tbl_capacityram.capacity_ram_id','=','tbl_ram.capacity_ram_id')
                ->join('tbl_categoryscreen','tbl_categoryscreen.category_screen_id','=','tbl_screen.category_screen_id')
                ->join('tbl_categorycard','tbl_categorycard.category_card_id','=','tbl_card.category_card_id');

        if($name = $request->input('name'))
        {
            $result ->whereRaw("product_name LIKE '%". $name ."%'");
        }
        if($brand = $request->input('brand'))
        {
            $result ->whereRaw("tbl_brand.brand_name = '". $brand . "'");
        }
        if($cpu = $request->input('cpu'))
        {
            $result ->whereRaw("tbl_categorycpu.category_cpu_name = '". $cpu . "'");
        }
        if($disk = $request->input('disk'))
        {
            $result ->whereRaw("tbl_categoryharddisk.category_harddisk_name = '".$disk."'");
        }
        if($ram = $request->input('ram'))
        {
            $result ->whereRaw("tbl_capacityram.capacity_ram = '".$ram."'");
        }
        if($screen_size = $request->input('screen_size'))
        {
            $result ->whereRaw("tbl_categoryscreen.screen_size = '".$screen_size."'");
        }
        if($card = $request->input('card'))
        {
            $result ->whereRaw("tbl_categorycard.category_card_id = '".$card."'");
        }
        if($type = $request->input('type'))
        {
            $result ->whereRaw("tbl_product.class_id = '".$type."'");
        }
        if($price_min = $request->input('price_min') )
        {
            $result ->whereRaw("price >= ".$price_min);
        }
        if($price_max = $request->input('price_max') )
        {
            $result ->whereRaw("price <= ".$price_max);
        }
        if($product_id = $request->input('product_id'))
        {
            $result ->whereRaw("tbl_product.product_id = '".$product_id."'");
        }
        if($sort = $request->input('sort:price'))
        {
            $result ->orderByRaw("price ".$sort);
        }
        if($sort = $request->input('sort:name'))
        {
            $result ->orderByRaw("product_name ".$sort);
        }
        if($ignore = $request->input('ignore_id'))
        {
            $result ->whereRaw("tbl.product.product_id <> '".$ignore."'");
        }
        if($isPromotion = $request->input('isPromotion'))
        {
            $isPromotion == 'true' ? $result ->whereRaw("tbl_product.discount > 0") :  $result ->whereRaw("1=1");
        }
        $product =  $result
                    ->whereNull('tbl_product.deleted_at')
                    ->select('tbl_product.product_id','product_name','cpu_name','capacity_harddisk','brand_name','ram_detail','card_detail','class_name','screen_detail','mass',
        'price','discount','product_detail','tbl_product.created_at','tbl_product.deleted_at','tbl_product.updated_at')
        ->paginate(20);
        return $product;
    }
}
