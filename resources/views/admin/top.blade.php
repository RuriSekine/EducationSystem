@extends('admin.layouts.app')

@section('title', 'トップページ')

    @vite('resources/sass/app.scss')
@yield('additional-styles')
    <link rel="stylesheet" href="{{ asset('/css/admin_top.css') }}">

@section('left-item')
    <li class="nav-item">
        <a class="nav-link left-link" href="{{ route('admin.show.curriculum.list') }}">{{ __('授業管理') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link left-link" href="{{ route('admin.show.article.list') }}">{{ __('お知らせ管理') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link left-link" href="{{ route('admin.show.banner.edit') }}">{{ __('バナー管理') }}</a>
    </li>
@endsection

@section('right-item')
    @auth
        <li class="nav-item">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link right-link">
                    {{ __('ログアウト') }}
                </button>
            </form>
        </li>
    @endauth
@endsection

@section('content')
    <div class="card mb-3">
        <div class="card-body login-info">
            <div class="info-row">
                <span class="label">ユーザーネーム</span>
                <span class="colon">：</span>
                <span class="value">{{ Auth::guard('admin')->user()->name }}</span>
            </div>
            <div class="info-row">    
                <span class="label">メールアドレス</span>
                <span class="colon">：</span>
                <span class="value">{{ Auth::guard('admin')->user()->email }}</span>
            </div>
        </div>
    </div>
    
@endsection
