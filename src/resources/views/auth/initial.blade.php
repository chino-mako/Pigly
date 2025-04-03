@extends('layouts.auth')

@section('title', '初期体重登録')
@section('heading', '新規会員登録')
@section('step', 'STEP2 体重データの入力')

@section('content')
    <!-- 体重データ登録フォーム -->
    <form method="POST" action="{{ route('register.step2') }}">
        @csrf

        <!-- 現在の体重入力 -->
        <div class="input-group">
            <label for="weight">現在の体重</label>
            <input 
                type="number" 
                step="0.1" 
                id="weight" 
                name="weight" 
                placeholder="現在の体重を入力" 
                value="{{ old('weight', Auth::user()->weightLogs()->latest()->value('weight') ?? '') }}"
            >
            @error('weight')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        <!-- 目標体重入力 -->
        <div class="input-group">
            <label for="target_weight">目標の体重</label>
            <input 
                type="number" 
                step="0.1" 
                id="target_weight" 
                name="target_weight" 
                placeholder="目標の体重を入力" 
                value="{{ old('target_weight') }}"
            >
            @error('target_weight')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        <!-- 送信ボタン -->
        <button type="submit">アカウント作成</button>
    </form>
@endsection
