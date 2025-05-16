@extends('layouts.app')   <!--① これがレイアウトファイルを継承する宣言 -->
@section('title', '商品情報編集画面')

@section('styles')
  <link href="{{ asset('css/pedit_blade.css') }}" rel="stylesheet">
@endsection

    @section('content')
        <div class="box">
            <div>
                <h2>商品情報編集画面</h2>
            </div>

            @if ($errors->any()) <!-- エラーが出たときに表示される部分 -->
                <div class="alert">
                    @foreach ($errors->all() as $error)
                        <div class="error">{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            @if(session('success'))
                <div class="alert">
                    <div class="success">{{ session('success') }}</div>
                </div>
            @endif

            <div class="newTable">
                <form action="{{route('pedit.update',$product->id)}}" method="post" enctype='multipart/form-data' class='editForm'>
                    @csrf
                    @method('put')
                    <input type="hidden" name="id" value="{{$product->id}}" >
                    <div class="formSell select_id">
                        <label for="productName" class="thLabel">ID</label>
                        <p class="product_id">{{ $product->id }}</p>
                    </div>
                    <div class="formSell">
                            <label for="productName" class="thLabel">商品名<span class="Astalisk">*</span></label>
                            <input id="productName" type="text" name="productName" class="input" value="{{ old('product_name', $product->product_name) }}">
                    </div>
                    <div class="formSell">
                            <label for="Choice" class="thLabel">メーカー名<span class="Astalisk">*</span></label>
                            <select id="Choice" name="Choice" class="input" value="{{ old('company_name', $product->company_name) }}">
                                @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="formSell">
                            <label for="Price" class="thLabel">価格<span class="Astalisk">*</span></label>
                            <input id="Price" type="text" name="Price" class="input" value="{{ old('price', $product->price) }}">
                    </div>
                    <div class="formSell">
                            <label for="Stock" class="thLabel">在庫数<span class="Astalisk">*</span></label>
                            <input id="Stock" type="text" name="Stock" class="input" value="{{ old('stock', $product->stock) }}">
                    </div>
                    <div class="formSell">
                            <label for="Comment" class="thLabel">コメント</label>
                            <textarea rows="3" cols="30" id="Comment" name="Comment" class="input">{{ old('comment', $product->comment) }}</textarea>
                    </div>
                    <div class="formSell">
                            <label for="Image" class="thLabel">商品画像</label> 
                            <input id="Image" type="file" name="Image" class="input"><!-- 新しい画像アップロード欄 -->

                            @if (!empty($product->img_path))<!-- !empty→画像が入力されている場合、img_pathのデータを引っ張ってくる -->
                                <div>
                                    <p>現在の画像：</p><!-- 現在の画像アップロード欄 -->
                                    <img src="{{ asset($product->img_path) }}" alt="商品画像" style="width: auto; height: 85px;">
                                </div>
                            @endif
                    </div>

                    <div class="Button">
                        <button type="submit" class="update">更新</button>
                        <button type="button" class="back" onclick="location.href='{{ route('pdetail',$product->id) }}'">戻る</button>
                    </div>
                    
                </form>
            </div>
        </div>
    @endsection
