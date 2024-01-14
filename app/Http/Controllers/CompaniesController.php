<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model; //エロクワントを使用するための宣言
use Illuminate\Support\Facades\DB; //クエリビルダを使用する宣言
use Illuminate\Http\Request; //アプリケーション内でリクエストを処理するためのクラス
use App\Models\Companies; //Companyモデルを使うための宣言
use App\Models\Product\Products; //Productモデルを使うための宣言
use App\Models;

class CompaniesController extends Controller
{
    public function preView(){
        $model = new Products();
        $products = $model->products();
        dd($products);
    }

    public function showList()
    {
        return view('list');
    }
}

