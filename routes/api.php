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

// Route::post("/register",[App\Http\Controllers\AuthController::class,'register']);

//Public route
Route::post("/login",[App\Http\Controllers\AuthController::class,'Login']);

//Brand
 Route::get("/brand",[App\Http\Controllers\BrandController::class,'index']);
 Route::get("/brand/{brand_id?}",[App\Http\Controllers\BrandController::class,'show']);

//Protected route
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post("/logout",[App\Http\Controllers\AuthController::class,'logout']);

    //Brand
    Route::post("/brand",[App\Http\Controllers\BrandController::class,'store']);
    Route::put("/brand",[App\Http\Controllers\BrandController::class,'update']);
    Route::put("/brand/{id?}",[App\Http\Controllers\BrandController::class,'delete']);
});
