@extends('user.layouts.app')
{{-- app.blade.phpを継承 --}}

@section('content')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel = "stylesheet" href = "{{ asset('css/top.css') }}">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
<script src = "{{ asset('js/swiper.js') }}" defer></script>
@endpush

<div class = "container">

    <!-- {{-- 管理者が設定したバナー画像表示箇所(バナー表示箇所全体)--}} -->
    <div class = "swiper">
        <div class = "swiper-wrapper">
            @foreach($banners as $banner)
                <div class = "swiper-slide">
                    <img class = "banner" src = "{{ asset('storage/' . $banner->image) }}" alt = "Slide Image">
                </div>
            @endforeach
        </div>
            <div class = "swiper-pagination"></div>
            <div class = "swiper-button-prev"></div>
            <div class = "swiper-button-next"></div>
    </div>

<!-- お知らせセクション -->
    <div class="notice-section">
        <h2>お知らせ</h2>
        <div class="notice-container">
            <ul class="notice-list">
                @foreach($articles as $article)
                <li class = "notice-item">
                    <span class = "notice-date">
                        {{ $article->posted_date->format('Y年m月d日')}}
                    </span>
                    @auth
                    <a href = "{{ route('user.show.article', $article->id) }}" class = "notice-title">{{ $article->title }}</a>
                    <!-- ログイン状態ならタイトルをリンクにしてクリックすれば詳細ページに遷移出来る。 -->
                    @else
                    <span class = "notice-date" >{{ $article->title }}</span>
                    <!-- ログインしていない状態ならタイトルをテキストにして詳細ページには遷移できないようにする。 -->
                    @endauth
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection