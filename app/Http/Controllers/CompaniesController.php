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
    public function showList(Request $request) //Requestを受け取り、検索処理するメソッド
    {
        $query = Product::with('company'); // ← 関連テーブル(companyテーブルの内容)を先読みするよという指示
        $companies = Company::all(); //companyモデルから会社データを取得
        $search = $request->input('search'); //requestフォームから送られた該当のsearchを取得
        $company_id = $request->input('company_id'); //requestフォームから送られた該当のidを取得
        $max_price = $request->input('max_price');
        $min_price = $request->input('min_price');
        $max_stock = $request->input('max_stock');
        $min_stock = $request->input('min_stock');
        \Log::info('データ受け取った', ['request' => $request->all()]);

        if ($search) {
            $query->where('product_name', 'LIKE', "%{$search}%"); //変数searchに値がある場合、product_nameの中で該当する商品を検索する
        }
        if ($company_id) {
            $query->where('company_id',$company_id); //変数company_idに値がある場合、company_idの中で該当する商品を検索する
        }
        if (!is_null($min_price) && $min_price !== '') {
            $query->where('price','>=',(int)$min_price); //価格範囲で検索
        }
        if (!is_null($max_price) && $max_price !== '') {
            $query->where('price','<=',(int)$max_price); 
        }
        if (!is_null($min_stock) && $min_stock !== '') {
            $query->where('stock','>=',(int)$min_stock); //在庫範囲で検索
        }
        if (!is_null($max_stock) && $max_stock !== '') {
            $query->where('stock','<=',(int)$max_stock); 
        }
            // 何も検索していない場合、通常の一覧を取得。検索結果を$productsに格納する。
            //orderBy('id', 'desc')でidの降順に並び替え
        $products = $query->orderBy('id', 'desc')->get();

        if($request->ajax()){
        \Log::info('ajaxの場合Jsonで返す', ['request' => $request->all()]);
        //ajaxリクエストの場合、JSON形式でデータを返す
        
            return response()->json([
                'products' => $products,
                'companies' => $companies
            ]);
        }
        else{
            \Log::info('ajaxでない場合通常のviewで返す', ['request' => $request->all()]);
            //ajaxリクエストでない場合、通常のビューを返す

            return view('list', compact('products', 'companies')); 
            //compact()で複数の引数をlist.viewに表示されるようにしてる。
            //$productsの中に既に各商品の価格（price）と在庫数（stock）の情報が含まれているため、priceやstockは個別に渡してない。
        }
    }
    
    public function registSubmit(PostRequest $request) //データを新しく登録して保存する
    {
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
        $validatedData = $request->validated();

        $image_path = null; // 画像が含まれていない場合の処理
        if ($request->hasFile('Image')) {
            $image = $request->file('Image'); // 画像ファイルの取得
            $file_name = $image->getClientOriginalName(); // 画像ファイルのファイル名を取得
            $image->storeAs('public/images', $file_name); // public/images フォルダ内に、取得したファイル名で保存
            $image_path = 'storage/images/'. $file_name; // データベース登録用に、ファイルパスを作成
        }


        DB::beginTransaction();
        try 
        {
            $model = new Product();
            $model->dataSave($id, $request, $image_path); // 更新メソッドを呼び出し
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
        $product = Product::find($id); //選択した商品のIDを取得してる
        $companies = Company::all();   //メーカー名の選択肢を取得してる
        return view('pedit', compact('product','companies','id')); //compact()で複数の引数をpedit.viewに表示されるようにしてる
    }

    public function destroy($id)//削除ボタンの処理　Ajax対応にした
    {
        //テーブルから指定のIDのレコード1件を取得
        $destroy = Product::find($id); //選択した商品のIDを取得してる
        \Log::info('destroy通過 ID:' . $id);
        if ($destroy){
            $destroy->delete(); //レコードを削除
            if(request()->ajax()) { //ここでAjaxだったらjsファイル、そうでなければコントローラーの削除処理で対応？
                \Log::info('Controllerのajax destroy通過 ID:' . $id);
                return response()->json(['success' => true]); //削除したら一覧画面にリダイレクト　したいけどうまくいってない
            } //2)非同期にて削除したあと、画面を更新しないと削除したアイテムが残り続けてしまします。非同期で削除したら画面更新をせずとも一覧からアイテムが消えるように調整してみてください！
        }
        return redirect()->route('list');
    }


    public function __construct() //未承認のユーザーをブロックするための記述。middlewareとは送信リクエストの処理をするとこ
    {
       $this->middleware('auth');
    }
}
