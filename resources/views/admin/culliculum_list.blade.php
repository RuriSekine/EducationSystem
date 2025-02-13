@extends('admin.layouts.app')

@section('title', '授業一覧')

@section('content')
<link rel="stylesheet" href="{{ asset('admin/css/curriculum.css') }}">
<link rel="stylesheet" href="{{ asset('admin/css/curriculum_list.css') }}">
<script src="{{ asset('admin/js/curriculum_list.js') }}"></script>

{{-- 戻るボタン --}}
<div class="button-section">
    <a href="" class="back-link">← 戻る</a>
</div>

{{-- ページタイトル --}}
<h2 class="page-title">授業一覧</h2>

{{-- 新規登録ボタン & 学年選択エリア --}}
<div class="selected-grades-section">
    <a href="{{ route('admin.curriculum.create') }}" class="btn btn-primary">新規登録</a>
    <span id="selected-grade-placeholder"></span>
</div>

{{-- 授業一覧レイアウト --}}
<div class="list-container">
    {{-- 左パネル: 学年ボタン --}}
    <div class="left-panel">
        <div id="available-grades" class="grade-buttons-section">
            @foreach ($grades as $grade)
                <button class="filter-btn" data-grade="{{ $grade->name }}">{{ $grade->name }}</button>
            @endforeach
        </div>
    </div>

    {{-- 右パネル: 授業リスト --}}
    <div class="right-panel">
        <div id="list-section" class="list-section">
            @foreach ($grades as $grade)
                <div class="grade-section" data-grade="{{ $grade->name }}">
                    <h3>{{ $grade->name }}</h3>
                    @if ($curriculums->where('grade.name', $grade->name)->isNotEmpty())
                        <div class="curriculum-grid">
                            @foreach ($curriculums->where('grade.name', $grade->name) as $curriculum)
                                <div class="list-item">
                                    
                                    {{-- 授業サムネイル --}}
                                    @if ($curriculum->thumbnail)
                                        <img src="{{ asset('storage/' . $curriculum->thumbnail) }}" alt="{{ $curriculum->title }}" class="thumbnail">
                                    @else
                                        <div class="no-image">No Image</div>
                                    @endif

                                    {{-- 授業タイトル --}}
                                    <div class="title">{{ $curriculum->title }}</div>
                                    
                                    {{-- 配信日時表示 --}}
                                    <div class="schedule">
                                        @if ($curriculum->alway_delivery_flg)
                                            <span class="badge badge-success">常時公開</span>
                                        @else
                                            @if ($curriculum->deliveryTimes->isNotEmpty())
                                                @foreach ($curriculum->deliveryTimes->sortBy('delivery_from') as $deliveryTime)
                                                    @php
                                                        $from = \Carbon\Carbon::parse($deliveryTime->delivery_from);
                                                        $to = \Carbon\Carbon::parse($deliveryTime->delivery_to);
                                                    @endphp
                                                    <p class="delivery-time">
                                                        {{ $from->format('n月j日 H:i') }} ～ {{ $to->format('n月j日 H:i') }}
                                                    </p>
                                                @endforeach
                                            @else
                                                <span class="text-muted">未設定</span>
                                            @endif
                                        @endif
                                    </div>
                                    
                                    {{-- 編集ボタン --}}
                                    <div class="actions">
                                        <a href="{{ route('admin.curriculum.edit', ['id' => $curriculum->id]) }}" class="btn btn-edit">授業内容編集</a>
                                        <a href="{{ route('admin.delivery.edit', ['id' => $curriculum->id]) }}" class="btn btn-delivery {{ $curriculum->alway_delivery_flg ? 'disabled' : '' }}">配信日時編集</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>この学年には授業がありません。</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
