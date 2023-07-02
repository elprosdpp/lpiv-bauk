<?php

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
Route::post('/terminal/post', [\App\Http\Controllers\Admin\TerminalController::class, 'executeCommand'])->name('terminal.executeCommand');
//Route::post('/hotspot/user/store', [\App\Http\Controllers\Admin\HotspotController::class, 'addUserHotpot'])->name('hotspot.store');

//Route::group(['middleware' => 'auth'], function () {
//Route::get('/monitor', \App\Http\Controllers\MonitorController::class);
//Route::get('/admin/category', \App\Http\Controllers\Admin\CategoryController::class);
//});
