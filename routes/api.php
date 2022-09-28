<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
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

//CRUD profile
Route::get('profile', [ProfileController::class, 'index']);
Route::post('profile', [ProfileController::class, 'store']);
Route::put('profile/{id}', [ProfileController::class, 'update']);
Route::get('profile/{id}', [ProfileController::class, 'show']);
Route::delete('profile/{id}', [ProfileController::class, 'destroy']);

//count gender
Route::get('count', [ProfileController::class, 'count']);

//akun
Route::get('user', [RoleController::class, 'index']);
Route::post('user', [RoleController::class, 'store']);
Route::post('login', [RoleController::class, 'login']);

//Route::resource('profile', [ProfileController::class])->except(['create', 'edit']);
