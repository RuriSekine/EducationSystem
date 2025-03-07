@extends('user.layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card position-relative">

                <!-- 右上に配置するボタン -->
                <div class="top-right-buttons">
                    <button type="button" class="btn btn-secondary"
                        onclick="window.location.href='{{ route('user.register') }}'">
                        {{ __('新規登録') }}
                    </button>
                    <button type="button" class="btn btn-outline-dark"
                        onclick="window.location.href='{{ route('admin.login') }}'">
                        {{ __('管理者画面') }}
                    </button>
                </div>

                <div class="card-body">
                    <h1>ログイン</h1>
                    
                    <form method="POST" action="{{ route('user.login') }}" class="form-erea">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('メールアドレス') }}</label>
                            <input id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback" role="alert">
                                    <div class="errormessage">{{ $message }}</div>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('パスワード') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                            @error('password')
                                <div class="invalid-feedback" role="alert">
                                    <div class="errormessage">{{ $message }}</div>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">
                                {{ __('ログイン') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection