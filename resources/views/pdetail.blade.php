<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        <meta charset="utf-8">
        <link rel="dns-prefetch" href="//fonts.gstatic.com"><!--ひつよう？-->
        <meta name="csrf-token" content="{{ csrf_token() }}"><!--ひつよう？-->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>商品詳細</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="{{ asset('css/pdetail_blade.css') }}" rel="stylesheet">
</head>
    <body>
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
                        <td><img class="imgfile" src="{{ asset($product->img_path) }}" alt="商品画像" style="width: auto; height: 130px;"></td>
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
    </body>
</html>
