<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// รองรับการทำงาน GET, POST, PUT/PATCH, DELETE
Route::apiResource('pets', PetController::class)->middleware('auth:sanctum');

// ไม่ต้อง Login ก่อนถึงจะสามารถเข้าถึงข้อมูลได้
Route::get('/pets', [PetController::class, 'index']);
// 
// 

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
