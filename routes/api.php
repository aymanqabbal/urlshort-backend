<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login',[\App\Http\Controllers\AuthController::class,'login']);
Route::post('/register',[\App\Http\Controllers\AuthController::class,'register']);
Route::get('/s/{id}', [\App\Http\Controllers\LinksController::class, 'redirect']);

Route::group(['middleware'=>['auth:sanctum']],function (){
Route::post('/logout',[\App\Http\Controllers\AuthController::class,'logout']);
Route::resource('/links',\App\Http\Controllers\LinksController::class);
Route::get('/mylinks'   ,[\App\Http\Controllers\LinksController::class,'mylinks']);
});
