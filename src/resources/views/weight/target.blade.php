@extends('layouts.weight')

@section('content')
<div class="container">
    <div class="weight-setting-box">
        <h2>目標体重設定</h2>

        {{-- 目標体重更新フォーム --}}
        <form action="{{ route('weight.goalUpdate', $target->id ?? '') }}" method="POST">
        @csrf
        @method('PUT')

            {{-- 目標体重入力フィールド --}}
            <input type="text" name="target_weight" value="{{ old('target_weight', $target->target_weight ?? '') }}">
            <span>kg</span>

            {{-- バリデーションエラー表示 --}}
            @error('target_weight')
                <p class="error">{{ $message }}</p>
            @enderror

            {{-- ボタングループ --}}
            <div class="button-group">
                {{-- 戻るボタン --}}
                <a href="{{ route('weight.index') }}" class="btn btn-gray">戻る</a>
                {{-- 更新ボタン --}}
                <button type="submit" class="btn btn-gradient">更新</button>
            </div>
        </form>
    </div>
</div>
@endsection
