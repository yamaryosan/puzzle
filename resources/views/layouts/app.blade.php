<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Your App Name</title>
</head>
<body>
    <div class="container">
        <div class="main">
            <!-- ここに各ページの内容が入る -->
            @yield('content')
        </div>
        <!-- サイドバーの共通部分をここに含める -->
        <div class="sidebar">
            @include('partials.sidebar.sidebar')  <!-- サイドバーの共通部分をここに含めます -->
        </div>
    </div>
</body>
</html>
