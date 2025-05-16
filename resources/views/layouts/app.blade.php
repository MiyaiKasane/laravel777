<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRFトークン -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- タイトル（各ページで上書き可） -->
    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- フォント -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- 共通CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- ページ専用CSS -->
    @yield('styles')

    <!-- jQueryなど共通スクリプト -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- ページ専用スクリプト -->
    @yield('scripts')
</head>
<body>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
