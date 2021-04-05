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
                            @if ($account->image === null )
                            <img src="https://banana2.s3-ap-northeast-1.amazonaws.com/test/E7F5CC7C-E1B0-4630-99B8-DDD050E8E99E_1_105_c.jpeg" alt="">
                            @else
                            <img src="{{ $account->image }}">
                            @endif
                        </div>
                    </div>
                    <div class="results-body">
                        <div class="results-body-first">
                            <div class="results-body-first-name">
                                <!-- ↓ ここに <input>と同じ様になる様にclassを当てる↑このdivは今追加した -->
                                <a href="{{ route('activities.show', ['user' => $account->id]) }}">{{ $account->name }}さんにフォローされました</a>
                            </div>
                            <div class="results-body-first-time">
                                <span>{{ $account->follows()->where('send_user_id', $account->id)->where('receive_user_id', $myAccount->id)->first()->created_at->format('n月j日 H:i') }}</span>
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
                            <form class="results-body-second-follow" action="{{ route('follow_lists.invoke') }}" method="post">
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