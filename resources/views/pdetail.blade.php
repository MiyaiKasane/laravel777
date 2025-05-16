@extends('layouts.app')   <!--① これがレイアウトファイルを継承する宣言 -->
@section('title', '商品情報詳細画面')

@section('styles')
  <link href="{{ asset('css/pdetail_blade.css') }}" rel="stylesheet">
@endsection

    @section('content')
        <div class="box">
            <div>
                <h2>商品情報詳細画面</h2>
            </div>

            <div class="newTable">
            <form action="{{route('pdetail', $product->id)}}" method="put" enctype='multipart/form-data' class="newForm">
                @csrf
                <table>
                    <tr>
                        <th>ID</th>
                        <td>{{ $product->id }}</td>
                    </tr>
                    <tr class="Pimage">
                        <th>商品画像</th>
                        <td><img class="imgfile" src="{{ asset($product->img_path) }}" alt="商品画像" style="width: auto; height: 120px;"></td>
                    </tr>
                    <tr>
                        <th>商品名</th>
                        <td>{{ $product->product_name }}</td>
                    </tr>
                    <tr>
                        <th>メーカー名</th>
                        <td>{{ $product->company->company_name }}</td>
                    </tr>
                    <tr>
                        <th>価格</th>
                        <td>{{ $product->price }}</td>
                    </tr>
                    <tr>
                        <th>在庫数</th>
                        <td>{{ $product->stock }}</td>
                    </tr>
                    <tr class="Comment">
                        <th>コメント</th>
                        <td>{{ $product->comment }}</td>
                    </tr>
                </table>
            </form>
                
                <div class="Button">
                    <button class="edit" onclick="location.href='{{ route('pedit', $product->id) }}'">編集</button>
                    <button class="back" onclick="location.href='{{ route('list') }}'">戻る</button>
                </div>

            </div>
        </div>
    @endsection
