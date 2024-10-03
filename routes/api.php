<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/expenses', [\App\Http\Controllers\Api\ExpenseApiController::class, 'store'])->middleware('auth:sanctum');

