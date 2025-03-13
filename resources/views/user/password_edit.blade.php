@extends('user.layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('user.edit.profile') }}" class="btn btn-outline-primary mt-3">
        戻る
    </a>
    <h2>パスワード変更</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.edit.password') }}" method="POST">
        @csrf
        @method('PUT')
        <!-- 現在のパスワード -->
        <div class="mb-3">
            <label for="current_password" class="form-label">現在のパスワード</label>
            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
            @error('current_password')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <!-- 新しいパスワード -->
        <div class="mb-3">
            <label for="new_password" class="form-label">新しいパスワード</label>
            <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" required>
            @error('new_password')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <!-- パスワード確認 -->
        <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">新しいパスワード（確認）</label>
            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary">変更する</button>
    </form>
</div>
@endsection