@extends('admin.layouts.app')

@section('title', '授業編集')

@section('content')
    {{-- 必要なCSSとJS --}}
    <link rel="stylesheet" href="{{ asset('admin/css/curriculum.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/curriculum_edit.css') }}">
    <script src="{{ asset('admin/js/curriculum_edit.js') }}"></script>

    {{-- 戻るボタン --}}
    <div class="button-section">
        <a href="{{ route('admin.curriculum.list') }}" class="back-link">← 戻る</a>
    </div>

    {{-- ページタイトル --}}
    <h2 class="page-title">授業編集</h2>

    {{-- 編集フォーム --}}
    <form action="{{ route('admin.curriculum.update', ['id' => $curriculum->id]) }}" method="POST" enctype="multipart/form-data" class="form-section" novalidate>
        @csrf
        @method('PUT')

        {{-- サムネイル --}}
        <div class="form-group">
            <div class="input-wrapper">
                {{-- 画像プレビュー --}}
                <div id="thumbnail-preview">
                    @if($curriculum->thumbnail)
                        <img src="{{ asset('storage/' . $curriculum->thumbnail) }}" alt="現在のサムネイル">
                    @endif
                </div>
            </div>
            <label for="thumbnail">サムネイル</label>
            <div class="input-wrapper">
                <input type="file" name="thumbnail" id="thumbnail" accept="image/*">
                @error('thumbnail')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- 学年選択 --}}
        <div class="form-group">
            <label for="grade">学年</label>
            <div class="input-wrapper">
                <select name="grade_id" id="grade_id" required>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}" {{ $curriculum->grade_id == $grade->id ? 'selected' : '' }}>
                            {{ $grade->name }}
                        </option>
                    @endforeach
                </select>
                @error('grade_id')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- 授業名 --}}
        <div class="form-group">
            <label for="title">授業名</label>
            <div class="input-wrapper">
                <input type="text" name="title" id="title" value="{{ old('title', $curriculum->title) }}" required>
                @error('title')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- 動画URL --}}
        <div class="form-group">
            <label for="video_url">動画URL</label>
            <div class="input-wrapper">
                <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $curriculum->video_url) }}" required>
                @error('video_url')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- 授業概要 --}}
        <div class="form-group">
            <label for="description">授業概要</label>
            <div class="input-wrapper">
                <textarea name="description" id="description" required>{{ old('description', $curriculum->description) }}</textarea>
                @error('description')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- 常時公開チェックボックス --}}
        <div class="form-group checkbox-group">
            <label for="always_delivery">
                <input type="checkbox" name="always_delivery" id="always_delivery" value="1" {{ old('always_delivery', $curriculum->always_delivery) ? 'checked' : '' }}>
                常時公開
            </label>
            @error('always_delivery')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- 更新ボタン --}}
        <div class="form-group">
            <button type="submit" class="btn btn-primary">更新</button>
        </div>
    </form>
@endsection
