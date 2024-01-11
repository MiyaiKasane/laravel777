<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model; //エロクワントを使用するための宣言
use Illuminate\Support\Facades\DB; //クエリビルダを使用する宣言
use Illuminate\Http\Request; //アプリケーション内でリクエストを処理するためのクラス
use APP\Models\Company; //Companyモデルを使うための宣言
use APP\Models\Product; //Productモデルを使うための宣言
use APP\Models\Sale; //Saleモデルを使うための宣言
use APP\Models;

class CompaniesController extends Controller
{

    public function showList()
    {
        return view('list');

    }

    public function rilation (){
        $model = new Product();
        $products = $model->products();
        dd($products);
        return view('companies.rilation',['products' => $products]);
    }
}

