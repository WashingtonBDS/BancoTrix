<?php

use App\Http\Controllers\PixController;
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

Route::post('users/registration', [UserController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('/users', [UserController::class,'details']);
    Route::post('/users/transfer', [TransferController::class, 'transferUser']);
    Route::get('/users/extract', [ExtractController::class, 'extractUser']);
    Route::post('/users/ticket', [PaymentController::class, 'ticket']);
    Route::post('/users/payment', [PaymentController::class, 'index']);
    Route::post('/users/pix', [PixController::class,'pixUser']);
});
