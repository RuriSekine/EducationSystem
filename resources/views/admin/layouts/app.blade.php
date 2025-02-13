<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '管理画面')</title>
    {{-- 必要最低限のCSS/JSを読み込み --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
        {{-- 共通ヘッダー部分（他の人が作成） --}}
        @yield('header')
    </header>
    <main>
        {{-- 各ページ固有のコンテンツ --}}
        @yield('content')
    </main>
    <footer>
        <p>&copy; 管理画面 2024</p>
    </footer>
</body>
</html>
