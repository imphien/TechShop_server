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

 //Product
 Route::get("/product",[App\Http\Controllers\ProductController::class,'index']);
 Route::get("/countproduct",[App\Http\Controllers\ProductController::class,'countProduct']);
 Route::get("/deletedproduct",[App\Http\Controllers\ProductController::class,'get_product_deleted']);
 Route::get("/notdeletedproduct",[App\Http\Controllers\ProductController::class,'get_product_not_deleted']);
 Route::get("/productdetail",[App\Http\Controllers\ProductController::class,'get_product_detail']);


//Protected route
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post("/logout",[App\Http\Controllers\AuthController::class,'logout']);

    //Brand
    Route::post("/brand",[App\Http\Controllers\BrandController::class,'store']);
    Route::put("/brand",[App\Http\Controllers\BrandController::class,'update']);
    Route::put("/delete_brand",[App\Http\Controllers\BrandController::class,'destroy']);

    //Capacity Ram
    Route::post("/capacityram",[App\Http\Controllers\CapacityRamController::class,'store']);
    Route::put("/capacityram",[App\Http\Controllers\CapacityRamController::class,'update']);
    Route::get("/deleted_ram",[App\Http\Controllers\CapacityRamController::class,'destroy']);

    //Category Card
    Route::post("/categorycard",[App\Http\Controllers\CategoryCardController::class,'store']);
    Route::put("/categorycard",[App\Http\Controllers\CategoryCardController::class,'update']);
    Route::put("/deleted_categorycard",[App\Http\Controllers\CategoryCardController::class,'destroy']);

    //Category CPU
    Route::post("/categorycpu",[App\Http\Controllers\CategoryCPUController::class,'store']);
    Route::put("/categorycpu",[App\Http\Controllers\CategoryCPUController::class,'update']);
    Route::put("/deleted_categorycpu",[App\Http\Controllers\CategoryCPUController::class,'destroy']);

    //Category HardDisk
    Route::post("/categoryharddisk",[App\Http\Controllers\CategoryHardDiskController::class,'store']);
    Route::put("/categoryharddisk",[App\Http\Controllers\CategoryHardDiskController::class,'update']);
    Route::put("/deleted_categoryharddisk",[App\Http\Controllers\CategoryHardDiskController::class,'destroy']);

    //Category Screen
    Route::post("/categoryscreen",[App\Http\Controllers\CategoryScreenController::class,'store']);
    Route::put("/categoryscreen",[App\Http\Controllers\CategoryScreenController::class,'update']);
    Route::put("/deleted_categoryscreen",[App\Http\Controllers\CategoryScreenController::class,'destroy']);

    //Machine Series
    Route::post("/class",[App\Http\Controllers\MachineSeriesController::class,'store']);
    Route::put("/class",[App\Http\Controllers\MachineSeriesController::class,'update']);
    Route::put("/deleted_class",[App\Http\Controllers\MachineSeriesController::class,'destroy']);

    //RAM
    Route::post("/ram",[App\Http\Controllers\RAMController::class,'store']);
    Route::put("/ram",[App\Http\Controllers\RAMController::class,'update']);
    Route::put("/deleted_ram",[App\Http\Controllers\RAMController::class,'destroy']);

    //Screen
    Route::post("/screen",[App\Http\Controllers\ScreenController::class,'store']);
    Route::put("/screen",[App\Http\Controllers\ScreenController::class,'update']);
    Route::put("/deleted_screen",[App\Http\Controllers\ScreenController::class,'destroy']);

    //Product
    Route::post("/product",[App\Http\Controllers\ProductController::class,'store']);
    Route::put("/product",[App\Http\Controllers\ProductController::class,'update']);
    Route::put("/deletep_roduct",[App\Http\Controllers\ProductController::class,'destroy']);

     //Image Product
    Route::post("/upload",[App\Http\Controllers\ImagesProductController::class,'upload']);
    Route::post("/images",[App\Http\Controllers\ImagesProductController::class,'store']);
});
