<?php

use App\Http\Controllers\CardsController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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
Route::post('/register',[UsersController::class,'register']);
Route::post('/login',[UsersController::class,'login']);
Route::post('/logout',[UsersController::class,'logout'])->middleware('auth:sanctum');
Route::post('/verify',[UsersController::class,'verify']);
Route::post('/create_account',[CardsController::class,'create_account'])->middleware('auth:sanctum');
