<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\JurusanApiController;
use App\Http\Controllers\Api\KhsApiController;
use App\Http\Controllers\Api\DosenCourseApiController;

Route::post('/dosen-course', [DosenCourseApiController::class, 'store']);
Route::get('/jurusan', [JurusanApiController::class, 'index']);
Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/khs', [KhsApiController::class, 'index']);
Route::post('/khs', [KhsApiController::class, 'store']);

