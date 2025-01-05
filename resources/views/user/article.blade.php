@extends('user.layouts.app')
{{-- app.blade.phpを継承 --}}

@section('content')

<a href = "{{ route('user.show.top') }}">←戻る</a>
<h2>{{ $article->posted_date->format('Y年m月d日') }}</h2>
<h2>{{ $article->title }}</h2>

<div>{{ $article->article_contents }}</div>
@endsection