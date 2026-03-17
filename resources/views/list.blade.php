
@extends('layouts.app')   <!--① これがレイアウトファイルを継承する宣言 -->
@section('title', '商品一覧画面')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/css/theme.default.min.css">
    <link href="{{ asset('css/list_blade.css') }}" rel="stylesheet">
@endsection

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
                            <option value="{{ $company->id }}">{{ $company->company_name }}</option><!--DB内のメーカー名を取得するための記載。company_idの名前でサーバーに送られる-->
                        @endforeach
                </select>
                <button id="kensaku" name="kensaku">検索</button>

                <div class="priceSearch">
                    <label for="price" class="priceLabel">{{ __('価格') }}</label>
                    <div class="max">
                        <p>{{ __('上限') }}</p>
                        <input type="number" name="max_price" id="max_price" >
                    </div>

                    <div class="min">
                        <p>{{ __('下限') }}</p>
                        <input type="number" name="min_price" id="min_price" >
                    </div>
                </div>

                <div class="stockSearch">
                    <label for="stock" class="stockLabel">{{ __('在庫数') }}</label>
                    <div class="max">
                        <p>{{ __('上限') }}</p>
                        <input type="number" name="max_stock" id="max_stock" >
                    </div>

                    <div class="min">
                        <p>{{ __('下限') }}</p>
                        <input type="number" name="min_stock" id="min_stock" >
                    </div>
                </div>
            </div>
        </div>
      </form>
      
        <div class="TablE">
            <table id="thsorter" class="tablesorter">
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
                            
                            <!--<form action="{{ route('api.store')}}" method="POST"> webからでも減算処理したいときの記述。web.phpには対応するルートを記述しておくこと
                                @csrf
                                @method('POST')
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="name" value="{{ Auth::user()->name ?? 'webuser' }}">
                                <input type="hidden" name="quantity" value="1">
                                <button class="store" type="submit" onclick='return confirm("購入しますか？")'>購入</button>
                            </form>-->


                            <form action="{{ route('list.delete', $product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="delete" type="submit" data-id="{{ $product->id }}">削除</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @section('scripts')           <!-- ② セクションの開始 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js"></script> <!--tablesorterの読み込み-->
    <script src="{{ asset('js/list.js') }}"></script> <!--list.jsファイルを読み込む-->
    <script>
    //以下、tablesorterの設定
        $(function() {
            $('#thsorter').tablesorter({
                headers:{
                //2:{sorter: false}  // 7列目（インデックス6）をソート対象外に設定
                6:{sorter: false}  // 7列目（インデックス6）をソート対象外に設定
                }
            })
        });
    </script>
    @endsection

@endsection           <!-- ③ 最後にセクションを閉じる -->