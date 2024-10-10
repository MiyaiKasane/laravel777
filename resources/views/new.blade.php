<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        <meta charset="utf-8">
        <link rel="dns-prefetch" href="//fonts.gstatic.com"><!--ひつよう？-->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>新規登録</title>
        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="{{ asset('css/new_blade.css') }}" rel="stylesheet">
</head>
    <body>
        <div class="box">
            <div>
                <h2>商品新規登録画面</h2>
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


            <form action="{{route('insert_data')}}" method="post" enctype='multipart/form-data' class="newForm">
                @csrf
                <div>
                        <div class="formSell">
                            <label for="productName" class="thLabel">商品名<span class="Astalisk">*</span></label>
                            <input id="productName" type="text" name="productName" class="input" value="{{ old('productName') }}">
                        </div>
                        <div class="formSell">
                            <label for="Choice" class="thLabel">メーカー名<span class="Astalisk">*</span></label>
                            <select id="Choice" name="Choice" class="input" value="{{ old('Choice') }}">
                                @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="formSell">
                            <label for="Price" class="thLabel">価格<span class="Astalisk">*</span></label>
                            <input id="Price" type="text" name="Price" class="input" value="{{ old('Price') }}">
                        </div>
                        <div class="formSell">
                            <label for="Stock" class="thLabel">在庫数<span class="Astalisk">*</span></label>
                            <input id="Stock" type="text" name="Stock" class="input" value="{{ old('Stock') }}">
                        </div>
                        <div class="formSell">
                            <label for="Comment" class="thLabel">コメント</label>
                            <textarea rows="3" cols="30" id="Comment" name="Comment" class="input" value="{{ old('Comment') }}"></textarea>
                        </div>
                        <div class="formSell">
                            <label for="Image" class="thLabel">商品画像</label>
                            <input id="Image" type="file" name="Image" class="input" value="{{ old('Image') }}">
                        </div>
                            <button type="submit" class="newsubmit">新規登録</button>
                            <button type="button" class="back" onclick="location.href='{{ route('list') }}'">戻る</button>
                            <!-- 新規登録部分の"location.href=~~"でもいいし、type=""を指定してからonclick="history.back()"でも可 -->
                </div>   
            </form>
        </div> 
    </body>
</html>
