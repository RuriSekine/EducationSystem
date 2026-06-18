@extends('admin.layouts.app')

@section('title', '授業一覧ページ')

@yield('additional-styles')
    <link rel="stylesheet" href="{{ asset('/css/user_curriculum_list.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

@section('left-item')
    <li class="nav-item">
        <a class="nav-link left-link" href="{{ route('user.show.curriculum') }}">{{ __('時間管理') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link left-link" href="{{ route('user.show.progress') }}">{{ __('授業進捗') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link left-link" href="{{ route('user.show.profile') }}">{{ __('プロフィール設定') }}</a>
    </li>
@endsection

@section('right-item')
    @auth
        <li class="nav-item">
            <form action="{{ route('user.logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link right-link">
                    {{ __('ログアウト') }}
                </button>
            </form>
        </li>
    @endauth
@endsection

@section('content')
    <a href="{{ route('user.show.top') }}" class="back-link">←戻る</a>

    <!--年月-->
    <div class="schedule-header">
        <button id="lastMonth">◀</button>
        <span id="currentMonth"></span>
        <button id="nextMonth">▶</button>
    </div>

    <!--対象学年-->
    <div class="grade">
        <span id="grade" data-grade-name="{{ Auth::guard('user')->user()->grade->name }}">
            {{ Auth::guard('user')->user()->grade->name }}
        </span>
    </div>

    <div class="curriculum-container">
            <!--学年一覧-->
            <div class="grade-menu">
            <!--小学生-->
            <div class="grade-group">
                <ul class="grade-list">
                    @foreach ($grades as $grade)
                        @if (str_contains($grade->name, '小学'))
                            <li class="grade-item">
                                <button type="button" class="grade-btn btn btn-primary" data-grade-id="{{ $grade->id }}">{{ $grade->name }}
                                </button>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <!--中学生-->
            <div class="grade-group">
                <ul class="grade-list">
                    @foreach ($grades as $grade)
                        @if (str_contains($grade->name, '中学'))
                            <li class="grade-item">
                                <button type="button" class="grade-btn btn btn-info" data-grade-id="{{ $grade->id }}">{{ $grade->name }}
                                </button>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <!--高校生-->
            <div class="grade-group">
                <ul class="grade-list">
                    @foreach ($grades as $grade)
                        @if (str_contains($grade->name, '高校'))
                            <li class="grade-item">
                                <button type="button" class="grade-btn btn btn-success" data-grade-id="{{ $grade->id }}">{{ $grade->name }}
                                </button>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>

        <!--授業一覧ページ-->
        <div class="curriculums-menu">
            @foreach ($curriculums as $curriculum)
                    <div class="curriculum-item" data-grade-id="{{ $curriculum->grade_id}}">
                        <img src="{{ asset($curriculum->thumbnail) }}" class="curriculum-thumbnail" alt="サムネイル画像" style="width: 180px">
                        <p class="curriculum-title">
                        {{ $curriculum->title}}
                        </p>
                        @if ($curriculum->alway_delivery_flg == 1)
                            <p class="curriculum-always-delivery">常時公開</p>
                        @else
                            @foreach ($curriculum->deliveryTimes as $delivery_time)
                                <p class="curriculum-delivery-time">
                                    {{ \Carbon\Carbon::parse($delivery_time->delivery_from)->format('n月j日 H:i') }}
                                    ～
                                    {{ \Carbon\Carbon::parse($delivery_time->delivery_to)->format('H:i') }}
                                </p>
                            @endforeach
                        @endif
                    </div>
            @endforeach
        </div>
    </div>
@endsection
@section('additional-scripts')
    <script src="{{ asset('js/schedule.js') }}"></script>
    <script src="{{ asset('js/grade.js') }}"></script>
@endsection
