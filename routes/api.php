<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\MakeRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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
// Route::post('register', [AuthController::class, 'register']); -> opsi jika ingin digunakan
Route::post('login', [AuthController::class, 'login']);

// ROUTE AUTHORIZATION
Route::middleware('auth:sanctum')->group(function () {
    // Route Profile For User Or Admin
    Route::get('user/profile', [ProfileController::class, 'user']);
    Route::put('user/profile', [ProfileController::class, 'updateProfile']);
    Route::put('user/profile', [ProfileController::class, 'updatePassword']);

    // READ BARANG BASE ON USER_ID OR AUTHENTIKASI
    Route::get('user/barang', [ProfileController::class, 'readBarang']);
    // Route logout authentikasi
    Route::get('logout', [AuthController::class, 'logout']);

    Route::middleware('user')->group(function () {
        // ROUTE MAKEREQUEST FOR USER
        Route::delete('makeRequest/{id}', [MakeRequestController::class, 'delete']);
        Route::get('makeRequest', [MakeRequestController::class, 'index']);
        Route::post('makeRequest/{barangId}', [MakeRequestController::class, 'store']);
    });

    Route::middleware('admin')->group(function () {
        // MR FOR ADMIN
        Route::get('makeRequest', [MakeRequestController::class, 'readMakeRequestAdmin']);
        Route::put('makeRequest/{id}', [MakeRequestController::class, 'updateAdmin']);

        // READ USER FOR ADMIN
        Route::get('readUser', [UserController::class, 'readUser']);
        // Create, Update USER For ADMIN
        Route::post('user', [UserController::class, 'store']);
        Route::put('user/{id}', [UserController::class, 'update']);

        // ROUTE DEPARTMENT
        Route::get('department', [DepartmentController::class, 'index']);
        Route::get('department/{id}', [DepartmentController::class, 'show']);
        Route::post('department', [DepartmentController::class, 'store']);
        Route::put('department', [DepartmentController::class, 'update']);
        Route::delete('department', [DepartmentController::class, 'destroy']);
        Route::get('department/trash', [DepartmentController::class, 'trash']);
        Route::get('department/restore/{id}', [DepartmentController::class, 'restore']);

        // ROUTE DIVISI
        Route::get('divisi', [DivisiController::class, 'index']);
        Route::get('divisi/{id}', [DivisiController::class, 'show']);
        Route::post('divisi', [DivisiController::class, 'store']);
        Route::put('divisi', [DivisiController::class, 'update']);
        Route::delete('divisi', [DivisiController::class, 'destroy']);
        Route::get('divisi/trash', [DivisiController::class, 'trash']);
        Route::get('divisi/restore/{id}', [DivisiController::class, 'restore']);

        // ROUTE CATEGORY
        Route::get('category', [CategoryController::class, 'index']);
        Route::get('category/{id}', [CategoryController::class, 'show']);
        Route::post('category', [CategoryController::class, 'store']);
        Route::put('category', [CategoryController::class, 'update']);
        Route::delete('category', [CategoryController::class, 'destroy']);
        Route::get('category/trash', [CategoryController::class, 'trash']);
        Route::get('category/restore/{id}', [CategoryController::class, 'restore']);

        // ROUTE BARANG
        Route::post('barang', [BarangController::class, 'store']);
        Route::get('barang', [BarangController::class, 'index']);
        Route::get('barang/{id}', [BarangController::class, 'show']);
        Route::put('barang/{id}', [BarangController::class, 'update']);
        Route::delete('barang', [BarangController::class, 'destroy']);
        Route::get('barang/trash', [BarangController::class, 'trash']);
        Route::get('barang/restore/{id}', [BarangController::class, 'restore']);

        // ROUTE HISTORY
        Route::get('history/{barang_id}', [HistoryController::class, 'index']);
        Route::get('historyDeleted/{barangId}', [HistoryController::class, 'historyDeleted']);
        Route::post('history/{barang_id}', [HistoryController::class, 'store']);
        Route::delete('history/{id}', [HistoryController::class, 'destroy']);
    });
});
