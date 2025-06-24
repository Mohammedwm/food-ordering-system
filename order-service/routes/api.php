<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Support\Facades\Route;

Route::post('/orders/create', [OrderController::class, 'create']);
Route::get('/orders/show', [OrderController::class, 'show']);
