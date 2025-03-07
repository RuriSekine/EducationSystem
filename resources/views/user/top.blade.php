@extends('user.layouts.app')

@section('content')
<div class="container">
    <h1>お知らせ一覧</h1>
    <ul>
        @foreach ($articles as $article)
            <div class="card mb-3">
                <div class="card-body">
                    <a href="{{ route('user.show.article', $article->id) }}" class="text-decoration-none">
                        <h2 class="card-title">{{ $article->title }}</h2>
                    </a>
                    <p class="card-text">
                        <small class="text-muted">投稿日: {{ optional($article->created_at)->format('Y-m-d H:i') }}</small>
                    </p>
                    <p class="card-text">{{ Str::limit(optional($article->article_contents)->toString(), 100, '...') }}</p>
                </div>
            </div>
        @endforeach
    </ul>
</div>
@endsection