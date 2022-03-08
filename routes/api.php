<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TelcoRequestController;

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

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/user', [AuthController::class, 'me']);
Route::get('/auth/logout', [AuthController::class, 'logout']);

Route::post('/telco-request/getTelcoRequests/', [TelcoRequestController::class, 'getTelcoRequests']);
Route::post('/telco-request/submit', [TelcoRequestController::class, 'submit']);