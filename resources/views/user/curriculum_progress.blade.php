@extends('user.layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('user.top.index') }}" class="btn btn-outline-primary mt-3">
        戻る
    </a>
    <!-- アイコン画像の表示 -->
    <div class="mb-3 text-center">
        @if ($user->profile_image)
            <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}" 
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

    <h1>{{ $user->name }} さんの授業進捗</h1>
    <p>現在の学年: {{ $currentGrade->name }}</p>

    <!-- 学年別授業進捗の表示 (3列 × 4行 最大12個) -->
    <div class="container">
        @php
            $displayedGrades = [];
            $maxGrades = 12; // 最大表示数
            $gradeChunks = $grades->take($maxGrades)->chunk(3); // 3列ごとに分割
        @endphp

        @foreach ($gradeChunks as $gradeRow) <!-- 1行に3列ずつ -->
            <div class="row g-3">
                @foreach ($gradeRow as $grade)
                    @if (!in_array($grade->name, $displayedGrades))
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm {{ $grade->id > $user->grade_id ? 'bg-secondary text-white' : 'bg-light' }}">
                                <div class="card-body">
                                    <h5 class="card-title text-center">{{ $grade->name }}</h5>

                                    <ul class="list-unstyled">
                                        @php
                                            $curriculumList = $groupedCurriculums[$grade->name] ?? collect();
                                        @endphp

                                        @forelse ($curriculumList as $curriculum)
                                            @php
                                                $isCompleted = $progresses[$curriculum->id] ?? false;
                                                $isDisabled = $grade->id > $user->grade_id; // 現在の学年以上は非活性
                                            @endphp

                                            <li>
                                                @if ($isDisabled)
                                                    <span class="text-muted">{{ $curriculum->title }}（受講不可）</span>
                                                @else
                                                    <a href="{{ route('user.show.curriculum', $curriculum->id) }}">
                                                        {{ $curriculum->title }}
                                                    </a>
                                                @endif

                                                @if ($isCompleted)
                                                    <span class="badge bg-success">受講済み</span>
                                                @endif
                                            </li>
                                        @empty
                                            <li>登録されている授業はありません。</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @php
                            $displayedGrades[] = $grade->name;
                        @endphp
                    @endif
                @endforeach
            </div>
        @endforeach
    </div>
</div>
@endsection