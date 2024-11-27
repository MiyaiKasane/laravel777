<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB; //クエリビルダを使用する宣言
use Illuminate\Http\Request; //アプリケーション内でリクエストを処理するためのクラス
use App\Http\Requests\PostRequest; //Requestファイル使うための宣言
use App\Models\Company; //Companyモデルを使うための宣言
use App\Models\Product; //Productモデルを使うための宣言
use Illuminate\Support\Facades\Storage; //storageファイル使うための宣言
use Illuminate\Database\Eloquent\Model; //エロクワントを使用するための宣言
use Illuminate\Support\Facades\Log; //デバッグ、エラーログ（Log::~）を使用するため


class CompaniesController extends Controller
{
    public function showList(Request $request) //一覧データ表示するための処理
    {
        $model = new Product();
        $products = $model->getList();

        function searchBox(Request $request)  //検索用の処理 
        {   
            $search = $request->input('search');
            $maker = $request->input('maker');
            $model = new Product();
            $products = $model->getKeyword($search,$maker); //productモデルにあるgetKeyword();
        }
        return view('list', ['products'=> $products]); //一番最後に持ってくる
    }
        
    
    public function registSubmit(PostRequest $request) //データを新しく登録して保存する
    {
        //\Log::info('registSubmit通過');
        /*入力されたデータがバリデーションルールに従ってるかチェックしてる
        ↓これがあればコントローラーでバリデーションルール（required|integer…)とかを書く必要がない。*/
        $validatedData = $request->validated();

        //送られてきたデータに画像が含まれているか確認するためのif文
        $image_path = null; // 画像が含まれていない場合の処理
        if ($request->hasFile('Image')) {
            $image = $request->file('Image'); // 画像ファイルの取得
            $file_name = $image->getClientOriginalName(); // 画像ファイルのファイル名を取得
            $image->storeAs('public/images', $file_name); // public/images フォルダ内に、取得したファイル名で保存
            $image_path = 'storage/images/'. $file_name; // データベース登録用に、ファイルパスを作成
        }

        // トランザクション開始
        DB::beginTransaction();
        try 
        {
            $model = new Product();
            $model->insertData($request, $image_path);
            DB::commit();
            \Log::info('新規登録されました。');
            return redirect(route('new'))->with('success', '新規登録が完了しました。');
        } 
        catch (\Exception $e) 
        {
            DB::rollback();
            \Log::error('エラー：', ['exception' => $e]);
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function updateData(PostRequest $request,$id)
    {
        //dd('updateDataのとこ　更新するID: ' . $id);
        //\Log::info('updateData通過　①');
        $validatedData = $request->validated();

        $image_path = null; // 画像が含まれていない場合の処理
        if ($request->hasFile('Image')) {
            $image = $request->file('Image'); // 画像ファイルの取得
            $file_name = $image->getClientOriginalName(); // 画像ファイルのファイル名を取得
            $image->storeAs('public/images', $file_name); // public/images フォルダ内に、取得したファイル名で保存
            $image_path = 'storage/images/'. $file_name; // データベース登録用に、ファイルパスを作成
        }
        //\Log::info('updateDataのバリデーション前通過　更新するID:② ' . $id);


        DB::beginTransaction();
        try 
        {
            $model = new Product();
            $model->dataSave($id, $request, $image_path); // 更新メソッドを呼び出し
            //\Log::info('dataメソッド呼び出し後、商品情報が更新されました。③');
            DB::commit();
            return redirect()->route('pdetail', ['id' => $id])->with('success', '商品情報が更新されました。④');
        } 
        catch (\Exception $e) 
        {
            DB::rollback();
            \Log::error('エラー：', ['exception' => $e]);
            return back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function showNewform()//新規登録ページを表示するための処理
    {
        //\Log::info('showNewform通過 ID:' . $id);
        $model_company = new Company();
        $companies = $model_company->getList(); //メーカー名の選択肢（@foreach）を表示してる
        return view('new',['companies' => $companies]);
    }

    public function showPdetail($id)//商品詳細ページを表示するための処理
    {
        \Log::info('showPdetail通過 ID:' . $id);
        $product = Product::find($id); //選択した商品のIDを取得してる
        return view('pdetail', ['product'=> $product]);
    }

    public function showPedit($id)//商品情報詳細ページを編集するための処理
    {
        \Log::info('showPedit通過 ID:' . $id);
        $product = Product::find($id); //選択した商品のIDを取得してる
        $companies = Company::all();   //メーカー名の選択肢を取得してる
        return view('pedit', compact('product','companies','id')); //compact()で複数の引数をpedit.viewに表示されるようにしてる
    }

    public function destroy($id)//削除ボタンの処理
    {
        //テーブルから指定のIDのレコード1件を取得
        $destroy = Product::find($id); //選択した商品のIDを取得してる
        //レコードを削除
        $destroy->delete();
        //削除したら一覧画面にリダイレクト
        return redirect()->route('list');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function __construct() //未承認のユーザーをブロックするための記述。middlewareとは送信リクエストの処理をするとこ
    {
       $this->middleware('auth');
    }
}
