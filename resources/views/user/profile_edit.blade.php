@extends('user.layouts.app')

@section('content')
<div class="container d-flex justify-content-center py-5" style="background-color: #E6F7FF; border-radius: 15px;">
    <div class="card shadow-lg p-4" style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 15px;">
        <a href="{{ route('user.top.index') }}" class="btn btn-outline-primary rounded-pill px-4 mb-3">
            ← 戻る
        </a>
        <h2 class="text-center" style="color: #4F92D1; font-weight: bold;">プロフィール編集</h2>

        <!-- 成功メッセージ -->
        @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="card-body">
            <form action="{{ route('user.update.profile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- プロフィール画像 -->
                <div class="mb-4 text-center">
                    <div class="position-relative d-inline-block">
                        <img src="{{ auth()->user()->profile_image 
                            ? asset('storage/profile_images/' . auth()->user()->profile_image) 
                            : asset('storage/profile_images/default.png') }}" 
                            alt="プロフィール画像" 
                            class="rounded-circle border border-info shadow" 
                            style="width: 150px; height: 150px; object-fit: cover;">

                        <label for="profile_image" class="btn btn-outline-primary mt-2 d-block rounded-pill">
                            画像を変更
                        </label>
                        <input id="profile_image" type="file" name="profile_image" class="d-none">
                    </div>

                    @error('profile_image')
                        <div class="alert alert-danger p-2 mt-2 rounded">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>

                <!-- ユーザーネーム -->
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold" style="color: #4F92D1;">ユーザーネーム</label>
                    <input type="text" 
                        class="form-control form-control-lg rounded-pill shadow-sm border-0" 
                        style="background-color: #F1F1F1; color: #333;"
                        id="name" 
                        name="name" 
                        value="{{ old('name', $user->name) }}" 
                        required>
                    @error('name')
                        <div class="alert alert-danger p-2 mt-2 rounded">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>

                <!-- フリガナ -->
                <div class="mb-3">
                    <label for="name_kana" class="form-label fw-bold" style="color: #4F92D1;">フリガナ</label>
                    <input type="text" 
                        class="form-control form-control-lg rounded-pill shadow-sm border-0" 
                        style="background-color: #F1F1F1; color: #333;"
                        id="name_kana" 
                        name="name_kana" 
                        value="{{ old('name_kana', $user->name_kana) }}" 
                        required>
                    @error('name_kana')
                        <div class="alert alert-danger p-2 mt-2 rounded">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>

                <!-- メールアドレス -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold" style="color: #4F92D1;">メールアドレス</label>
                    <input type="email" 
                        class="form-control form-control-lg rounded-pill shadow-sm border-0" 
                        style="background-color: #F1F1F1; color: #333;"
                        id="email" 
                        name="email" 
                        value="{{ old('email', $user->email) }}" 
                        required>
                    @error('email')
                        <div class="alert alert-danger p-2 mt-2 rounded">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>

                <!-- ボタンエリア -->
                <div class="d-flex justify-content-center mt-4">
                    <a href="{{ route('user.edit.password') }}" class="btn btn-outline-primary btn-lg rounded-pill px-4">パスワード変更</a>
                </div>

                <!-- 更新ボタン -->
                <div class="d-flex justify-content-center mt-2">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4">更新</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection