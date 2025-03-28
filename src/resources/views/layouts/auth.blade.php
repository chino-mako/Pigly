<!DOCTYPE html>
<html lang="ja">

<head>
    <!-- メタ情報 -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- タイトル -->
    <title>@yield('title', 'PiGLy')</title>
    
    <!-- スタイルシート -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
    <div class="container">
        <div class="card">
            <!-- ロゴ -->
            <h1 class="logo">PiGLy</h1>
            
            <!-- 見出し -->
            <h2>@yield('heading')</h2>
            
            <!-- ステップ -->
            <p class="step">@yield('step')</p>
            
            <!-- コンテンツ -->
            @yield('content')
        </div>
    </div>
</body>

</html>
