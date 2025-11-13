@extends('admin.layouts.app')

@section('title', 'バナー管理')

    @vite('resources/sass/app.scss')
@yield('additional-styles')
    <link rel="stylesheet" href="{{ asset('/css/admin_banner.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">


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
    <a href="{{ route('admin.show.top') }}" class="back-link">←戻る</a>
    <div class="banner-container">
        <form method="POST" action="{{ route('admin.show.banner.update') }}" id="banner-form" enctype="multipart/form-data" >
        @csrf
            <h1 class="tittle">バナー管理</h1>
        
                <div class="banner-list">
                    @foreach ($banners as $banner)
                        <div class="banner-image" id="banner-id{{ $banner->id}}">
                            @if ($banner->img_path && File::exists(storage_path('app/public/images/banner/' . $banner->img_path)))
                                <img src="{{ asset('storage/images/banner/' . $banner->img_path) }}" alt="バナー画像" style="width: 100px">
                                <!--ファイルを選択-->
                                <input type="file" name="images[{{ $banner->id }}]" id="image_{{ $banner->id }}">
                                <!--削除アイコン-->
                                <i class="fa-solid fa-circle-minus" style="color: #ff0000;" onclick="markBannerDeletion({{ $banner->id }})"></i>
                            @else
                                <!-- 画像がない場合の表示（何も表示しない、または代替のメッセージを追加できます） -->
                            @endif
                        </div>  
                    @endforeach
                    <div class="info-row add-icon">
                        <!--新規追加-->
                        <i class="fa-solid fa-circle-plus" style="color: #63E6BE;" onclick="addBanner()"></i>
                    </div>
                    <div class="info-row btn-class">
                        <button class="btn btn-lg btn-secondary btn-block" type="submit" >登録</button>  
                    </div>
                </div>
        </form>
    </div>
    <script src="{{ asset('/js/banner_deletion.js') }}"></script>
    <script src="{{ asset('/js/banner_add.js') }}"></script> 
@endsection
