<?php

use Illuminate\Support\Facades\Route;
use App\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\JurusanApiController;

Route::get('/jurusan', [JurusanApiController::class, 'index']);
Route::get('/products', [ProductApiController::class, 'index']);
