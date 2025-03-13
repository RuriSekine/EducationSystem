@extends('admin.layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <a class="login-link" href="{{ route('admin.login') }}">{{ __('ログインはこちら') }}</a>
                <div class="card-body">
                    <h1>新規登録</h1>
                    <form method="POST" action="{{ route('admin.register') }}" class="form-area">
                        @csrf
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('ユーザーネーム') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback" role="alert">
                                        <div class="error-message">{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="kana" class="col-md-4 col-form-label text-md-end">{{ __('カナ') }}</label>
                            <div class="col-md-6">
                                <input id="kana" type="text" class="form-control @error('kana') is-invalid @enderror" name="kana" value="{{ old('kana') }}">
                                @error('kana')
                                    <div class="invalid-feedback" role="alert">
                                        <div class="error-message">{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('メールアドレス') }}</label>
                            <div class="col-md-6">
                                <input id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback" role="alert">
                                        <div class="error-message">{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('パスワード') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                @error('password')
                                    <div class="invalid-feedback" role="alert">
                                        <div class="error-message">{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('パスワード確認用') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('新規登録') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection