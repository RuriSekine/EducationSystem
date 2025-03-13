@extends('admin.layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('admin.articles.index') }}" style="margin-left: 10px;">戻る</a>
    <h1>授業動画の追加</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.curriculum.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="title">タイトル</label>
            <input type="text" name="title" id="title" required>
        </div>
    
        <div>
            <label for="description">説明</label>
            <textarea name="description" id="description"></textarea>
        </div>
    
        <div>
            <label for="video_url">動画URL (YouTubeやニコニコ動画のURL)</label>
            <input type="url" name="video_url" id="video_url" placeholder="https://example.com/video" required>
        </div>
    
        <div>
            <label for="thumbnail">サムネイル画像 (jpeg, png, jpg, gif)</label>
            <input type="file" name="thumbnail" id="thumbnail" accept=".jpeg,.png,.jpg,.gif" required>
        </div>
    
        <div>
            <label for="grade_id">学年</label>
            <select name="grade_id" id="grade_id" required>
                @foreach($grades as $grade)
                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit">授業を登録</button>
    </form>    
</div>
@endsection