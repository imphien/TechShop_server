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
 Route::get("/brand/{brand_id?}",[App\Http\Controllers\BrandController::class,'show']);

 //Product
 Route::get("/product",[App\Http\Controllers\ProductController::class,'index']);
 Route::get("/countproduct",[App\Http\Controllers\ProductController::class,'countProduct']);
 Route::get("/deletedproduct",[App\Http\Controllers\ProductController::class,'get_product_deleted']);
 Route::get("/notdeletedproduct",[App\Http\Controllers\ProductController::class,'get_product_not_deleted']);
 Route::get("/productdetail",[App\Http\Controllers\ProductController::class,'get_product_detail']);



 //Image Product
 Route::post("/upload",[App\Http\Controllers\ImagesProductController::class,'upload']);
 Route::post("/images",[App\Http\Controllers\ImagesProductController::class,'store']);
//Protected route
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post("/logout",[App\Http\Controllers\AuthController::class,'logout']);

    //Brand
    Route::post("/brand",[App\Http\Controllers\BrandController::class,'store']);
    Route::put("/brand",[App\Http\Controllers\BrandController::class,'update']);
    Route::put("/brand/{id?}",[App\Http\Controllers\BrandController::class,'delete']);

    //Product
    Route::post("/product",[App\Http\Controllers\ProductController::class,'store']);
    Route::put("/product",[App\Http\Controllers\ProductController::class,'update']);
    Route::put("/deleteproduct",[App\Http\Controllers\ProductController::class,'destroy']);
});
