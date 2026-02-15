<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Article extends Model//Gitにあげるテスト用
{
  public function getList() 
  {
    $articles = DB::table('articles')->get();
    return $articles;
  }
  public function registArticle($data) // 登録処理
  {
    DB::table('articles')->insert([
        'title' => $data->title,
        'url' => $data->url,
        'comment' => $data->comment,
    ]);
  }
}
