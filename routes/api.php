<?php
use App\Http\Controllers\SalesController; //SalesControllerと接続で大丈夫そ？
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompaniesController;

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


Route::post('/sales', [SalesController::class, 'store'])->name('api.sales.store');
Route::get('/api/list/{$request}', [CompaniesController::class, 'showList']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) 
{
    return $request->user();
});
