<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;//クエリビルダとEloquentの併用はできるけど基本的に統一したほうがいい。
use Illuminate\Support\Facades\DB;
use App\Models\Company;//Companyモデルを使うための宣言
use App\Http\Controllers\CompaniesController;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Log; //デバッグ、エラーログ（Log::~）を使用するため


class Product extends Model
{
    use HasFactory;
    protected $table = 'products';//テーブルの紐づけ
    
    public function products ()
    {
        $product = Self::all(); //この記述はクエリビルダだけどuse宣言してなかったとしても併用できる。
        return $product;

    }

    public function company ()  //companyテーブルへのリレーション　1対多
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }

    public function sale ()     //saleテーブルへのリレーション　１対多
    {
        return $this->belongsTo(Sale::class,'App\Models\Sale');
    }

    public function getList() 
    {
        $products = Self::all();
        return $products;
    }


    private function setData($product,$request, $image_path) //insertData();とdataSave();共通のデータ設定処理
    {
        \Log::info('setData通過');
        //$product = new Product();  //　※idは自動で附番されていくのでinput('id')をする必要はない
        $product -> product_name = $request->input("productName");
        $product -> company_id = $request->input("Choice");
        $product -> price = $request->input("Price");
        $product -> stock = $request->input("Stock");
        $product -> comment = $request->input("Comment");
        $product -> img_path = $image_path;
        return $product; //ここでreturnしないと「Call to a member function save() on null」のエラーが出る
    }
    

    public function insertData($request, $image_path) //追加されたデータを登録する処理
    {
        \Log::info('insertData通過');
        $product = new Product();
        $product = $this->setData($product,$request,$image_path);
        $product -> save();
    }

    
    
    public function dataSave($id, $request, $image_path)//更新する処理
    {
        $product = Product::find($id); //既存のデータから編集したいデータを取得
        \Log::info('dataSave通過'. $id);
        if($product){
           $product = $this->setData($product,$request,$image_path);
           //\Log::info('dataSaveメソッドの$productの中身');
           $product -> save();
        } else
        {
            throw new \Exception('Product not found');
        }
    }
    

    public function getKeyword($search,$maker) //検索ワードの取得
    {
        $query = Self::query();

        if($search){
           $query->where('product_name','like',"%{$search}%");
           if($maker){
              $query->where('company_name','like',"%{$maker}%");
           }
        }

        $products = $query->get();
        return $products;
    }
}