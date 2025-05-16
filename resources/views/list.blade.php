
@extends('layouts.app')   <!--① これがレイアウトファイルを継承する宣言 -->
@section('title', '商品一覧画面')

@section('styles')
  <link href="{{ asset('css/list_blade.css') }}" rel="stylesheet">
@endsection

<script src="{{ asset('js/list.js') }}"></script>
    @section('content')
      <form action="{{route('logout')}}" method="post">
        @csrf
        <div class="logout">
            <button type="submit" id="logout">ログアウト</button>
        </div>
      </form>

      <div class="box"> 
      <form id="searchForm" action="{{ route('list') }}" method="get"><!--method="get"のときはcsrfいらない-->
        <div>
            <h2>商品一覧画面</h2>
            <div class="search">
                <input type="search" name="search" id="search" class="formCont" placeholder="検索キーワード" value="{{ request('search') }}"><!--商品名の検索 searchの名前でサーバーに送られる-->
                <select name="company_id" id="company_id" class="input" placeholder="メーカー名"><!--メーカー名の検索-->
                        <option value="">メーカー名を選択</option><!--初期値用の空行-->
                        @foreach($companies as $company)<!--companies配列の中のすべての値をループで表示-->
                        <option value="{{ $company->id }}">{{ $company->name }}</option><!--DB内のメーカー名を取得するための記載。company_idの名前でサーバーに送られる-->
                        @endforeach
                </select>
                <input type="submit" class="kensaku" id="kensaku" value="検索">
            </div>
        </div>
      </form>
      
        <div class="TablE">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>商品名</th>
                        <th>商品画像</th>
                        <th>価格</th>
                        <th>在庫数</th>
                        <th>メーカー名</th>
                        <th><button id="new" onclick="location.href='{{ route('new') }}'">新規登録</button></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td><img class="imgfile" src="{{ asset($product->img_path) }}" alt="商品画像"></td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->company->company_name }}</td>
                        <td>
                            <button class="detail" onclick="location.href='{{ route('pdetail', $product->id) }}'">詳細</button>
                            <form action="{{ route('list.delete', $product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="delete" type="submit" onclick='return confirm("削除しますか？")'>削除</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
      </div>
    @endsection               <!-- ③ 最後にセクションを閉じる -->