<?php

use App\Http\Controllers\RestaurantController;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;


Route::post('/orders/create', function (Request $request) {
    $response = Http::post('/order-service/api/create', $request->all());
    return $response;
});
Route::get('/orders/show', function (Request $request) {
    $response = Http::get('/order-service/api/show', $request->all());
    return $response;
});

Route::post('/restaurant/create', function (Request $request) {
    $response = Http::post('/restaurant-service/api/create', $request->all());
    return $response;
});

Route::get('/restaurant/show', function (Request $request) {
    $response = Http::get('/restaurant-service/api/show', $request->all());
    return $response;
});
