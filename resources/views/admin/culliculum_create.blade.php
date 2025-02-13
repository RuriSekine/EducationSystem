@extends('admin.layouts.app')

@section('title', '授業新規登録')

@section('content')
    <link rel="stylesheet" href="{{ asset('admin/css/curriculum.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/curriculum_create.css') }}">
    <script src="{{ asset('admin/js/curriculum_create.js') }}"></script>

    <!-- 戻るボタン -->
    <div class="button-section">
        <a href="{{ route('admin.curriculum.list') }}" class="back-link">← 戻る</a>
    </div>

    <h2 class="page-title">授業設定</h2>

    <!-- 授業新規登録フォーム -->
    <form action="{{ route('admin.curriculum.Regist') }}" method="POST" enctype="multipart/form-data" class="form-section" novalidate>
        @csrf

        <!-- サムネイル画像 -->
        <div class="form-group">
            <div class="input-wrapper">
                <!-- プレビューエリア -->
                <div id="thumbnail-preview"></div>
            </div>
            <label for="thumbnail">サムネイル</label>
            <div class="input-wrapper">
                <input type="file" name="thumbnail" id="thumbnail" accept="image/*">
                @error('thumbnail')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- 学年選択 -->
        <div class="form-group">
            <label for="grade">学年</label>
            <div class="input-wrapper">
                <select name="grade_id" id="grade_id" required>
                    @foreach ($grades as $grade)
                        <option value="{{ $grade->id }}" {{ $grade->id == 1 ? 'selected' : '' }}>
                            {{ $grade->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- 授業名 -->
        <div class="form-group">
            <label for="title">授業名</label>
            <div class="input-wrapper">
                <input type="text" name="title" id="title" placeholder="授業名を入力してください" required>
                @error('title')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- 動画URL -->
        <div class="form-group">
            <label for="video_url">動画URL</label>
            <div class="input-wrapper">
                <input type="url" name="video_url" id="video_url" placeholder="動画のURLを入力してください" required>
                @error('video_url')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- 授業概要 -->
        <div class="form-group">
            <label for="description">授業概要</label>
            <div class="input-wrapper">
                <textarea name="description" id="description" placeholder="授業の概要を入力してください" required></textarea>
                @error('description')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- 常時公開チェックボックス -->
        <div class="form-group checkbox-group">
            <label for="always_delivery">
                <input type="checkbox" name="always_delivery" id="always_delivery" value="1">
                常時公開
            </label>
        </div>

        <!-- 登録ボタン -->
        <div class="form-group">
            <button type="submit" class="btn btn-primary">登録</button>
        </div>
    </form>
@endsection
