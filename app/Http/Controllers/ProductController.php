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
use App\Models\ImagesProduct;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\ulitilize\UUID;
use Illuminate\Http\Response;
use App\Http\Controllers\PaginationController;





class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Product $product)
    {
        $product = Product::with('image_product')
                            ->join('tbl_cpu','tbl_cpu.cpu_id','=','tbl_product.cpu_id')
                            ->join('tbl_harddisk','tbl_harddisk.harddisk_id','=','tbl_product.harddisk_id')
                            ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
                            ->join('tbl_ram','tbl_ram.ram_id','=','tbl_product.ram_id')
                            ->join('tbl_screen','tbl_product.screen_id','=','tbl_screen.screen_id')
                            ->join('tbl_card','tbl_product.card_id','=','tbl_card.card_id')
                            ->join('tbl_class','tbl_product.class_id','=','tbl_class.class_id')
                            ->select('tbl_product.product_id','product_name','cpu_name','capacity_harddisk','brand_name','ram_detail','card_detail','class_name','screen_detail','mass',
                            'price','discount','product_detail','tbl_product.created_at','tbl_product.deleted_at','tbl_product.updated_at')
                            ->paginate(10);
        return $product;


    }

    public function count_Product()
    {
        $countProduct = DB::table('tbl_product')->count();
        return $countProduct;
    }

    public function get_product_deleted_count()
    {
        $countProduct =  $product_deleted = DB::table('tbl_product')
                        ->whereNotNull('deleted_at')
                        ->count();
        return $countProduct;
    }

    public function get_product_active_count()
    {
        $countProduct =  $product_deleted = DB::table('tbl_product')
                        ->whereNull('deleted_at')
                        ->count();
        return $countProduct;
    }


    public function get_product_deleted()
    {
        $product_deleted = Product::with('image_product')
                                    ->join('tbl_cpu','tbl_cpu.cpu_id','=','tbl_product.cpu_id')
                                    ->join('tbl_harddisk','tbl_harddisk.harddisk_id','=','tbl_product.harddisk_id')
                                    ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
                                    ->join('tbl_ram','tbl_ram.ram_id','=','tbl_product.ram_id')
                                    ->join('tbl_screen','tbl_product.screen_id','=','tbl_screen.screen_id')
                                    ->join('tbl_card','tbl_product.card_id','=','tbl_card.card_id')
                                    ->join('tbl_class','tbl_product.class_id','=','tbl_class.class_id')
                                    ->whereNotNull('tbl_product.deleted_at')
                                    ->select('tbl_product.product_id','product_name','cpu_name','capacity_harddisk','brand_name','ram_detail','card_detail','class_name','screen_detail','mass',
                                    'price','discount','product_detail','tbl_product.created_at','tbl_product.deleted_at','tbl_product.updated_at')
                                    ->paginate(10);
        return $product_deleted;
    }

    public function get_product_active()
    {
        $product_not_deleted = Product::with('image_product')
                                    ->join('tbl_cpu','tbl_cpu.cpu_id','=','tbl_product.cpu_id')
                                    ->join('tbl_harddisk','tbl_harddisk.harddisk_id','=','tbl_product.harddisk_id')
                                    ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
                                    ->join('tbl_ram','tbl_ram.ram_id','=','tbl_product.ram_id')
                                    ->join('tbl_screen','tbl_product.screen_id','=','tbl_screen.screen_id')
                                    ->join('tbl_card','tbl_product.card_id','=','tbl_card.card_id')
                                    ->join('tbl_class','tbl_product.class_id','=','tbl_class.class_id')
                                    ->whereNull('tbl_product.deleted_at')
                                    ->select('tbl_product.product_id','product_name','cpu_name','capacity_harddisk','brand_name','ram_detail','card_detail','class_name','screen_detail','mass',
                                    'price','discount','product_detail','tbl_product.created_at','tbl_product.deleted_at','tbl_product.updated_at')
                                    ->paginate(10);
        return $product_not_deleted;
                                    
    }

    public function get_product_detail()
    {

        $product_detail = Product::with('image_product')
                ->join('tbl_cpu','tbl_cpu.cpu_id','=','tbl_product.cpu_id')
                ->join('tbl_harddisk','tbl_harddisk.harddisk_id','=','tbl_product.harddisk_id')
                ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
                ->join('tbl_ram','tbl_ram.ram_id','=','tbl_product.ram_id')
                ->join('tbl_screen','tbl_product.screen_id','=','tbl_screen.screen_id')
                ->join('tbl_card','tbl_product.card_id','=','tbl_card.card_id')
                ->join('tbl_class','tbl_product.class_id','=','tbl_class.class_id')
                ->select('tbl_product.product_id','product_name','cpu_name','capacity_harddisk','brand_name','ram_detail','card_detail','class_name','screen_detail','mass',
                'price','discount','product_detail','tbl_product.created_at','tbl_product.deleted_at','tbl_product.updated_at')
                 ->paginate(10);
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
        $index = [];
        $i = 0;
        foreach($request->all() as $item)
        {
            $i++;
            $validator = Validator::make($item,$rules);
            if($validator->fails())
            {
                array_push($index,$i);
                continue;
            }
            else{
                
                $product = new Product;

                $product_id = new UUID();
                $temp = $product_id->gen_uuid() ;
                $product->product_id = $temp;
                $product->product_name=$item['product_name'];
                $product->cpu_id=$item['cpu_id'];
                $product->harddisk_id=$item['harddisk_id'];
                $product->brand_id=$item['brand_id'];
                $product->ram_id=$item['ram_id'];
                $product->screen_id=$item['screen_id'];
                $product->card_id=$item['card_id'];
                $product->class_id=$item['class_id'];
                $product->mass=$item['mass'];
                $product->size=$item['size'];
                $product->camera=$item['camera'];
                $product->price=$item['price'];
                $product->discount=$item['discount'];
                $product->product_detail=$item['product_detail'];
                
                $result = $product->save();

                foreach($item['images'] as $img)
                {
                    $image = new ImagesProduct();
                    $image_id = new UUID();
                    $image->image_id = $image_id->gen_uuid();
                    $image->product_id = $temp;
                    $image->url = $img['url'];
                    $image->save();
                }
            }
            
        }
        $errors_index = '';
        foreach($index as $i)
        {
            $errors_index = $errors_index.$i.' ';
        }
        if($errors_index == '')
            return response()->json(["message"=>"Data has been saved "],200);
        return response()->json(["message"=>"Invalid data in position ".$errors_index." in payload"],404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($product_id)
    {
        $product_detail =  Product::with('image_product')
                        ->where('product_id','=',$product_id)
                        ->get()->first();
        if(!$product_detail)
        {
        return response()->json('Invalid product_id ',404);
        }
        return $product_detail;
       
    }

    public function showdetail($product_id)
    {
        $product_detail =Product::with('image_product')
                                ->join('tbl_cpu','tbl_cpu.cpu_id','=','tbl_product.cpu_id')
                                ->join('tbl_harddisk','tbl_harddisk.harddisk_id','=','tbl_product.harddisk_id')
                                ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
                                ->join('tbl_ram','tbl_ram.ram_id','=','tbl_product.ram_id')
                                ->join('tbl_screen','tbl_product.screen_id','=','tbl_screen.screen_id')
                                ->join('tbl_card','tbl_product.card_id','=','tbl_card.card_id')
                                ->join('tbl_class','tbl_product.class_id','=','tbl_class.class_id')
                                ->where('product_id','=',$product_id)
                                ->select('tbl_product.product_id','product_name','cpu_name','capacity_harddisk','brand_name','ram_detail','card_detail','class_name','screen_detail','mass',
                                'price','discount','product_detail','tbl_product.created_at','tbl_product.deleted_at','tbl_product.updated_at')
                                ->get()->first();
        if(!$product_detail)
        {
        return response()->json('Invalid product_id ',404);
        }
        return $product_detail;
       
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
    public function update(Request $request, $product_id)
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
            return response()->json($validator->errors(),404);
        }
        else
        {
            $product =  Product::where('product_id',$product_id);
            $result = $product->update($request->all());
            if( $result)
            {
                return response()->json([
                    "message" => "Data has been saved"
                  ], 200);
            }
            else
            {
                return response()->json([
                    "message" => "Error"
                  ], 404);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $product_id)
    {
        if (Product::where('product_id',$product_id)->exists()) {
            $product= Product::find($product_id);
            if($product->deleted_at != NULL) return ["Result" => "Product deleted"];
            $product->deleted_at = Carbon::now();
            $product->save();
    
            return response()->json([
              "message" => "Deleted successfully"
            ], 200);
          }
        else {
            return response()->json([
              "message" => "Error"
            ], 404);
          }
    }
}
