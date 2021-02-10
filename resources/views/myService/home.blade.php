@extends('layouts.default')


@section('css', '/css/myService/home.css')

@section('content')

<main>

    <section class="profile">
        <div class="profile-inner" id="app2">
            <example-component></example-component>
            <div class="profile-top">
                <p class="profile-top-tit">{{ $myAccount->name }}</p>
            </div>
            <div class="profile-img">
                @if ($myAccount->image == 1)
                <img src="/storage/profile_images/{{ $myId }}.jpg" alt="">
                @else
                <img src="/storage/profile_images/no-image.png" alt="">
        
                @endif
            </div>
            <div class="profile-button">
                <div class="profile-button-follower">
                    <a class="" href="{{ action('PeopleController@friend_follower') }}">フォローワー</a>
                </div>
                <div class="profile-button-follow">
                    <a class="" href="{{ action('PeopleController@friend_follow') }}">フォロー中</a>
                </div>
            </div>
            <div class="profile-wrap">
                <div class="profile-name">
                    @if($myAccount->user_name)
                    <p class="profile-name-txt">{{ $myAccount->user_name }}</p>
                    @endif
                </div>
                <div class="profile-set">
                    <a href="{{ action('PeopleController@profile') }}" class="">プロフィール設定</a>
                </div>
                <div class="profile-box">
                    <dl class="profile-def">
                        @if(isset($myAccount->age))
                        <div class="profile-def-box">
                            <dt class="profile-dtit">age : </dt>
                            <dd class="profile-data">{{ $myAccount->age }}</dd>
                        </div>
                        @endif
                        @if(isset($myAccount->alls()->first()->era->era))
                        @foreach($myAccount->alls as $all)
                        <div class="profile-def-box">
                            <dt class="profile-dtit">{{ $all->era->era }} : </dt>
                            @if($all->team->team)
                            <dd class="profile-data">{{ $all->team->team }}</dd>
                            @else
                            <dd class="profile-data">未設定です。</dd>
                            @endif
                        </div>
                        @endforeach
                        @endif
                        @if(isset($myAccount->area->area))
                        <div class="profile-def-box">
                            <dt class="profile-dtit profile-dtit-area">住んでいるところ : </dt>
                            <dd class="profile-data"> {{ $myAccount->area->area }}</dd>
                        </div>
                        @endif
                    </dl>
                    @if(isset($myAccount->introduction))
                    <p class="profile-intro">{{ $myAccount->introduction }}</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- /.profile -->

</main>
@endsection