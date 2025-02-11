<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\AuthController;

// เส้นทางสำหรับการเข้าสู่ระบบ
Route::post('/login', [AuthController::class, 'login']);

// เส้นทางสำหรับการลงทะเบียน
Route::post('/register', [AuthController::class, 'register']);

// เส้นทางสำหรับการจัดการทรัพยากรสัตว์เลี้ยง
Route::apiResource('pets', PetController::class);

// เส้นทางสำหรับการออกจากระบบ โดยต้องผ่านการตรวจสอบสิทธิ์ด้วย Sanctum
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// กลุ่มเส้นทางที่ต้องผ่านการตรวจสอบสิทธิ์ด้วย Sanctum
Route::middleware('auth:sanctum')->group(function () {

    // เส้นทางสำหรับการดึงข้อมูลผู้ใช้ที่เข้าสู่ระบบ
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});