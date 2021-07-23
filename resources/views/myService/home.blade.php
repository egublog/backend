@extends('layouts.default')


@section('css', '/css/myService/home.css')

@section('content')

<main>

    <section class="profile">
        <div class="profile-inner" id="app2">
            <div class="profile-top">
                <p class="profile-top-tit">{{ $viewModel->user->name }}</p>
            </div>
            <div class="profile-img">
                @if ($viewModel->user->image === null)
                <img src="https://banana2.s3-ap-northeast-1.amazonaws.com/test/E7F5CC7C-E1B0-4630-99B8-DDD050E8E99E_1_105_c.jpeg" alt="">
                @else
                <img src="{{ $viewModel->user->image }}">
                @endif
            </div>
            <div class="profile-button">
                <div class="profile-button-follower">
                    <form class="" method="get" action="{{ route('friends.index') }}">
                        {{ csrf_field() }}
                        <input name="identify_id" type="hidden" value="friend_follower">
                        <input class="profile-button-follower-input" type="submit" value="フォローワー">
                    </form>
                </div>
                <div class="profile-button-follow">
                    <form class="" method="get" action="{{ route('friends.index') }}">
                        {{ csrf_field() }}
                        <input name="identify_id" type="hidden" value="friend_follow">
                        <input class="profile-button-follower-input" type="submit" value="フォロー中">
                    </form>
                </div>
            </div>
            <div class="profile-wrap">
                <div class="profile-name">
                    @if($viewModel->user->user_name)
                    <p class="profile-name-txt">{{ $viewModel->user->user_name }}</p>
                    @endif
                </div>
                <div class="profile-set">
                    <a href="{{ route('profiles.index') }}">プロフィール設定</a>
                </div>
                <div class="profile-box">
                    <dl class="profile-def">
                        @if(isset($viewModel->user->age))
                        <div class="profile-def-box">
                            <dt class="profile-dtit">age : </dt>
                            <dd class="profile-data">{{ $viewModel->user->age }}</dd>
                        </div>
                        @endif
                        @foreach($viewModel->user->eras as $era)
                        <div class="profile-def-box">
                            <dt class="profile-dtit">{{ $era->era_name }} : </dt>
                            <dd class="profile-data">{{ $era->team_name }}</dd>
                        </div>
                        @endforeach
                        @if($viewModel->user->area_id != '未設定です')
                        <div class="profile-def-box">
                            <dt class="profile-dtit profile-dtit-area">住んでいるところ : </dt>
                            <dd class="profile-data"> {{ $viewModel->user->area_name }}</dd>
                        </div>
                        @endif
                    </dl>
                    @if(isset($viewModel->user->introduction))
                    <p class="profile-intro">{{ $viewModel->user->introduction }}</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- /.profile -->

</main>
@endsection