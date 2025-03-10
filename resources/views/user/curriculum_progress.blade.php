@extends('user.layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('user.top.index') }}" class="btn btn-outline-primary mt-3">
        戻る
    </a>
    
    <!-- アイコン画像の表示 -->
    <div class="mb-3 text-center">
        <img src="{{ asset('storage/profile_images/' . ($user->profile_image ?: 'default.png')) }}" 
             alt="プロフィール画像" 
             class="rounded-circle shadow" 
             style="width: 150px; height: 150px; object-fit: cover;">
    </div>

    <h1>{{ $user->name }} さんの授業進捗</h1>
    <p>現在の学年: {{ $currentGrade->name }}</p>

    <!-- 学年別授業進捗の表示 (3列 × 4行 最大12個) -->
    <div class="container">
        @foreach ($gradeChunks as $gradeRow) <!-- 1行に3列ずつ -->
            <div class="row g-3">
                @foreach ($gradeRow as $grade)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm {{ $grade->id > $user->grade_id ? 'bg-secondary text-white' : 'bg-light' }}">
                            <div class="card-body">
                                <h5 class="card-title text-center">{{ $grade->name }}</h5>

                                <ul class="list-unstyled">
                                    @foreach ($curriculumsWithProgress as $item)
                                        @if ($item['curriculum']->grade->name == $grade->name)
                                            <li>
                                                @if ($item['isDisabled'])
                                                    <span class="text-muted">{{ $item['curriculum']->title }}（受講不可）</span>
                                                @else
                                                    <a href="{{ route('user.show.curriculum', $item['curriculum']->id) }}">
                                                        {{ $item['curriculum']->title }}
                                                    </a>
                                                @endif

                                                @if ($item['isCompleted'])
                                                    <span class="badge bg-success">受講済み</span>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach

                                    @if($curriculumsWithProgress->where('curriculum.grade.name', $grade->name)->isEmpty())
                                        <li>登録されている授業はありません。</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
@endsection