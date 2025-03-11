@extends('admin.layouts.app')

@section('content')
    <h1>{{ $article->exists ? 'お知らせを編集' : '新規お知らせを作成' }}</h1>

    <form method="POST" action="{{ $article->exists ? route('admin.article.update', $article->id) : route('admin.article.store') }}">
        @csrf
        @if($article->exists)
            @method('PUT')
        @endif

        <div>
            <label for="title">タイトル</label>
            <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" required>
        </div>

        <div>
            <label for="content">内容</label>
            <textarea name="article_contents" id="article_contents" required>{{ old('article_contents', $article->content) }}</textarea>
        </div>

        <div>
            <label for="posted_date">投稿日時</label>
            <input type="datetime-local" name="posted_date" id="posted_date" 
                value="{{ old('posted_date', $article->posted_date ? \Carbon\Carbon::parse($article->posted_date)->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}">
        </div>

        <button type="submit">
            {{ $article->exists ? '更新する' : '作成する' }}
        </button>
        
        <a href="{{ route('admin.articles.index') }}" style="margin-left: 10px;">戻る</a>
    </form>
@endsection