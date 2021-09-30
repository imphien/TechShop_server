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
use App\Http\Resources\ProdcutResource;
use App\Http\Resources\ProductCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;




class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ProductCollection(Product::paginate(10));
    }

    public function countProduct()
    {
        $countProduct = DB::table('tbl_product')->count();
        return $countProduct;
    }

    public function get_product_deleted()
    {
        $product_deleted = DB::table('tbl_product')
                                    ->join('tbl_cpu','tbl_cpu.cpu_id','=','tbl_product.cpu_id')
                                    ->join('tbl_harddisk','tbl_harddisk.harddisk_id','=','tbl_product.harddisk_id')
                                    ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
                                    ->join('tbl_ram','tbl_ram.ram_id','=','tbl_product.ram_id')
                                    ->join('tbl_screen','tbl_product.screen_id','=','tbl_screen.screen_id')
                                    ->join('tbl_card','tbl_product.card_id','=','tbl_card.card_id')
                                    ->join('tbl_class','tbl_product.class_id','=','tbl_class.class_id')
                                    ->join('tbl_imagesproduct','tbl_product.product_id','=','tbl_imagesproduct.product_id')
                                    ->whereNotNull('tbl_product.deleted_at')
                                    ->select('product_name','cpu_name','capacity_harddisk','brand_name','ram_detail','card_detail','class_name','screen_detail','mass',
                                    'price','discount','product_detail','url')
                                    ->simplePaginate(10);;
        return $product_deleted;
    }

    public function get_product_not_deleted()
    {
        $product_not_deleted = DB::table('tbl_product')
                                    ->join('tbl_cpu','tbl_cpu.cpu_id','=','tbl_product.cpu_id')
                                    ->join('tbl_harddisk','tbl_harddisk.harddisk_id','=','tbl_product.harddisk_id')
                                    ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
                                    ->join('tbl_ram','tbl_ram.ram_id','=','tbl_product.ram_id')
                                    ->join('tbl_screen','tbl_product.screen_id','=','tbl_screen.screen_id')
                                    ->join('tbl_card','tbl_product.card_id','=','tbl_card.card_id')
                                    ->join('tbl_class','tbl_product.class_id','=','tbl_class.class_id')
                                    ->join('tbl_imagesproduct','tbl_product.product_id','=','tbl_imagesproduct.product_id')
                                    ->whereNull('tbl_product.deleted_at')
                                    ->select('product_name','cpu_name','capacity_harddisk','brand_name','ram_detail','card_detail','class_name','screen_detail','mass',
                                    'price','discount','product_detail','url')
                                    ->simplePaginate(10);
                                    
        return $product_not_deleted;
    }

    public function get_product_detail()
    {
        $product_detail = DB::table('tbl_product')
        ->join('tbl_cpu','tbl_cpu.cpu_id','=','tbl_product.cpu_id')
        ->join('tbl_harddisk','tbl_harddisk.harddisk_id','=','tbl_product.harddisk_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->join('tbl_ram','tbl_ram.ram_id','=','tbl_product.ram_id')
        ->join('tbl_screen','tbl_product.screen_id','=','tbl_screen.screen_id')
        ->join('tbl_card','tbl_product.card_id','=','tbl_card.card_id')
        ->join('tbl_class','tbl_product.class_id','=','tbl_class.class_id')
        ->join('tbl_imagesproduct','tbl_product.product_id','=','tbl_imagesproduct.product_id')
        ->select('product_name','cpu_name','capacity_harddisk','brand_name','ram_detail','card_detail','class_name','screen_detail','mass',
        'price','discount','product_detail','url')
        ->simplePaginate(10);
        
        return $product_detail;
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            "product_name" => 'required',
            "cpu_id"=>[
                'required',
                Rule::exists('tbl_cpu')->where(function ($query) {
                    $query->get('tbl_cpu.cpu_id');
                }),
            ],
            "harddisk_id"=>[
                'required',
                Rule::exists('tbl_harddisk')->where(function ($query) {
                    $query->get('tbl_harddisk.harddisk_id');
                }),
            ],
            "brand_id"=>[
                'required',
                Rule::exists('tbl_brand')->where(function ($query) {
                    $query->get('tbl_brand.brand_id');
                }),
            ],
            "ram_id"=>[
                'required',
                Rule::exists('tbl_ram')->where(function ($query) {
                    $query->get('tbl_ram.ram_id');
                }),
            ],
            "screen_id"=>[
                'required',
                Rule::exists('tbl_screen')->where(function ($query) {
                    $query->get('tbl_screen.screen_id');
                }),
            ],
            "card_id"=>[
                'required',
                Rule::exists('tbl_card')->where(function ($query) {
                    $query->get('tbl_card.card_id');
                }),
            ],
            "class_id"=>[
                'required',
                Rule::exists('tbl_class')->where(function ($query) {
                    $query->get('tbl_class.class_id');
                }),
            ],
            "mass" => 'required|numeric',
            "size" => 'required',
            "camera" => 'required',
            "price" => 'required|numeric',
            "discount" => 'required|numeric',
            "product_detail" => 'required'
        );
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->errors();
        }
        else
        {
            $product = new Product;
            $product->product_id='product'.time();
            $product->product_name=$request->product_name;
            $product->cpu_id=$request->cpu_id;
            $product->harddisk_id=$request->harddisk_id;
            $product->brand_id=$request->brand_id;
            $product->ram_id=$request->ram_id;
            $product->screen_id=$request->screen_id;
            $product->card_id=$request->card_id;
            $product->class_id=$request->class_id;
            $product->mass=$request->mass;
            $product->size=$request->size;
            $product->camera=$request->camera;
            $product->price=$request->price;
            $product->discount=$request->discount;
            $product->product_detail=$request->product_detail;

            $result = $product->save();
            if( $result)
            {
                return ["Result"=>"Data has been saved"];
            }
            else
            {
                return ["Result"=>"Error"];
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Product $product_id)
    {
        $rules = array(
            "cpu_id"=>[
                Rule::exists('tbl_cpu')->where(function ($query) {
                    $query->get('tbl_cpu.cpu_id');
                }),
            ],
            "harddisk_id"=>[
                Rule::exists('tbl_harddisk')->where(function ($query) {
                    $query->get('tbl_harddisk.harddisk_id');
                }),
            ],
            "brand_id"=>[
                Rule::exists('tbl_brand')->where(function ($query) {
                    $query->get('tbl_brand.brand_id');
                }),
            ],
            "ram_id"=>[
                Rule::exists('tbl_ram')->where(function ($query) {
                    $query->get('tbl_ram.ram_id');
                }),
            ],
            "screen_id"=>[
                Rule::exists('tbl_screen')->where(function ($query) {
                    $query->get('tbl_screen.screen_id');
                }),
            ],
            "card_id"=>[
                Rule::exists('tbl_card')->where(function ($query) {
                    $query->get('tbl_card.card_id');
                }),
            ],
            "class_id"=>[
                Rule::exists('tbl_class')->where(function ($query) {
                    $query->get('tbl_class.class_id');
                }),
            ],
            "mass" => 'numeric',
            "price" => 'numeric',
            "discount" => 'numeric',
        );
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->errors();
        }
        else
        {
            $product = Product::find($request->product_id);
            $product->product_name=$request->product_name;
            $product->cpu_id=$request->cpu_id;
            $product->harddisk_id=$request->harddisk_id;
            $product->brand_id=$request->brand_id;
            $product->ram_id=$request->ram_id;
            $product->screen_id=$request->screen_id;
            $product->card_id=$request->card_id;
            $product->class_id=$request->class_id;
            $product->mass=$request->mass;
            $product->size=$request->size;
            $product->camera=$request->camera;
            $product->price=$request->price;
            $product->discount=$request->discount;
            $product->product_detail=$request->product_detail;

            $result = $product->save();
            if( $result)
            {
                return ["Result"=>"Data has been saved"];
            }
            else
            {
                return ["Result"=>"Error"];
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Product $product_id)
    {
        $product = Product::find($request->product_id);
        $product->deleted_at= Carbon::now();
        $result = $product->save();
        if( $result)
        {
            return ["Result"=>"Data has been delete"];
        }else
        {
            return ["Result"=>"Error"];
        }
    }
}
