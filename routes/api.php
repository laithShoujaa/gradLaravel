<?php

use App\Http\Controllers\CardsController;
use App\Http\Controllers\UsersController;
use App\Models\Users;
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
Route::get('/', function () {
    return view('welcome');
});
Route::post('/register', [UsersController::class, 'register']);
Route::post('/login', [UsersController::class, 'login']);
Route::post('/verify', [UsersController::class, 'verify']);
Route::post('/cardData', [CardsController::class, 'cardData']);
Route::post('/logout', [UsersController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/addCard', [CardsController::class, 'addCard'])->middleware('auth:sanctum');
Route::get('/userDetails', [UsersController::class, 'userDetails'])->middleware('auth:sanctum');
Route::get('/usersCards', [CardsController::class, 'usersCards'])->middleware('auth:sanctum');
Route::get('/counts', [CardsController::class, 'counts'])->middleware('auth:sanctum');
Route::get('/profile', [CardsController::class, 'userCard'])->middleware('auth:sanctum');
