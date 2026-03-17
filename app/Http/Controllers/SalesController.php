<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //クエリビルダを使用する宣言
use Illuminate\Support\Facades\Log;
use App\Models\Product; // Productモデルを使用
use App\Models\Sale; // Saleモデルを使用
use App\Models\Company; //Companyモデルを使うための宣言


class SalesController extends Controller{ //モデルがすぐ使えるようになる
    public function __construct(
       private Product $product_model = new Product,
       private Sale $sale_model = new Sale
    ){}

    public function store(Request $request)
{
    Log::info('store request all()1', $request->all());

    // 1. バリデーション（ここで product_id が必須なことを保証）
    $validated = $request->validate([
        'product_id' => 'required|integer',
        'quantity'   => 'nullable|integer|min:1',
    ]);

    //ここでバリデーションを通過できたデータを変数に入れてる
    $productId = $validated['product_id'];
    $quantity  = $validated['quantity'] ?? 1;

    Log::info('store request all()2', $request->all());

    /* リクエストから必要なデータを取得する ↓でもデータの取得はできるが、上のバリデーションで必須項目を保証しているので、ここでは$validatedから直接値を取得するほうが安全でコードもすっきりする。
    $productId = $request->input('product_id'); // "product_id":7が送られた場合は7が代入される
    $quantity = $request->input('quantity', 1); // 購入する数を代入する もしも”quantity”というデータが送られていない場合は1を代入する */

    // データベースから対象の商品を検索・取得
    $product = $this->product_model->getProduct($productId); //Productモデル:129行目を呼んでるやつ

    // 商品が存在しない、または在庫が不足している場合のバリデーションを行う
    if (!$product) {
        return response()->json(['message' => '商品が存在しません'], 404);
    }
    if ($product->stock < $quantity) {
        return response()->json(['message' => '商品が在庫不足です'], 400);
    }

    try 
    {
        DB::transaction(function()use($productId, $quantity) {
        $this->product_model->decStock($productId); //在庫を減らす
        $this->sale_model->createSale($productId); //購入情報をSalesテーブルに記録する
        });
            
        \Log::info('購入できました');

        return response()->json([
        'message' => '購入成功',
        'product_id' => $productId,
        'quantity' => $quantity,
        'stock_after' => $product->stock - $quantity 
        ], 200);
    }
        
    catch (\Exception $e)
    {
        \Log::error('エラー：', ['exception' => $e]);
        return back()->withErrors(['error' => $e->getMessage()]);
    }
    
    /* Salesテーブルに購入情報を記録する
    $this->sale_model->createSale($productId); //Saleモデル:19行目を呼んでるやつ */

    // デバッグ用ログ出力
    /*Log::info('SalesController@store hit', ['data' => $request->all()]);

    return response()->json([
        'ok'   => true,
        'from' => 'SalesController@store',
        'data' => $request->all(),
    ], 200);*/
}
}

