<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\MakeRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// ROUTE AUTHENTIKASI
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// ROUTE AUTHORIZATION
Route::middleware('auth:sanctum')->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);

    Route::middleware('user')->group(function () {
        // ROUTE MAKEREQUEST
        Route::delete('makeRequest/{id}', [MakeRequestController::class, 'delete']);
        Route::get('makeRequest', [MakeRequestController::class, 'index']);
        Route::post('makeRequest/{barangId}', [MakeRequestController::class, 'store']);
    });

    Route::middleware('admin')->group(function () {
        // ROUTE DEPARTMENT
        Route::get('department', [DepartmentController::class, 'index']);
        Route::get('department/{id}', [DepartmentController::class, 'show']);
        Route::post('department', [DepartmentController::class, 'store']);
        Route::put('department', [DepartmentController::class, 'update']);
        Route::delete('department', [DepartmentController::class, 'destroy']);

        // ROUTE DIVISI
        Route::get('divisi', [DivisiController::class, 'index']);
        Route::get('divisi/{id}', [DivisiController::class, 'show']);
        Route::post('divisi', [DivisiController::class, 'store']);
        Route::put('divisi', [DivisiController::class, 'update']);
        Route::delete('divisi', [DivisiController::class, 'destroy']);

        Route::put('makeRequest/{id}', [MakeRequestController::class, 'updateAdmin']);

        Route::get('readUser', [AuthController::class, 'readUser']);


        // ROUTE CATEGORY
        Route::get('category', [CategoryController::class, 'index']);
        Route::get('category/{id}', [CategoryController::class, 'show']);
        Route::post('category', [CategoryController::class, 'store']);
        Route::put('category', [CategoryController::class, 'update']);
        Route::delete('category', [CategoryController::class, 'destroy']);


        // ROUTE BARANG
        Route::get('barang', [BarangController::class, 'index']);
        Route::get('barang/{id}', [BarangController::class, 'show']);
        Route::post('barang', [BarangController::class, 'store']);
        Route::put('barang', [BarangController::class, 'update']);
        Route::delete('barang', [BarangController::class, 'destroy']);

        // ROUTE HISTORY
        Route::get('history/{barang_id}', [HistoryController::class, 'index']);
        Route::post('history/{barang_id', [HistoryController::class, 'store']);
        Route::delete('history/{id}', [HistoryController::class, 'destroy']);
    });
});
