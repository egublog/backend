@extends('layouts.default')

@section('css', '/css/myService/activity.css')

@section('content')



<main>


    <section class="results">
        <div class="results-inner">
            <p class="results-tit">アクティビティ</p>
            <ul class="results-list">
                @if(isset($accounts_follower))
                @forelse($accounts_follower as $account)
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
                                <input class="" type="submit" value="{{ $account->name }}さんにフォローされました">
                            </form>
                            <div class="results-body-first-time">
                                <span>{{ $account->follows()->where('send_user_id', $account->id)->where('receive_user_id', $myId)->first()->created_at->format('n月j日 H:i') }}</span>
                            </div>
                        </div>
                        <div class="results-body-second">
                            @if($account->user_name)
                            <span class="results-body-second-truename">{{ $account->user_name }}</span>
                            @endif
                            @if($account->age)
                            <span class="results-body-second-age">age: {{ $account->age }} </span>
                            @endif
                            <?php
                            $follow_check = $myAccount->show_follow()->where('receive_user_id', $account->id)->first();
                            ?>
                            <form class="results-body-second-follow" action="{{ action('SecondController@follow_switch_list') }}" method="post">
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