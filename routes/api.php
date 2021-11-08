<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/test",[App\Http\Controllers\ProductController::class,'test']);

//Public route
Route::post("/login",[App\Http\Controllers\AuthController::class,'Login']);

//Brand
 Route::get("/brand/active",[App\Http\Controllers\BrandController::class,'get_brand_active']);
 Route::get("/brand/active/count",[App\Http\Controllers\BrandController::class,'get_count_brand_active']);

 Route::get("/brand/deleted",[App\Http\Controllers\BrandController::class,'get_brand_delete']);
 Route::get("/brand/deleted/count",[App\Http\Controllers\BrandController::class,'get_count_brand_delete']);

 Route::get("/brand/{brand_id}",[App\Http\Controllers\BrandController::class,'show']);


 //Card
 Route::get("/card/active",[App\Http\Controllers\CardController::class,'get_card_active']);
 Route::get("/card/active/count",[App\Http\Controllers\CardController::class,'get_count_card_active']);

 Route::get("/card/deleted",[App\Http\Controllers\CardController::class,'get_card_deleted']);
 Route::get("/card/deleted/count",[App\Http\Controllers\CardController::class,'get_count_card_deleted']);

 Route::get("/card/{card_id}",[App\Http\Controllers\CardController::class,'show']);

 //CapacityRam
 Route::get("/capacityram/active",[App\Http\Controllers\CapacityRamController::class,'get_capacityram_active']);
 Route::get("/capacityram/active/count",[App\Http\Controllers\CapacityRamController::class,'get_count_capacityram_active']);

 Route::get("/capacityram/deleted",[App\Http\Controllers\CapacityRamController::class,'get_capacityram_deleted']);
 Route::get("/capacityram/deleted/count",[App\Http\Controllers\CapacityRamController::class,'get_count_capacityram_deleted']);

 Route::get("/capacityram/{capacity_ram_id}",[App\Http\Controllers\CapacityRamController::class,'show']);

 //Category Card
 Route::get("/categorycard/active",[App\Http\Controllers\CategoryCardController::class,'get_categorycard_active']);
 Route::get("/categorycard/active/count",[App\Http\Controllers\CategoryCardController::class,'get_count_categorycard_active']);

 Route::get("/categorycard/deleted",[App\Http\Controllers\CategoryCardController::class,'get_categorycard_deleted']);
 Route::get("/categorycard/deleted/count",[App\Http\Controllers\CategoryCardController::class,'get_count_categorycard_deleted']);

 Route::get("/categorycard/{category_card_id}",[App\Http\Controllers\CategoryCardController::class,'show']);

 //Category CPU
 Route::get("/categorycpu/active",[App\Http\Controllers\CategoryCPUController::class,'get_categorycpu_active']);
 Route::get("/categorycpu/active/count",[App\Http\Controllers\CategoryCPUController::class,'get_count_categorycpu_active']);

 Route::get("/categorycpu/deleted",[App\Http\Controllers\CategoryCPUController::class,'get_categorycpu_deleted']);
 Route::get("/categorycpu/deleted/count",[App\Http\Controllers\CategoryCPUController::class,'get_count_categorycpu_deleted']);

 Route::get("/categorycpu/{category_cpu_id}",[App\Http\Controllers\CategoryCPUController::class,'show']);

 //Category HardDisk
 Route::get("/categoryharddisk/active",[App\Http\Controllers\CategoryHardDiskController::class,'get_categoryharddisk_active']);
 Route::get("/categoryharddisk/active/count",[App\Http\Controllers\CategoryHardDiskController::class,'get_count_categoryharddisk_active']);

 Route::get("/categoryharddisk/deleted",[App\Http\Controllers\CategoryHardDiskController::class,'get_categoryharddisk_deleted']);
 Route::get("/categoryharddisk/deleted/count",[App\Http\Controllers\CategoryHardDiskController::class,'get_count_categoryharddisk_deleted']);

 Route::get("/categoryharddisk/{category_harddisk_id}",[App\Http\Controllers\CategoryHardDiskController::class,'show']);

 //Category Screen
 Route::get("/categoryscreen/active",[App\Http\Controllers\CategoryScreenController::class,'get_categoryscreen_active']);
 Route::get("/categoryscreen/active/count",[App\Http\Controllers\CategoryScreenController::class,'get_count_categoryscreen_active']);

 Route::get("/categoryscreen/deleted",[App\Http\Controllers\CategoryScreenController::class,'get_categoryscreen_deleted']);
 Route::get("/categoryscreen/deleted/count",[App\Http\Controllers\CategoryScreenController::class,'get_count_categoryscreen_deleted']);

 Route::get("/categoryscreen/{category_screen_id}",[App\Http\Controllers\CategoryScreenController::class,'show']);


 //Machine Series
 Route::get("/class/active",[App\Http\Controllers\MachineSeriesController::class,'get_class_active']);
  Route::get("/class/active/count",[App\Http\Controllers\MachineSeriesController::class,'get_count_class_active']);
 
  Route::get("/class/deleted",[App\Http\Controllers\MachineSeriesController::class,'get_class_deleted']);
  Route::get("/class/deleted/count",[App\Http\Controllers\MachineSeriesController::class,'get_count_class_deleted']);
 
  Route::get("/class/{class_id}",[App\Http\Controllers\MachineSeriesController::class,'show']);

  //RAM
  Route::get("/ram/active",[App\Http\Controllers\RAMController::class,'get_ram_active']);
  Route::get("/ram/active/count",[App\Http\Controllers\RAMController::class,'get_count_ram_active']);

  Route::get("/ram/deleted",[App\Http\Controllers\RAMController::class,'get_ram_deleted']);
  Route::get("/ram/deleted/count",[App\Http\Controllers\RAMController::class,'get_count_ram_deleted']);

  Route::get("/ram/{ram_id}",[App\Http\Controllers\RAMController::class,'show']);

  //Screen
  Route::get("/screen/active",[App\Http\Controllers\ScreenController::class,'get_screen_active']);
  Route::get("/screen/active/count",[App\Http\Controllers\ScreenController::class,'get_count_screen_active']);

  Route::get("/screen/deleted",[App\Http\Controllers\ScreenController::class,'get_screen_deleted']);
  Route::get("/screen/deleted/count",[App\Http\Controllers\ScreenController::class,'get_count_screen_deleted']);

  Route::get("/screen/{screen_id}",[App\Http\Controllers\ScreenController::class,'show']);

  //Hard disk
  Route::get("/harddisk/active",[App\Http\Controllers\HardDiskController::class,'get_harddisk_active']);
  Route::get("/harddisk/active/count",[App\Http\Controllers\HardDiskController::class,'get_count_harddisk_active']);
 
  Route::get("/harddisk/deleted",[App\Http\Controllers\HardDiskController::class,'get_harddisk_deleted']);
  Route::get("/harddisk/deleted/count",[App\Http\Controllers\HardDiskController::class,'get_count_harddisk_deleted']);
 
  Route::get("/harddisk/{harddisk_id}",[App\Http\Controllers\HardDiskController::class,'show']);
//search

Route::get("/product/search",[App\Http\Controllers\SearchController::class,'search']);

 //Product
 Route::get("/product",[App\Http\Controllers\ProductController::class,'index']); //lấy tất cả thành phần trong bảng product
 Route::get("/product/count",[App\Http\Controllers\ProductController::class,'count_Product']);
 
 Route::get("/product/deleted",[App\Http\Controllers\ProductController::class,'get_product_deleted']);
 Route::get("/product/deleted/count",[App\Http\Controllers\ProductController::class,'get_product_deleted_count']);

 Route::get("/product/active/count",[App\Http\Controllers\ProductController::class,'get_product_active_count']);
 Route::get("/product/active",[App\Http\Controllers\ProductController::class,'get_product_active']);

 Route::get("/product/detail",[App\Http\Controllers\ProductController::class,'get_product_detail']);//detail product join
 Route::get("/product/detail/{product_id}",[App\Http\Controllers\ProductController::class,'showdetail']);//detail product by id join
 Route::get("/product/{product_id}",[App\Http\Controllers\ProductController::class,'show']);//detail product by id not join
 //CPU
 Route::get("/cpu/active",[App\Http\Controllers\CPUController::class,'get_cpu_active']);
 Route::get("/cpu/active/count",[App\Http\Controllers\CPUController::class,'get_count_cpu_active']);

 Route::get("/cpu/deleted",[App\Http\Controllers\CPUController::class,'get_cpu_deleted']);
 Route::get("/cpu/deleted/count",[App\Http\Controllers\CPUController::class,'get_count_cpu_deleted']);

 Route::get("/cpu/{cpu_id}",[App\Http\Controllers\CPUController::class,'show']);


 //images
 Route::get("/images",[App\Http\Controllers\ImagesProductController::class,'index']);


//Order
Route::post("/order",[App\Http\Controllers\OrderController::class,'store']);

//Orderdatail
Route::get("/order",[App\Http\Controllers\OrderController::class,'index']);

Route::post("/register",[App\Http\Controllers\AuthController::class,'register']);
//Protected route
Route::group(['middleware' => ['auth:sanctum']], function () {
   

    Route::post("/logout",[App\Http\Controllers\AuthController::class,'logout']);

    //Brand
    Route::post("/brand",[App\Http\Controllers\BrandController::class,'store']);
    Route::put("/brand/{brand_id}",[App\Http\Controllers\BrandController::class,'update']);
    Route::put("/brand/delete/{brand_id}",[App\Http\Controllers\BrandController::class,'destroy']);

    //Capacity Ram
    Route::post("/capacityram",[App\Http\Controllers\CapacityRamController::class,'store']);
    Route::put("/capacityram/{capacity_ram_id}",[App\Http\Controllers\CapacityRamController::class,'update']);
    Route::put("/capacityram/delete/{capacity_ram_id}",[App\Http\Controllers\CapacityRamController::class,'destroy']);

    //Category Card
    Route::post("/categorycard",[App\Http\Controllers\CategoryCardController::class,'store']);
    Route::put("/categorycard/{category_card_id}",[App\Http\Controllers\CategoryCardController::class,'update']);
    Route::put("/categorycard/delete/{category_card_id}",[App\Http\Controllers\CategoryCardController::class,'destroy']);

    //Card
    Route::post("/card",[App\Http\Controllers\CardController::class,'store']);
    Route::put("/card/{card_id}",[App\Http\Controllers\CardController::class,'update']);
    Route::put("/card/delete/{card_id}",[App\Http\Controllers\CardController::class,'destroy']);

    //Category CPU
    Route::post("/categorycpu",[App\Http\Controllers\CategoryCPUController::class,'store']);
    Route::put("/categorycpu/{category_cpu_id}",[App\Http\Controllers\CategoryCPUController::class,'update']);
    Route::put("/categorycpu/delete/{category_cpu_id}",[App\Http\Controllers\CategoryCPUController::class,'destroy']);

    //Category HardDisk
    Route::post("/categoryharddisk",[App\Http\Controllers\CategoryHardDiskController::class,'store']);
    Route::put("/categoryharddisk/{category_harddisk_id}",[App\Http\Controllers\CategoryHardDiskController::class,'update']);
    Route::put("/categoryharddisk/delete/{category_harddisk_id}",[App\Http\Controllers\CategoryHardDiskController::class,'destroy']);

    //Category Screen
    Route::post("/categoryscreen",[App\Http\Controllers\CategoryScreenController::class,'store']);
    Route::put("/categoryscreen/{category_screen_id}",[App\Http\Controllers\CategoryScreenController::class,'update']);
    Route::put("/categoryscreen/delete/{category_screen_id}",[App\Http\Controllers\CategoryScreenController::class,'destroy']);


    //CPU
    Route::post("/cpu",[App\Http\Controllers\CPUController::class,'store']);
    Route::put("/cpu/{cpu_id}",[App\Http\Controllers\CPUController::class,'update']);
    Route::put("/cpu/delete/{cpu_id}",[App\Http\Controllers\CPUController::class,'destroy']);

    //Machine Series
    Route::post("/class",[App\Http\Controllers\MachineSeriesController::class,'store']);
    Route::put("/class/{class_id}",[App\Http\Controllers\MachineSeriesController::class,'update']);
    Route::put("/class/delete/{class_id}",[App\Http\Controllers\MachineSeriesController::class,'destroy']);

    //RAM
    Route::post("/ram",[App\Http\Controllers\RAMController::class,'store']);
    Route::put("/ram/{ram_id}",[App\Http\Controllers\RAMController::class,'update']);
    Route::put("/ram/delete/{ram_id}",[App\Http\Controllers\RAMController::class,'destroy']);

    //Screen
    Route::post("/screen",[App\Http\Controllers\ScreenController::class,'store']);
    Route::put("/screen/{screen_id}",[App\Http\Controllers\ScreenController::class,'update']);
    Route::put("/screen/delete/{screen_id}",[App\Http\Controllers\ScreenController::class,'destroy']);

    //Product
    Route::post("/product",[App\Http\Controllers\ProductController::class,'store']);
    Route::put("/product/{product_id}",[App\Http\Controllers\ProductController::class,'update']);
    Route::put("/product/delete/{product_id}",[App\Http\Controllers\ProductController::class,'destroy']);

     //Image Product
    Route::post("/upload",[App\Http\Controllers\ImagesProductController::class,'upload']);
    Route::post("/images",[App\Http\Controllers\ImagesProductController::class,'store']);


    //Hard Disk
    Route::post("/harddisk",[App\Http\Controllers\HardDiskController::class,'store']);
    Route::put("/harddisk/{harddisk_id}",[App\Http\Controllers\HardDiskController::class,'update']);
    Route::put("/harddisk/delete/{harddisk_id}",[App\Http\Controllers\HardDiskController::class,'destroy']);

    //Order
    Route::get("/order",[App\Http\Controllers\OrderController::class,'index']); 
});