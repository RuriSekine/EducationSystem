@extends('user.layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">{{ $curriculum->title }}</h1>

    <!-- 学年情報 -->
    <p><strong>学年:</strong> {{ $curriculum->grade->name ?? '学年情報なし' }}</p>

    <!-- 授業内容 -->
    <p><strong>内容:</strong> {{ $curriculum->description }}</p>

    <!-- 動画表示 -->
    <div class="mb-4 d-flex justify-content-center">
        @if ($curriculum->video_url)
            <?php
                $videoUrl = $curriculum->video_url;
    
                // YouTube用の埋め込みURLに変換
                if (strpos($videoUrl, 'youtube.com/watch?v=') !== false) {
                    $videoId = explode('v=', $videoUrl)[1];
                    $videoUrl = "https://www.youtube.com/embed/" . $videoId;
                }
    
                // ニコニコ動画用の埋め込みURLに変換
                if (strpos($videoUrl, 'nicovideo.jp/watch/') !== false) {
                    $videoId = basename(parse_url($videoUrl, PHP_URL_PATH));
                    $videoUrl = "https://embed.nicovideo.jp/watch/" . $videoId;
                }
            ?>
    
            <div class="embed-responsive embed-responsive-16by9" style="width: 100%; max-width: 1000px;">
                <iframe 
                    class="embed-responsive-item" 
                    src="{{ $videoUrl }}" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen
                    style="width: 100%; height: 500px;">
                </iframe>
            </div>
        @else
            <p>動画は現在利用できません。</p>
        @endif
    </div>

    <!-- 「受講しました」ボタン -->
    @if ($isCompleted)
        <button class="btn btn-success" disabled>受講しました</button>
    @else
        <form method="POST" action="{{ route('user.curriculum.complete', $curriculum->id) }}">
            @csrf
            <button type="submit" class="btn btn-primary">受講しました</button>
        </form>
    @endif

    <!-- フラッシュメッセージ -->
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <!-- 戻るボタン -->
    <div class="mt-3">
        <a href="{{ route('user.show.progress') }}" class="btn btn-secondary">戻る</a>
    </div>
</div>
@endsection