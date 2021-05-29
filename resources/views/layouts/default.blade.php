<!DOCTYPE html>
<html lang="ja">

<head>

    <title>Laravel dockerローカル</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="/css/myService/reset.css">


    <!-- loginのtoggle用 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    
    <!-- Scripts -->
    
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="@yield('css')">
    <!--なんか変更あったかも-->
</head>

<body>
    <div id="app">
        <header class="header">
            <div class="header-inner">

                <!-- <div class="header-logo">players</div> -->
                <a class="header-logo" href="{{ route('myhomes.index') }}">
                    <img src="https://banana2.s3-ap-northeast-1.amazonaws.com/test/logo.png" alt="">
                </a>
                <!-- ハンバーガー -->
                <div class="drawer-burger">
                    <span class="drawer-burger-line"></span>
                    <span class="drawer-burger-line"></span>
                    <span class="drawer-burger-line"></span>
                </div>
                <div class="header-nav">
                    <ul class="header-nav-list">
                        <li class="header-nav-item"><a href="{{ route('myhomes.index') }}">ホーム</a></li>
                        <li class="header-nav-item"><a href="{{ route('finds.index') }}">見つける</a></li>
                        <li class="header-nav-item"><a href="{{ route('activities.index') }}">アクティビティ</a></li>
                        <li class="header-nav-item"><a href="{{ route('talk_users.index') }}">トーク画面へ</a></li>
                    </ul>
                </div>
                <div class="header-overlay"></div>
                <!-- /ハンバーガー -->

                <!-- ログインのtoggle -->
                <log-out-toggle :user-name="{{ json_encode(Auth::user()->name) }}"></log-out-toggle>
                <!-- /ログインのtoggle -->

            </div>
        </header>
        <!-- /.header -->



        @yield('content')


    </div>
    <!-- /#app -->


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.2/moment.min.js"></script>

    <!-- loginのtoggle用 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="/js/banana.js"></script>



    <!-- <script src="{{ mix('js/app.js')}}"></script> -->

    
</body>

</html>