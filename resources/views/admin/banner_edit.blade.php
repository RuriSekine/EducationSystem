@extends('admin.layouts.app')

@section('title', 'バナー管理')

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
        <form method="POST" action="{{ route('admin.banner.update') }}" id="banner-form" enctype="multipart/form-data" >
        @csrf
            <h1 class="tittle">バナー管理</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
                </div>
            @endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
                <div class="banner-list">
                    @foreach ($banners as $banner)
                        <div class="banner-image" id="banner-id{{ $banner->id}}">
                            @if ($banner->image && File::exists(storage_path('app/public/images/banner/' . basename($banner->image))))
                                <img src="{{ asset('storage/images/banner/' . basename($banner->image)) }}" alt="バナー画像" style="width: 200px">
                                <!--ファイルを選択-->
                                <button type="button" class="file-btn" onclick="document.getElementById('image_{{ $banner->id }}').click()">ファイルを選択</button>
                                <input type="file" name="images[{{ $banner->id }}]" id="image_{{ $banner->id }}" style="display:none;" onchange="updateFileLabel(this)">
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
