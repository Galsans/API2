<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DivisiController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ROUTE AUTHENTIKASI
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// ROUTE AUTHORIZATION
Route::middleware('auth:api')->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
});

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
