<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- style -->
    @stack('styles')
    <link rel = "stylesheet" href = "{{ asset('css/header.css') }}">

    <!-- script -->
    @stack('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<body>
    <div id="app">
        <!-- {{-- ユーザーの各種画面に表示させる共通ヘッダーはこちら --}} -->
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">

                <!-- {{-- ナビゲーションバーの共通ヘッダー部分 --}} -->
                <header class="collapse navbar-collapse" id="navbarSupportedContent">
                    @if(!Route::is('user.login') && !Route::is('user.register'))
                    <ul class = "userheader-content">
                        @auth
                        <!-- {{-- 時間割・授業進捗・プロフィール設定への各種画面への遷移させるためのボタン --}} -->
                            <button class="userheader-button" onclick="location.href='{{ route('user.show.curriculum', ['id' => 1]) }}'">時間割</button>
                            @if(isset($curriculum))
                                <button class="userheader-button" onclick="location.href='{{ route('user.show.progress', ['id' => $curriculum->id]) }}'">授業進捗</button>
                            @else
                                <button class="userheader-button" onclick="location.href='{{ route('user.show.progress', ['id' => 1]) }}'">授業進捗</button> 
                            @endif
                            <button class = "userheader-button" onclick = "location.href = '{{ route('user.update.profile') }}'">プロフィール設定</button>

                                <!-- {{-- ログインしているユーザーの画面で表示させるログアウトリンク --}} -->
                            <a class="nav-link" href="{{ route('user.logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            ログアウト
                            </a>
                            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                            @csrf
                            </form>

                            @else
                            <!-- {{-- 未ログインユーザー向けの共通ヘッダー --}} -->
                            <button class="userheader-button" onclick="location.href='{{ route('user.login') }}'">時間割</button>
                            <button class="userheader-button" onclick="location.href='{{ route('user.login') }}'">授業進捗</button>
                            <button class="userheader-button" onclick="location.href='{{ route('user.login') }}'">プロフィール設定</button>
                            <!-- {{-- 未ログイン状態ではログイン表記に変更する --}} -->
                            <a class="nav-link" href="{{ route('user.login') }}">ログイン</a>
                        @endauth
                    </ul>
                    @endif
                </header>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
        <!-- Scripts -->
    @stack('scripts')
</body>
</html>