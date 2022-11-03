<?php

use App\Http\Controllers\Todo\CategoryController;
use App\Http\Controllers\Todo\TodoManageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'grid'], static function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/todo-list', [TodoManageController::class, 'index']);
    Route::get('/todo-list-by-category', [TodoManageController::class, 'todoListByCategory']);
});

Route::group(['prefix' => 'save'], static function () {
    Route::post('/category-save', [CategoryController::class, 'store']);
    Route::post('/todo-save', [TodoManageController::class, 'store']);
});
Route::group(['prefix' => 'delete'], static function () {
    Route::delete('/category-delete/{id}', [CategoryController::class, 'delete']);
    Route::delete('/todo-delete/{id}', [TodoManageController::class, 'delete']);
});


