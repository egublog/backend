@extends('layouts.default')


@section('css', '/css/myService/home.css')

@section('content')

<main>

    <section class="profile">
        <div class="profile-inner" id="app2">
            <div class="profile-top">
                <p class="profile-top-tit">{{ $myAccount->name }}</p>
            </div>
            <div class="profile-img">
                @if ($myAccount->image === null)
                <img src="https://banana2.s3-ap-northeast-1.amazonaws.com/test/E7F5CC7C-E1B0-4630-99B8-DDD050E8E99E_1_105_c.jpeg" alt="">
                @else
                <img src="{{ $myAccount->image }}">
                @endif
            </div>
            <div class="profile-button">
                <div class="profile-button-follower">
                    <form class="aタグに適用していた物をする下のinputのsubmitに" method="get" action="{{ route('friends.index') }}">
                        {{ csrf_field() }}
                        <input name="identify_id" type="hidden" value="friend_follower">
                        <input class="profile-button-follower-input" type="submit" value="フォローワー">
                    </form>
                </div>
                <div class="profile-button-follow">
                    <form class="aタグに適用していた物をする下のinputのsubmitに" method="get" action="{{ route('friends.index') }}">
                        {{ csrf_field() }}
                        <input name="identify_id" type="hidden" value="friend_follow">
                        <input class="profile-button-follower-input" type="submit" value="フォロー中">
                    </form>
                </div>
            </div>
            <div class="profile-wrap">
                <div class="profile-name">
                    @if($myAccount->user_name)
                    <p class="profile-name-txt">{{ $myAccount->user_name }}</p>
                    @endif
                </div>
                <div class="profile-set">
                    <a href="{{ route('profiles.index') }}">プロフィール設定</a>
                </div>
                <div class="profile-box">
                    <dl class="profile-def">
                        @if(isset($myAccount->age))
                        <div class="profile-def-box">
                            <dt class="profile-dtit">age : </dt>
                            <dd class="profile-data">{{ $myAccount->age }}</dd>
                        </div>
                        @endif
                        @if(isset($myAccount->alls()->first()->era_id))
                        @foreach($myAccount->alls as $all)
                        <div class="profile-def-box">
                            <dt class="profile-dtit">{{ $all->changeEraIdToEraName($all->era_id) }} : </dt>
                            <!-- @if($all->team->team_name) -->
                            <dd class="profile-data">{{ $all->team->team_name }}</dd>
                            <!-- @else -->
                            <!-- <dd class="profile-data">未設定です。</dd> -->
                            <!-- @endif -->
                        </div>
                        @endforeach
                        @endif
                        @if($myAccount->area_id != '未設定です')
                        <div class="profile-def-box">
                            <dt class="profile-dtit profile-dtit-area">住んでいるところ : </dt>
                            <dd class="profile-data"> {{ $myAccount->changeAreaIdToPrefecturesName($myAccount->area_id) }}</dd>
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