<!DOCTYPE html>
<html lang="ja">

<head>

    <title>Laravel</title>
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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- loginのtoggle用 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

    <link rel="stylesheet" href="@yield('css')">
    <!--なんか変更あったかも-->
</head>

<body>

    <header class="header">
        <div class="header-inner">

            <!-- <div class="header-logo">players</div> -->
            <a class="header-logo" href="{{ action('PeopleController@home') }}">
                <img src="/img/logo (1).png" alt="">
            </a>
            <!-- ハンバーガー -->
            <div class="drawer-burger">
                <span class="drawer-burger-line"></span>
                <span class="drawer-burger-line"></span>
                <span class="drawer-burger-line"></span>
            </div>
            <div class="header-nav">
                <ul class="header-nav-list">
                    <li class="header-nav-item"><a href="{{ action('PeopleController@home') }}" class="">ホーム</a></li>
                    <li class="header-nav-item"><a href="{{ action('PeopleController@find') }}" class="">見つける</a></li>
                    <li class="header-nav-item"><a href="{{ action('PeopleController@activity') }}" class="">アクティビティ</a></li>
                    <li class="header-nav-item"><a href="{{ action('PeopleController@talk') }}" class="">トーク画面へ</a></li>
                </ul>
            </div>
            <div class="header-overlay"></div>
            <!-- ハンバーガー -->

            <!-- ログインのtoggle -->
            <div class="toggle">

                <a class="toggle-button dropdown-toggle" href="#">
                    {{ Auth::user()->name }}
                </a>

                <div class="toggle-show dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="logout-button dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- ログインのtoggle -->

        </div>
    </header>
    <!-- /.header -->



    @yield('content')


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <script src="/js/banana.js"></script>
</body>

</html>