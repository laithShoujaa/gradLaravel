<?php

use App\Http\Controllers\CardsController;
use App\Http\Controllers\FilesController;
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
Route::get('/grad', function () {
    return view('userpage');
});
Route::get('/twenty', function () {
    return view('twenty');
});
/**user */
Route::post('/register', [UsersController::class, 'register']);//end link
Route::post('/login', [UsersController::class, 'login']);//end link
Route::post('/verify', [UsersController::class, 'verify']);//end link
Route::post('/logout', [UsersController::class, 'logout'])->middleware('auth:sanctum');//end link
Route::get('/userDetails', [UsersController::class, 'userDetails'])->middleware('auth:sanctum');//end link
/**card */
Route::post('/cardData', [CardsController::class, 'cardData']);//end link
Route::post('/editCard', [CardsController::class, 'editCard'])->middleware('auth:sanctum');//end link
Route::post('/deleteCard', [CardsController::class, 'deleteCard'])->middleware('auth:sanctum');//end link
//
Route::post('/moveCard', [CardsController::class, 'moveCard'])->middleware('auth:sanctum');
Route::post('/cardSafeKey', [CardsController::class, 'cardSafeKey'])->middleware('auth:sanctum');
Route::post('/setAsPrimary', [CardsController::class, 'setAsPrimary'])->middleware('auth:sanctum');
//
Route::post('/addCard', [CardsController::class, 'addCard'])->middleware('auth:sanctum');//end link
Route::get('/usersCards', [CardsController::class, 'usersCards'])->middleware('auth:sanctum');//end link
Route::get('/counts', [CardsController::class, 'counts'])->middleware('auth:sanctum');//end link
Route::get('/profile', [CardsController::class, 'userCard'])->middleware('auth:sanctum');//end link
/**files */
Route::post('/editPhoto', [FilesController::class, 'editPhoto'])->middleware('auth:sanctum');//end link
//
Route::post('/editFilePhoto', [FilesController::class, 'editFilePhoto'])->middleware('auth:sanctum');
Route::post('/editFile', [FilesController::class, 'editFile'])->middleware('auth:sanctum');//end link
Route::post('/deletecardFile', [FilesController::class, 'deletecardFile'])->middleware('auth:sanctum');//end link
//
Route::post('/getCardFiles', [FilesController::class, 'getCardFiles']);//end link
Route::post('/addCardFile', [FilesController::class, 'addCardFile'])->middleware('auth:sanctum');//end link
Route::get('/getFile/{id}', [FilesController::class, 'getFile']);//end link


