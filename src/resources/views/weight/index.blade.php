@extends('layouts.weight')

@section('content')
<div class="container">

    {{-- 目標体重と最新体重の表示 --}}
    <div class="weight-summary">
        <div>
            <p>目標体重</p>
            <h2>{{ is_numeric($targetWeight) ? number_format($targetWeight, 1) : '---' }} kg</h2>
        </div>
        <div>
            <p>目標まで</p>
            <h2>{{ is_numeric($latestWeight) && is_numeric($targetWeight) ? number_format($latestWeight - $targetWeight, 1) : '---' }} kg</h2>
        </div>
        <div>
            <p>最新体重</p>
            <h2>{{ is_numeric($latestWeight) ? number_format($latestWeight, 1) : '---' }} kg</h2>
        </div>
    </div>

    {{-- 検索機能 --}}
    <div class="search-container">
        <form action="{{ route('weight.search') }}" method="GET">
            <input type="date" name="start_date" value="{{ request('start_date') }}">
            <span>〜</span>
            <input type="date" name="end_date" value="{{ request('end_date') }}">
            <button type="submit" class="btn btn-dark-gray">検索</button>

            {{-- 検索結果リセットボタン --}}
            @if(request()->has('start_date') || request()->has('end_date'))
                <a href="{{ route('weight.index') }}" class="btn btn-gray">リセット</a>
            @endif
        </form>

        {{-- 検索結果の表示 --}}
        @if(isset($searchCount))
            <p class="search-result">
                「{{ request('start_date') }} 〜 {{ request('end_date') }}」の検索結果：{{ $searchCount }}件
            </p>
        @endif
    </div>

    {{-- データ追加ボタン --}}
    <a href="#modal" class="add-data-button">データ追加</a>

    {{-- 体重記録の一覧表示 --}}
    <table class="weight-table">
        <thead>
            <tr>
                <th>日付</th>
                <th>体重</th>
                <th>食事摂取カロリー</th>
                <th>運動時間</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($weightLogs as $weightLog)
            <tr>
                <td>{{ $weightLog->date }}</td>
                <td>{{ number_format($weightLog->weight ?? 0, 1) }} kg</td>
                <td>{{ number_format($weightLog->calories) }} cal</td>
                <td>{{ floor($weightLog->exercise_time_in_seconds / 60) }}時間{{ sprintf('%02d', $weightLog->exercise_time_in_seconds % 60) }}分</td>
                <td>
                    <a href="{{ route('weight.edit', ['weightLogId' => $weightLog->id]) }}">
                        <i class="fas fa-pencil-alt edit-icon"></i>✏️
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- ページネーション --}}
    <div class="pagination">
        {{ $weightLogs->links() }}
    </div>

</div>

{{-- モーダル（登録機能） --}}
<div id="modal" class="modal">
    <div class="modal-content">
        <a href="#" class="close">&times;</a>
        <h2>Weight Logを追加</h2>
        
        <form action="{{ route('weight.store') }}" method="POST">
            @csrf

            {{-- 日付入力 --}}
            <label>日付</label>
            <input type="date" name="date" value="{{ old('date', now()->toDateString()) }}">
            @error('date') <p class="error">{{ $message }}</p> @enderror

            {{-- 体重入力 --}}
            <label>体重（kg）</label>
            <input type="text" name="weight" value="{{ old('weight') }}">
            @error('weight') <p class="error">{{ $message }}</p> @enderror

            {{-- 摂取カロリー入力 --}}
            <label>摂取カロリー（cal）</label>
            <input type="text" name="calories" value="{{ old('calories') }}">
            @error('calories') <p class="error">{{ $message }}</p> @enderror

            {{-- 運動時間入力 --}}
            <label>運動時間（分）</label>
            <input type="text" name="exercise_time" placeholder="HH:MM" value="{{ old('exercise_time', '00:00') }}">
            @error('exercise_time') <p class="error">{{ $message }}</p> @enderror

            {{-- 運動内容入力 --}}
            <label>運動内容</label>
            <textarea name="exercise_details">{{ old('exercise_details') }}</textarea>
            @error('exercise_details') <p class="error">{{ $message }}</p> @enderror

            {{-- 登録ボタン --}}
            <button type="submit">登録</button>
            <a href="{{ route('weight.index') }}" class="close-modal">戻る</a>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        @if ($errors->any())
            window.location.hash = "modal";
        @endif
    });
</script>

@endsection
