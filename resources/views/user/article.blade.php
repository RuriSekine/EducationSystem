@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>お知らせ詳細</h1>

    <div class="card">
        <div class="card-body">
            <h2 class="card-title">{{ $article->title }}</h2>
            <p class="card-text">{{ $article->article_contents }}</p>
            <p class="text-muted">投稿日: {{ \Carbon\Carbon::parse($article->posted_date)->format('Y-m-d H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('user.top.index') }}" class="btn btn-secondary mt-3">一覧に戻る</a>
</div>
@endsection