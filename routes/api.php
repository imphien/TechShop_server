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

Route::post("/register",[App\Http\Controllers\AuthController::class,'register']);

//Public route
Route::post("/login",[App\Http\Controllers\AuthController::class,'Login']);

//Brand
 Route::get("/brand",[App\Http\Controllers\BrandController::class,'index']);

 //CapacityRam
 Route::get("/capacityram",[App\Http\Controllers\CapacityRamController::class,'index']);

 //Category Card
 Route::get("/categorycard",[App\Http\Controllers\CategoryCardController::class,'index']);

 //Category CPU
 Route::get("/categorycpu",[App\Http\Controllers\CategoryCPUController::class,'index']);

 //Category HardDisk
 Route::get("/categoryharddisk",[App\Http\Controllers\CategoryHardDiskController::class,'index']);

 //Category Screen
 Route::get("/categoryscreen",[App\Http\Controllers\CategoryScreenController::class,'index']);

 //Machine Series
 Route::get("/class",[App\Http\Controllers\MachineSeriesController::class,'index']);

  //RAM
Route::get("/ram",[App\Http\Controllers\RAMController::class,'index']);

  //Screen
  Route::get("/screen",[App\Http\Controllers\ScreenController::class,'index']);

  //Hard disk
  Route::get("/harddisk",[App\Http\Controllers\ScreenController::class,'index']);

 //Product
 Route::get("/product",[App\Http\Controllers\ProductController::class,'index']);
 Route::get("/product/{product_id}",[App\Http\Controllers\ProductController::class,'show']);
 Route::get("/countproduct",[App\Http\Controllers\ProductController::class,'countProduct']);
 Route::get("/deletedproduct",[App\Http\Controllers\ProductController::class,'get_product_deleted']);
 Route::get("/notdeletedproduct",[App\Http\Controllers\ProductController::class,'get_product_not_deleted']);
 Route::get("/productdetail",[App\Http\Controllers\ProductController::class,'get_product_detail']);

 
 Route::get("/uuid",[App\Http\Controllers\BrandController::class,'gen_uuid']);

//search

Route::get("/search",[App\Http\Controllers\SearchController::class,'search']);


//Protected route
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post("/logout",[App\Http\Controllers\AuthController::class,'logout']);

    //Brand
   
    Route::post("/brand",[App\Http\Controllers\BrandController::class,'store']);
    Route::put("/brand/{brand_id}",[App\Http\Controllers\BrandController::class,'update']);
     Route::put("/delete_brand/{brand_id}",[App\Http\Controllers\BrandController::class,'destroy']);

    //Capacity Ram
    Route::post("/capacityram",[App\Http\Controllers\CapacityRamController::class,'store']);
    Route::put("/capacityram/{capacity_ram_id}",[App\Http\Controllers\CapacityRamController::class,'update']);
    Route::put("/delete_capacityram/{capacity_ram_id}",[App\Http\Controllers\CapacityRamController::class,'destroy']);

    //Category Card
    Route::post("/categorycard",[App\Http\Controllers\CategoryCardController::class,'store']);
    Route::put("/categorycard/{category_card_id}",[App\Http\Controllers\CategoryCardController::class,'update']);
    Route::put("/delete_categorycard/{category_card_id}",[App\Http\Controllers\CategoryCardController::class,'destroy']);

    //Category CPU
    Route::post("/categorycpu",[App\Http\Controllers\CategoryCPUController::class,'store']);
    Route::put("/categorycpu/{category_cpu_id}",[App\Http\Controllers\CategoryCPUController::class,'update']);
    Route::put("/delete_categorycpu/{category_cpu_id}",[App\Http\Controllers\CategoryCPUController::class,'destroy']);

    //Category HardDisk
    Route::post("/categoryharddisk",[App\Http\Controllers\CategoryHardDiskController::class,'store']);
    Route::put("/categoryharddisk/{category_harddisk_id}",[App\Http\Controllers\CategoryHardDiskController::class,'update']);
    Route::put("/delete_categoryharddisk/{category_harddisk_id}",[App\Http\Controllers\CategoryHardDiskController::class,'destroy']);

    //Category Screen
    Route::post("/categoryscreen",[App\Http\Controllers\CategoryScreenController::class,'store']);
    Route::put("/categoryscreen/{category_screen_id}",[App\Http\Controllers\CategoryScreenController::class,'update']);
    Route::put("/delete_categoryscreen/{category_screen_id}",[App\Http\Controllers\CategoryScreenController::class,'destroy']);


    //CPU
    Route::post("/cpu",[App\Http\Controllers\CPUController::class,'store']);
    Route::put("/cpu/{cpu_id}",[App\Http\Controllers\CPUController::class,'update']);
    Route::put("/delete_cpu/{cpu_id}",[App\Http\Controllers\CPUController::class,'destroy']);

    //Machine Series
    Route::post("/class",[App\Http\Controllers\MachineSeriesController::class,'store']);
    Route::put("/class/{class_id}",[App\Http\Controllers\MachineSeriesController::class,'update']);
    Route::put("/delete_class/{class_id}",[App\Http\Controllers\MachineSeriesController::class,'destroy']);

    //RAM
    Route::post("/ram",[App\Http\Controllers\RAMController::class,'store']);
    Route::put("/ram/{id}",[App\Http\Controllers\RAMController::class,'update']);
    Route::put("/delete_ram/{id}",[App\Http\Controllers\RAMController::class,'destroy']);

    //Screen
    Route::post("/screen",[App\Http\Controllers\ScreenController::class,'store']);
    Route::put("/screen/{screen_id}",[App\Http\Controllers\ScreenController::class,'update']);
    Route::put("/delete_screen/{screen_id}",[App\Http\Controllers\ScreenController::class,'destroy']);

    //Product
    Route::post("/product",[App\Http\Controllers\ProductController::class,'store']);
    Route::put("/product/{product_id}",[App\Http\Controllers\ProductController::class,'update']);
    Route::put("/delete_product/{product_id}",[App\Http\Controllers\ProductController::class,'destroy']);

     //Image Product
    Route::post("/upload",[App\Http\Controllers\ImagesProductController::class,'upload']);
    Route::post("/images",[App\Http\Controllers\ImagesProductController::class,'store']);


    //Hard Disk
    Route::post("/harddisk",[App\Http\Controllers\HardDiskController::class,'store']);
    Route::put("/harddisk/{harddisk_id}",[App\Http\Controllers\HardDiskController::class,'update']);
    Route::put("/delete_harddisk/{harddisk_id}",[App\Http\Controllers\HardDiskController::class,'destroy']);

    //Order
    Route::post("/order",[App\Http\Controllers\OrderController::class,'store']);
});
