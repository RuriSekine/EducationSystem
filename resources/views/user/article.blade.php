@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">お知らせ詳細</h1>

    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body">
            <!-- 投稿日 -->
            <p class="text-muted mb-3">
                投稿日: {{ \Carbon\Carbon::parse($article->posted_date)->format('Y年m月d日') }}
            </p>
            <!-- お知らせタイトル -->
            <h2 class="card-title mb-3">{{ $article->title }}</h2>

            <!-- お知らせ本文 -->
            <p class="card-text mb-4">{{ $article->article_contents }}</p>

            <!-- 一覧に戻るボタン -->
            <a href="{{ route('user.top.index') }}" class="btn btn-outline-primary mt-3">
                一覧に戻る
            </a>
        </div>
    </div>
</div>
@endsection