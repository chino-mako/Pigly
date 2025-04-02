@extends('layouts.weight')

@section('title', 'Weight Log Edit')

@section('content')
    <div class="container">
        <h2>Weight Log</h2>
        
        <!-- 更新フォームの開始 -->
        <form action="{{ route('weight.update', ['weightLogId' => $weightLog->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- 日付 -->
            <div class="form-group">
                <label for="date">日付</label>
                <input type="date" id="date" name="date" value="{{ old('date', $weightLog->date) }}">
                @error('date')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <!-- 体重 -->
            <div class="form-group">
                <label for="weight">体重</label>
                <input type="text" id="weight" name="weight" value="{{ old('weight', $weightLog->weight) }}"> kg
                @error('weight')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <!-- 摂取カロリー -->
            <div class="form-group">
                <label for="calories">摂取カロリー</label>
                <input type="text" id="calories" name="calories" value="{{ old('calories', $weightLog->calories) }}"> cal
                @error('calories')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <!-- 運動時間 -->
            <div class="form-group">
                <label for="exercise_time">運動時間</label>
                <input type="time" id="exercise_time" name="exercise_time"
                value="{{ old('exercise_time', $weightLog->exercise_time ? substr($weightLog->exercise_time, 0, 5) : '00:00') }}">
                @error('exercise_time')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <!-- 運動内容 -->
            <div class="form-group">
                <label for="exercise_content">運動内容</label>
                <textarea id="exercise_content" name="exercise_content" rows="3">{{ old('exercise_content', $weightLog->exercise_content) }}</textarea>
                @error('exercise_content')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <!-- ボタン群 -->
            <div class="button-group">
                <a href="{{ route('weight.index') }}" class="btn back">戻る</a>
                <button type="submit" class="btn btn-gradient">更新</button>
            </div>

        </form>
        
        <!-- 削除ボタン -->
        <form action="{{ route('weight.delete', ['weightLogId' => $weightLog->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn delete">🗑️</button>
        </form>
    </div>
@endsection
