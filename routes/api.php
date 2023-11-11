<?php

use App\Http\Controllers\V1\Auth\LoginRegisterController;
use App\Http\Controllers\V1\WorkspaceController;
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
Route::get('/unauthenticate', function () {
    return response()->json(['success'=> false, 'message' => 'unauthenticate'], 401);
})->name('unauthenticate');

Route::group(['prefix' => '/'], function () {
    Route::post('/login', [LoginRegisterController::class, 'login']);
    Route::post('/register', [LoginRegisterController::class, 'register']);
    Route::get('/verifyToken', [LoginRegisterController::class, 'verifyToken']);
    Route::post('/forgot-password', [LoginRegisterController::class, 'forgotPassword']); // not completed
});

Route::middleware(['auth:api', 'verified'])->group(function () {
    Route::post('/logout', [LoginRegisterController::class, 'logout']);
    Route::post('/logout/all', [LoginRegisterController::class, 'logoutAll']);

    /* Workspace Management */
    Route::group(['prefix' => '/workspaces'], function() {
        Route::get('/', [WorkspaceController::class, 'index']);
        Route::post('/', [WorkspaceController::class, 'store']);
        Route::put('/', [WorkspaceController::class, 'update']);
        Route::delete('/', [WorkspaceController::class, 'destroy']);
    });
    // Route::resource('/workspaces', WorkspaceController::class);
});
