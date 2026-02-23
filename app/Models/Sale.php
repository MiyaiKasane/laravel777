<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Product; // Productモデルを使用
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CompaniesController;

class Sale extends Model //SalesControllerかCompanyControllerからのリクエストを受け取って、DB処理を実行する。必要に応じて結果を返却。
{
    use HasFactory;
    protected $table = 'sales';//テーブルの紐づけ

    // Salesテーブルに商品IDと購入日時を記録する（Saleテーブルに対する動作だからSaleモデルに書く）
    public function createSale($productId) //Salesコントローラー:50行目に呼び出されるやつ
    {
        DB::table('sales')->insert([
            'product_id' => $productId,     //主キーであるIDと、created_at , updated_atは自動入力されるため不要
            //'quantity' => 1,
            /*↑今回は1個ずつしか購入できない仕様なのでquantityは1で固定しているけど
            そもそもquantityをここに書いてもDBのほうで対応するカラムがないからエラーになる*/
        ]);
        Log::info('createSaleLog', ['product_id' => $productId]);

    }

    public function products ()  //productテーブルへのリレーション　多(sale)対１(product) 一つの製品に対して複数の購入履歴がある
    {
        return $this->belongsTo(Product::class,'App\Models\Product');
    }
}

