<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('productos', 'ProductoController@index' );
Route::post('producto/new', 'ProductoController@store' );
Route::get('ordenes', 'OrdenController@index' );
Route::post('orden/new', 'OrdenController@store' );

