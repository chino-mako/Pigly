<!DOCTYPE html>
<html lang="ja">

<head>
    <!-- メタ情報 -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- タイトル -->
    <title>@yield('title', 'PiGLy')</title>
    
    <!-- スタイルシート -->
    <link rel="stylesheet" href="{{ asset('css/weight.css') }}">
</head>

<body>

    <!-- ヘッダー -->
    <header class="header">
        <div class="logo">
            <!-- ロゴリンク -->
            <a href="{{ route('weight.index') }}">PiGLy</a>
        </div>
        
        <div class="header-buttons">
            <!-- 目標体重設定リンク -->
            <a href="{{ route('weight.target') }}" class="btn btn-gray">目標体重設定</a>
            
            <!-- ログアウトフォーム -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-gray">ログアウト</button>
            </form>
        </div>
    </header>

    <!-- メインコンテンツ -->
    <main class="container">
        @yield('content')
    </main>

    <!-- フッター -->
    <footer class="footer">
        <!-- コピーライト -->
        <p>&copy; {{ date('Y') }} PiGLy. All rights reserved.</p>
    </footer>

</body>

</html>
