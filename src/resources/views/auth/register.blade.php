@extends('layouts.auth')

@section('title', '新規会員登録')
@section('heading', '新規会員登録')
@section('step', 'STEP1 アカウント情報の登録')

@section('content')
    <!-- 新規会員登録フォーム -->
    <form method="POST" action="{{ route('register.step1') }}">
        @csrf

        <!-- お名前入力 -->
        <div class="input-group">
            <label for="name">お名前</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                value="{{ old('name') }}" 
                placeholder="名前を入力"
            >
            @error('name') 
                <p class="error-text">{{ $message }}</p> 
            @enderror
        </div>

        <!-- メールアドレス入力 -->
        <div class="input-group">
            <label for="email">メールアドレス</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                value="{{ old('email') }}" 
                placeholder="メールアドレスを入力"
            >
            @error('email') 
                <p class="error-text">{{ $message }}</p> 
            @enderror
        </div>

        <!-- パスワード入力 -->
        <div class="input-group">
            <label for="password">パスワード</label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                placeholder="パスワードを入力"
            >
            @error('password') 
                <p class="error-text">{{ $message }}</p> 
            @enderror
        </div>

        <!-- 次に進むボタン -->
        <div class="button-group">
            <button type="submit" class="next-button">次に進む</button>
        </div>

        <!-- ログインリンク -->
        <p class="login-link">
            <a href="{{ route('login') }}">ログインはこちら</a>
        </p>
    </form>
@endsection
