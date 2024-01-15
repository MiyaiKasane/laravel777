<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model; //エロクワントを使用するための宣言
use Illuminate\Support\Facades\DB; //クエリビルダを使用する宣言
use Illuminate\Http\Request; //アプリケーション内でリクエストを処理するためのクラス
use App\Models\Company\companies; //Companyモデルを使うための宣言
use App\Models\Product\products; //Productモデルを使うための宣言
use App\Models;

class CompaniesController extends Controller
{

    public function showList()
    {
        return view('list');
    }
}

