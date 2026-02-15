<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\SalesController; //SalesControllerと接続で大丈夫そ？


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

Route::get('/list', [CompaniesController::class, 'showList'])->name('list'); //GETを先に記述しておく
//POSTを先に書くと「The GET method is not supported for route api/store. Supported methods: POST.」のエラーが出る。

Route::post('/store', [SalesController::class, 'store'])->name('api.store'); //postmanからのリクエストが通るようにするためのルート
Route::middleware('auth:sanctum')->get('/user', function (Request $request) 
{
    return $request->user();
});
