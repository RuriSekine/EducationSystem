@extends('user.layouts.app')

@push('styles')
<link rel = "stylesheet" href = "{{ asset('css/login-register.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

            <a class="register-link" href="{{ route('user.register') }}">{{ __('新規登録はこちら') }}</a>

                <div class="card-body">
                    <h1>ログイン</h1>
                    <form method="POST" action="{{ route('user.login') }}" class = "form-erea">
                        @csrf
                        <div class="row-mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('メールアドレス') }}</label>
                            <div class="col-md-6">
                                <input id="email"  class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback" role="alert">
                                        <div class = "errormessage">{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row-mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('パスワード') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">

                                @error('password')
                                    <div class="invalid-feedback" role="alert">
                                        <div class = "errormessage">{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row-mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn-primary">
                                    {{ __('ログイン') }}
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