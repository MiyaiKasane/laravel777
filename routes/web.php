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
*/Route::get('/list', [CompaniesController::class, 'showList'])->name('list'); //商品一覧画面の表示&検索用
Route::get('/pdetail/{id}', [CompaniesController::class, 'showPdetail'])->name('pdetail'); //詳細情報の画面表示
Route::get('/new', [CompaniesController::class, 'showNewform'])->name('new'); //新規登録画面の表示
Route::post('/new', [CompaniesController::class, 'registSubmit'])->name('insert_data'); //新規データの登録
Route::get('/pedit/{id}', [CompaniesController::class, 'showPedit'])->name('pedit'); //情報編集の画面表示
Route::put('/pedit/{id}', [CompaniesController::class, 'updateData'])->name('pedit_update'); //編集→更新用
Route::delete('/destroy/{id}', [CompaniesController::class, 'destroy'])->name('list_delete');//削除ボタン

Auth::routes();//これによってユーザ登録やログインのルーティングが行われている

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
