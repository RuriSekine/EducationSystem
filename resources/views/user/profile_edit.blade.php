@extends('user.layouts.app')

@section('content')
<div class="container py-5" style="background-color: #f8f9fa; border-radius: 10px;">
    <a href="{{ route('user.top.index') }}" class="btn btn-outline-primary mt-3">
        戻る
    </a>
    <h2 class="text-center text-primary">プロフィール編集</h2>

    <!-- 成功メッセージ -->
    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm p-4 mt-4">
        <form action="{{ route('user.update.profile') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- 現在のアイコン表示 -->
            <div class="mb-3 text-center">
                @if (auth()->user()->profile_image)
                    <img src="{{ asset('storage/profile_images/' . auth()->user()->profile_image) }}" 
                         alt="プロフィール画像" 
                         class="rounded-circle shadow" 
                         style="width: 150px; height: 150px; object-fit: cover;">
                @else
                    <img src="{{ asset('storage/profile_images/default.png') }}" 
                         alt="デフォルト画像" 
                         class="rounded-circle shadow" 
                         style="width: 150px; height: 150px; object-fit: cover;">
                @endif
            </div>

            <!-- アイコン変更ボタン -->
            <div class="mb-3 text-center">
                <label for="profile_image" class="btn btn-outline-secondary">画像を変更</label>
                <input id="profile_image" type="file" name="profile_image" class="d-none">
                
                @if ($errors->has('profile_image'))
                    <ul class="text-danger mt-1">
                        @foreach ($errors->get('profile_image') as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- ユーザーネーム -->
            <div class="mb-3">
                <label for="name" class="form-label fw-bold">ユーザーネーム</label>
                <input type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $user->name) }}" 
                       required>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- フリガナ -->
            <div class="mb-3">
                <label for="name_kana" class="form-label fw-bold">フリガナ</label>
                <input type="text" 
                       class="form-control @error('name_kana') is-invalid @enderror" 
                       id="name_kana" 
                       name="name_kana" 
                       value="{{ old('name_kana', $user->name_kana) }}" 
                       required>
                @error('name_kana')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- メールアドレス -->
            <div class="mb-3">
                <label for="email" class="form-label fw-bold">メールアドレス</label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', $user->email) }}" 
                       required>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- ボタンエリア -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('user.edit.password') }}" class="btn btn-outline-primary">パスワードを変更する</a>
                <button type="submit" class="btn btn-primary">更新</button>
            </div>
        </form>
    </div>
</div>
@endsection