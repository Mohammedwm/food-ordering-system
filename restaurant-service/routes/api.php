<?php

use App\Http\Controllers\RestaurantController;
use Illuminate\Support\Facades\Route;

Route::post('/restaurants/create', [RestaurantController::class, 'create']);
Route::get('/restaurants/show', [RestaurantController::class, 'show']);
