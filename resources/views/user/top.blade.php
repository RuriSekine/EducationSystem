@extends('user.layouts.app')

@section('content')
<div class="container mt-5">
    <!-- 見出し -->
    <h1 class="text-center mb-4" style="color: #6a9eaf;">お知らせ一覧</h1>

    <!-- テーブル -->
    <table class="table table-striped table-bordered table-hover">
        <tbody>
            @foreach ($articles as $article)
                <tr>
                    <!-- 日付をYYYY年MM月DD日の形式にフォーマット -->
                    <td>{{ optional($article->created_at)->format('Y年m月d日') }}</td>
                    <!-- タイトル部分をリンクにする -->
                    <td>
                        <a href="{{ route('user.show.article', $article->id) }}" class="text-decoration-none text-primary">
                            {{ $article->title }}
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection