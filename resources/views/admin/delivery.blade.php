@extends('admin.layouts.app')

@section('title', '配信日時設定')

@section('content')
    <link rel="stylesheet" href="{{ asset('admin/css/curriculum.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/delivery.css') }}">
    <script src="{{ asset('admin/js/delivery.js') }}"></script>

    {{-- 戻るボタン --}}
    <div class="button-section">
        <a href="{{ route('admin.curriculum.list') }}" class="back-link">← 戻る</a>
    </div>

    {{-- ページタイトル --}}
    <h2 class="page-title">配信日時設定</h2>

    {{-- 配信日時設定フォーム --}}
    <form action="{{ route('admin.delivery.update', ['id' => $curriculum->id]) }}" method="POST" class="form-section" novalidate>
        @csrf

        {{-- 授業タイトル --}}
        <p id="curriculum_title" class="curriculum-title">{{ $curriculum->title }}</p>

        <div id="delivery-list">
            @php
                $count = max(3, count($deliveryTimes) + 1); // 必ず3行以上表示、登録データ+1行
            @endphp

            @for ($i = 0; $i < $count; $i++)
                <div class="delivery-time-row">
                    <input type="text" name="delivery_from_date[]" 
                           value="{{ old('delivery_from_date.'.$i, isset($deliveryTimes[$i]) ? \Carbon\Carbon::parse($deliveryTimes[$i]->delivery_from)->format('Ymd') : '') }}" 
                           placeholder="YYYYMMDD" maxlength="8" required>
                    
                    <input type="text" name="delivery_from_time[]" 
                           value="{{ old('delivery_from_time.'.$i, isset($deliveryTimes[$i]) ? \Carbon\Carbon::parse($deliveryTimes[$i]->delivery_from)->format('Hi') : '') }}" 
                           placeholder="HHMM" maxlength="4" required>

                    <span>～</span>

                    <input type="text" name="delivery_to_date[]" 
                           value="{{ old('delivery_to_date.'.$i, isset($deliveryTimes[$i]) ? \Carbon\Carbon::parse($deliveryTimes[$i]->delivery_to)->format('Ymd') : '') }}" 
                           placeholder="YYYYMMDD" maxlength="8" required>
                    
                    <input type="text" name="delivery_to_time[]" 
                           value="{{ old('delivery_to_time.'.$i, isset($deliveryTimes[$i]) ? \Carbon\Carbon::parse($deliveryTimes[$i]->delivery_to)->format('Hi') : '') }}" 
                           placeholder="HHMM" maxlength="4" required>

                    <button type="button" class="btn-remove" onclick="removeRow(this)">－</button>
                </div>

                {{-- エラーメッセージ表示 --}}
                @error('delivery_from_date.' . $i)
                    <p class="error-message">{{ $message }}</p>
                @enderror
                @error('delivery_from_time.' . $i)
                    <p class="error-message">{{ $message }}</p>
                @enderror
                @error('delivery_to_date.' . $i)
                    <p class="error-message">{{ $message }}</p>
                @enderror
                @error('delivery_to_time.' . $i)
                    <p class="error-message">{{ $message }}</p>
                @enderror
            @endfor
        </div>

        {{-- 配信日時追加ボタン --}}
        <div class="add-button-section">
            <button type="button" id="add-row" class="btn-add">＋</button>
        </div>

        {{-- 登録ボタン --}}
        <div class="form-group">
            <button type="submit" class="btn-primary">登録</button>
        </div>

    </form>
@endsection
