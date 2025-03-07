@extends('user.layouts.app')
{{-- app.blade.phpを継承 --}}

@push('styles')
<link rel = "stylesheet" href = "{{ asset('css/delivery.css') }}">
@endpush

@section('content')
<a href = "{{ route('user.show.curriculum') }}">←戻る</a>

@if(session('success'))
<div class="alert-success">
{{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert-danger">
{{ session('error') }}
</div>
@endif

<div class = "video-content">
                <div class = "video-erea">
                @if($curriculum->alway_delivery_flg == 1 || $isWithinDeliveryPeriod)
                    <!-- 条件: 常時公開設定または、公開期間内ならば動画を表示。 -->
                    <iframe width="640" height="360"src="{{ $embedUrl }}" frameborder="0" allowfullscreen></iframe>
                    @if($isClearFlag) <!-- 修正: $isClearFlagに基づいてボタンの表示を切り替え -->
                    <button class = "attended-button" disabled>受講済み</button>
                    @else
                    <form action = "{{ route('user.complete.delivery' , ['id' => $curriculum->id]) }}" method = "POST">
                        @csrf
                    <button class = "clear-button" type = "submit">受講しました</button>
                    </form>
                @endif
                @else
                    <!-- 非公開設定の場合、配信期間に関わらず動画を非表示 -->
                    <div class="video-placeholder">
                        <p>
                        @if(!$isWithinDeliveryPeriod)<!-- 配信期間外の場合 -->
                            こちらの動画は配信期間外のため視聴できません。
                        @else                        <!-- 常時非公開設定の場合 -->
                            動画は管理者設定により視聴できません。
                        @endif
                        </p>
                        <button class="notcheck-button" disabled>受講できません</button>
                    </div>
                @endif
                </div>
            <div class = "grade">{{ $curriculum->grade->name }}</div>
        <h2>{{ $curriculum->title }}</h2>
    <div>{{ $curriculum->description }}</div>
</div>
</div>
@endsection