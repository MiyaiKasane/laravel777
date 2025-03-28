<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"><!--言語を取得してる。config\app.phpのlocaleの部分-->
    <head>
        <meta charset="utf-8">
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>商品一覧画面</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="{{ asset('css/list_blade.css') }}" rel="stylesheet">
    </head>
    <body>
      <form action="{{route('logout')}}" method="post">
        @csrf
        <div class="logout">
            <button type="submit" id="logout">ログアウト</button>
        </div>
      </form>

      <div class="box"> 
      <form action="{{route('list')}}" method="get"><!--method="get"のときはcsrfいらない-->
        <div>
            <h2>商品一覧画面</h2>
            <div class="search">
                <input type="search" name="search" class="formCont" placeholder="検索キーワード" value="{{ request('search') }}"><!--商品名の検索 searchの名前でサーバーに送られる-->
                <select type="search" name="company_id" id="company_id" class="input" placeholder="メーカー名" value="{{ request('maker') }}"><!--メーカー名の検索-->
                        <option value=""></option><!--初期値用の空行-->
                        @foreach($companies as $company)<!--companies配列の中のすべての値をループで表示-->
                        <option value="{{ $company->id }}">{{ $company->company_name }}</option><!--DB内のメーカー名を取得するための記載。company_idの名前でサーバーに送られる-->
                        @endforeach
                </select>
                <input type="submit" name="submit" class="kensaku" value="検索" ><!--検索ボタン-->
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
    </body>
</html>
