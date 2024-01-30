<?php

use Illuminate\Support\Facades\Route;
use App\Models;
use App\Http\Controllers\CompaniesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/list', [App\Http\Controllers\CompaniesController::class, 'showList'])->name('list');//商品一覧画面
//Route::get('/test', [App\Http\Controllers\CompaniesController::class, 'showCoName'])->name('test');//表示テスト用

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
