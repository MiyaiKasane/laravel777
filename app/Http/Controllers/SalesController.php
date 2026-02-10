<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Product; // Productモデルを使用
use App\Models\Sale; // Saleモデルを使用

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
        'name'       => 'required|string',
        'quantity'   => 'nullable|integer|min:1',
    ]);

    $productId = $validated['product_id'];
    $quantity  = $validated['quantity'] ?? 1;

    Log::info('store request all()2', $request->all());

    // リクエストから必要なデータを取得する
    $productId = $request->input('product_id'); // "product_id":7が送られた場合は7が代入される
    $quantity = $request->input('quantity', 1); // 購入する数を代入する もしも”quantity”というデータが送られていない場合は1を代入する

    // データベースから対象の商品を検索・取得
    $product = $this->product_model->getProduct($productId); //Productモデル:129行目を呼んでるやつ

    // 商品が存在しない、または在庫が不足している場合のバリデーションを行う
    if (!$product) {
        return response()->json(['message' => '商品が存在しません'], 404);
    }
    if ($product->stock < $quantity) {
        return response()->json(['message' => '商品が在庫不足です'], 400);
    }

    // 在庫を減少させる
    $this->product_model->decStock($productId); //Productモデル:135行目を呼んでるやつ
    
    // Salesテーブルに購入情報を記録する
    $this->sale_model->getSale($productId); //Saleモデル:16行目を呼んでるやつ


    /* return redirect()
    ->back()
    ->with('success', '購入が完了しました'); */

    //レスポンスを返す これはPostmanで動作確認する用
    return response()->json([
        'message' => '購入成功',
        'product_id' => $productId,
        'quantity' => $quantity,
    ],200);
}
}

