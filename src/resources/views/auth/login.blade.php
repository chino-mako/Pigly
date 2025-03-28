@extends('layouts.auth')

@section('title', 'ログイン')
@section('heading', 'ログイン')
@section('step', 'アカウントをお持ちの方はログインしてください')

@section('content')
    <!-- ログインフォーム -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- メールアドレス入力 -->
        <div class="input-group">
            <label for="email">メールアドレス</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                placeholder="メールアドレスを入力" 
                value="{{ old('email') }}" 
                required
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
                id="password" 
                name="password" 
                placeholder="パスワードを入力" 
                required
            >
            @error('password') 
                <p class="error-text">{{ $message }}</p> 
            @enderror
        </div>

        <!-- ログインボタン -->
        <div class="button-group">
            <button type="submit" class="next-button">ログイン</button>
        </div>

        <!-- アカウント作成リンク -->
        <p class="login-link">
            <a href="{{ route('register') }}">アカウント作成はこちら</a>
        </p>
    </form>
@endsection
