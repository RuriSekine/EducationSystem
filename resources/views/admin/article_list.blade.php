@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>お知らせ一覧</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- 新規追加ボタン -->
    <a href="{{ route('admin.article.edit', ['id' => null]) }}" class="btn btn-primary mb-3">新規お知らせ追加</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>タイトル</th>
                <th>投稿日</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $article)
                <tr>
                    <td>
                        @if($article->posted_date)
                            {{ \Carbon\Carbon::parse($article->posted_date)->format('Y-m-d H:i') }}
                        @else
                            未設定
                        @endif
                    </td>
                    <td>{{ $article->title }}</td>
                    <td>
                        <a href="{{ route('admin.article.edit', ['id' => $article->id]) }}" class="btn btn-warning btn-sm">編集</a>
                        <form action="{{ route('admin.article.destroy', $article->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('本当に削除しますか？')">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $articles->links() }}
</div>
@endsection