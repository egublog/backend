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
                <a class="back" href="{{ route('myhomes.index') }}">&lt; back</a>
            </div>
            <ul class="results-list">
                @if(isset($accounts))
                @forelse($accounts as $account)
                <li class="results-item">
                    <div class="results-head">
                        <div class="results-img">
                            @if ($account->image === null)
                            <img src="https://banana2.s3-ap-northeast-1.amazonaws.com/test/E7F5CC7C-E1B0-4630-99B8-DDD050E8E99E_1_105_c.jpeg" alt="">
                            @else
                            <img src="{{ $account->image }}">
                            @endif
                        </div>
                    </div>
                    <div class="results-body">
                        <div class="results-body-first">
                            <form action="{{ route('friends.show', ['user' => $account->id]) }}" method="get" class="results-body-first-name">
                                <!-- ここの$account->idは$accountと省略できる                 ↑↑-->
                                {{ csrf_field() }}
                                <input name="identify_id" type="hidden" value="{{ $identify_id }}">
                                <input class="" type="submit" value="{{ $account->name }}">
                            </form>

                            @if($account->user_name)
                            <span class="results-body-first-truename">{{ $account->user_name }}</span>
                            @endif
                            @if($account->age)
                            <span class="results-body-first-age">age: {{ $account->age }} </span>
                            @endif
                            <?php
                            // $follow_check = $myAccount->show_follow()->where('receive_user_id', $account->id)->first();
                            $follow_check = $myAccount->followCheck($account->id);
                            ?>
                            <div class="results-body-first-follow">
                                <follow-button :initial-follow-check="{{ json_encode($follow_check) }}" :user-id="{{ json_encode($account->id) }}"></follow-button>
                            </div>


                        </div>
                        <div class="results-body-second">
                            <!-- @if(isset($account->alls()->first()->team_id)) -->
                            @foreach($account->alls()->orderBy('id', 'desc')->get() as $all)
                            <span class="hidden-sp results-body-second-team">
                                <!-- @if($all->team->team_name) -->
                                {{ $all->team->team_name }}
                                <!-- @else -->
                                <!-- 未入力です。 -->
                                <!-- @endif -->
                                <span class="hidden-sp">/</span>
                            </span>
                            @endforeach
                            <span></span>
                            <!-- @endif -->
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