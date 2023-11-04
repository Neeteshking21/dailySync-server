<?php

use App\Http\Controllers\Auth\LoginRegisterController;
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
Route::get('/test', function(Request $request) {
    return response()->json(['msg' => 'Hey there']);
});

Route::group(['prefix' => '/'], function () {
    Route::get('/', function(Request $request) {
        return response()->json(['msg' => 'APi there']);
    });
    Route::post('/login', [LoginRegisterController::class, 'login']);
    Route::post('/register', [LoginRegisterController::class, 'register']);
    Route::post('/forgot-password', [LoginRegisterController::class, 'forgotPassword']);
    Route::post('/verify-otp', [LoginRegisterController::class, 'verifyOTP']);
});
