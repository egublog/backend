@extends('layouts.default')

@section('css', '/css/myService/details.css')

@section('content')

<main>


    <section class="profile">

        <div class="profile-inner">

            <div class="profile-top">
                @if ($identify_id == 'friend_follow')
                <form class="" action="{{ action('PeopleController@friend_follow') }}" method="GET">
                    @elseif ($identify_id == 'friend_follower')
                    <form class="" action="{{ action('PeopleController@friend_follower') }}" method="GET">
                        @elseif ($identify_id == 'activity')
                        <form class="" action="{{ action('PeopleController@activity') }}" method="GET">
                            @elseif ($identify_id == 'find')
                            <form class="" action="{{ action('SecondController@find_return') }}" method="post">
                                <input name="team_id" type="hidden" value="{{ $team_id }}">
                                <input name="era_id" type="hidden" value="{{ $era_id }}">
                                @endif
                                @if($identify_id == 'talk_find' || $identify_id == 'talk_activity' || $identify_id == 'talk_friend_follow' || $identify_id == 'talk_friend_follower' || $identify_id == 'talk_list')
                                <form class="" action="{{ action('PeopleController@talk_show') }}" method="post">
                                    @if($identify_id == 'talk_find')
                                    <input name="team_id" type="hidden" value="{{ $team_id }}">
                                    <input name="era_id" type="hidden" value="{{ $era_id }}">
                                    @endif
                                    <input name="user_id" type="hidden" value="{{ $hisAccount->id }}">
                                    <input name="identify_id" type="hidden" value="{{ $identify_id }}">
                                    @endif
                                    {{ csrf_field() }}
                                    <input class="profile-top-button" type="submit" value="&lt; back">
                                </form>
                                <p class="profile-top-tit">{{ $hisAccount->name }}</p>
            </div>

            <div class="profile-img">
                @if ($hisAccount->image == 1)
                <img src="/storage/profile_images/{{ $hisAccount->id }}.jpg" alt="">
                @else
                <img src="/storage/profile_images/no-image.png" alt="">
                @endif
            </div>
            <div class="profile-button">
                @if(isset($follow_check))
                @if($identify_id == 'find' || $identify_id == 'activity' || $identify_id == 'friend_follow' || $identify_id == 'friend_follower')
                <form class="profile-button-talk" action="{{ action('PeopleController@talk_show') }}" method="post">
                    {{ csrf_field() }}
                    @if($identify_id == 'find')
                    <input name="team_id" type="hidden" value="{{ $team_id }}">
                    <input name="era_id" type="hidden" value="{{ $era_id }}">
                    @endif
                    <input name="user_id" type="hidden" value="{{ $hisAccount->id }}">
                    <input name="identify_id" type="hidden" value="{{ $identify_id }}">
                    <input class="profile-button-talk-button" type="submit" value="メッセージ">
                </form>
                @endif
                @endif
                <form class="profile-button-follow" action="{{ action('SecondController@follow_switch_details') }}" method="post">
                    @if(isset($follow_check))
                    <input class="profile-button-follow-input onfollow" type="submit" value="フォロー中">
                    @else
                    <input class="profile-button-follow-input notfollow" type="submit" value="フォローする">
                    @endif
                    {{ csrf_field() }}
                    @if($identify_id == 'find' || $identify_id == 'talk_find')
                    <input name="team_id" type="hidden" value="{{ $team_id }}">
                    <input name="era_id" type="hidden" value="{{ $era_id }}">
                    @endif
                    <input name="user_id" type="hidden" value="{{ $hisAccount->id }}">
                    <input name="identify_id" type="hidden" value="{{ $identify_id }}">
                </form>
            </div>
            <div class="profile-wrap">
                <div class="profile-name">
                    @if($hisAccount->user_name)
                    <p class="profile-name-txt">{{ $hisAccount->user_name }}</p>
                    @endif
                </div>
                <div class="profile-box">
                    <dl class="profile-def">
                        @if(isset($hisAccount->age))
                        <div class="profile-def-box">
                            <dt class="profile-dtit">age : </dt>
                            <dd class="profile-data">{{ $hisAccount->age }}</dd>
                        </div>
                        @endif
                        @if(isset($hisAccount->alls()->first()->era->era))
                        @foreach($hisAccount->alls as $all)
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
                        @if(isset($hisAccount->area->area))
                        <div class="profile-def-box">
                            <dt class="profile-dtit profile-dtit-area">住んでいるところ : </dt>
                            <dd class="profile-data"> {{ $hisAccount->area->area }}</dd>
                        </div>
                        @endif
                    </dl>
                    @if(isset($hisAccount->introduction))
                    <p class="profile-intro">{{ $hisAccount->introduction }}</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- /.profile -->

</main>

@endsection