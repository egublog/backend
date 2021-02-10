@extends('layouts.default')

@section('css', '/css/myService/friend.css')

@section('content')



<main>


    <section class="results">
        <div class="results-inner">
            @if($identify_id == 'friend_follow')
            <p class="results-tit">フォロー</p>
            @else
            <p class="results-tit">フォローワー</p>
            @endif
            <div class="results-back">
                <a class="back" href="{{ action('PeopleController@home') }}">&lt; back</a>
            </div>
            <ul class="results-list">
                @if(isset($accounts))
                @forelse($accounts as $account)
                <li class="results-item">
                    <div class="results-head">
                        <div class="results-img">
                            @if ($account->image == 1)
                            <img src="/storage/profile_images/{{ $account->id }}.jpg" alt="">
                            @else
                            <img src="/storage/profile_images/no-image.png" alt="">
                            @endif
                        </div>
                    </div>
                    <div class="results-body">
                        <div class="results-body-first">
                            <form action="{{ action('PeopleController@details') }}" class="results-body-first-name" method="post">
                                {{ csrf_field() }}
                                <input name="identify_id" type="hidden" value="{{ $identify_id }}">
                                <input name="user_id" type="hidden" value="{{ $account->id }}">
                                <input class="" type="submit" value="{{ $account->name }}">
                            </form>
                            @if($account->user_name)
                            <span class="results-body-first-truename">{{ $account->user_name }}</span>
                            @endif
                            @if($account->age)
                            <span class="results-body-first-age">age: {{ $account->age }} </span>
                            @endif
                            <?php
                            $follow_check = $myAccount->show_follow()->where('receive_user_id', $account->id)->first();
                            ?>
                            <form class="results-body-first-follow" action="{{ action('SecondController@follow_switch_list') }}" method="post">
                                @if(isset($follow_check))
                                <input class="onfollow" type="submit" value="フォロー中">
                                @else
                                <input class="notfollow" type="submit" value="フォローする">
                                @endif
                                {{ csrf_field() }}
                                <input name="user_id" type="hidden" value="{{ $account->id }}">
                                <input name="identify_id" type="hidden" value="{{ $identify_id }}">
                            </form>
                        </div>
                        <div class="results-body-second">
                            @if(isset($account->alls()->first()->team_id))
                            @foreach($account->alls()->orderBy('id', 'desc')->get() as $all)
                            <span class="hidden-sp results-body-second-team">
                                @if($all->team->team)
                                {{ $all->team->team }}
                                @else
                                未入力です。
                                @endif
                                <span class="hidden-sp">/</span></span>
                            @endforeach
                            <span></span>
                            @endif
                        </div>
                    </div>
                </li>
                @empty
                <p class="results-nohit">見つかりませんでした</p>
                @endforelse
                @endif
            </ul>
        </div>
    </section>
    <!-- /.results -->

</main>

@endsection