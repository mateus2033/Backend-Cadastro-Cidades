<?php

use App\Http\Controllers\StatesController;
use App\Http\Controllers\PeopleController;
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


Route::post('cityes/index',[StatesController::class,'index']);
Route::get('cityes',       [StatesController::class,'show']);
Route::post('cityes',      [StatesController::class,'storage']);
Route::put('cityes',       [StatesController::class,'update']);


Route::post('people/index',[PeopleController::class,'index']);
Route::get('people' ,      [PeopleController::class,'show']);
Route::post('people',      [PeopleController::class,'storage']);
Route::delete('people',    [PeopleController::class,'destroy']);


Route::get('index',function(){
    return view('index');
});

