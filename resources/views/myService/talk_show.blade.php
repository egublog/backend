@extends('layouts.default')

@section('css', '/css/myService/talk_show.css')

@section('content')

<main>

    <div class="pc-wrap">

        @if($identify_id == 'talk_list')
        <section class="results">
            <div class="results-inner">
                <ul class="results-list">
                    @if(isset($talk_lists_accounts))
                    @forelse($talk_lists_accounts as $account)
                    <form class="results-wrap" action="{{ route('talk_users.contents.index', ['user' => $account->id]) }}" method="get">
                        {{ csrf_field() }}
                        <label>
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
                                        <p class="results-body-first-name">
                                            {{ $account->name }}
                                        </p>
                                        @if($account->user_name)
                                        <p class="results-body-first-truename">{{ $account->user_name }}</p>
                                        @endif
                                    </div>
                                </div>
                            </li>
                            <input name="identify_id" type="hidden" value="{{ $identify_id }}">
                            <input class="button" type="submit" value="">
                        </label>
                    </form>
                    @empty
                    <p class="results-nohit">見つかりませんでした</p>
                    @endforelse
                    @endif
                </ul>
            </div>
        </section>
        <!-- /.results -->
        @endif



        <div class="topTalk-wrap">

            <section class="top">
                <div class="top-inner">
                    <div class="top-inner-back">
                        <form class="" action="{{ route('backs.from_talk_show') }}" method="get">
                            @if($identify_id == "find")
                            <input name="team_string" type="hidden" value="{{ $team_string }}">
                            <input name="era_id" type="hidden" value="{{ $era_id }}">
                            @endif
                            <input name="user_id" type="hidden" value="{{ $hisAccount->id }}">
                            <input name="identify_id" type="hidden" value="{{ $identify_id }}">
                            {{ csrf_field() }}
                            <input class="top-inner-back-button" type="submit" value="&lt;">
                        </form>
                    </div>
                    <p>{{ $hisAccount->name }}とのトーク</p>
                </div>
            </section>
            <!-- /.top -->

            <section class="talk">
                <div class="talk-inner" id="talk-inner-scroll">
                    @if(isset($talkDatas))
                    <?php $baseDate = 'a'; ?>
                    @foreach($talkDatas as $talkData)
                    <?php if ($baseDate != $talkData->created_at->format('n/j')) : ?>
                        <?php $baseDate = $talkData->created_at->format('n/j'); ?>
                        <p class="talk-date">
                            {{ $talkData->created_at->format('n/j') }}
                            <span class="">
                                <?php if ($talkData->created_at->format('w') == 0) : ?>
                                    (日)
                                <?php elseif ($talkData->created_at->format('w') == 1) : ?>
                                    (月)
                                <?php elseif ($talkData->created_at->format('w') == 2) : ?>
                                    (火)
                                <?php elseif ($talkData->created_at->format('w') == 3) : ?>
                                    (水)
                                <?php elseif ($talkData->created_at->format('w') == 4) : ?>
                                    (木)
                                <?php elseif ($talkData->created_at->format('w') == 5) : ?>
                                    (金)
                                <?php elseif ($talkData->created_at->format('w') == 6) : ?>
                                    (土)
                                <?php endif; ?>
                            </span>
                        </p>
                    <?php endif; ?>

                    @if($talkData->from == $myId)
                    <div class="talk-own">
                        <div class="talk-own-content">
                            <div class="talk-own-content-head">
                                @if($talkData->yet)<p class="talk-own-content-head-yet">既読</p>@endif
                                <p class="talk-own-content-head-time">{{ $talkData->created_at->format('H:i') }}</p>
                            </div>
                            <div class="talk-own-content-body">
                                <p class="talk-own-content-body-txt">
                                    {{ $talkData->talk_data }}
                                </p>
                            </div>
                        </div>

                    </div>
                    @else
                    <div class="talk-opponent">
                        <div class="talk-opponent-content">
                            <form class="talk-opponent-content-img" action="{{ route('talk_users.show', ['user' => $hisAccount->id]) }}" method="get">
                                {{ csrf_field() }}
                                <label>
                                    @if ($talkData->user->image === null)
                                    <img src="https://banana2.s3-ap-northeast-1.amazonaws.com/test/E7F5CC7C-E1B0-4630-99B8-DDD050E8E99E_1_105_c.jpeg" alt="">
                                    @else
                                    <img src="{{ $talkData->user->image }}">
                                    @endif

                                    <input name="identify_id" type="hidden" value="{{ $identify_id }}">

                                    @if($identify_id == 'find')
                                    <input name="team_string" type="hidden" value="{{ $team_string }}">
                                    <input name="era_id" type="hidden" value="{{ $era_id }}">
                                    @endif
                                    <input class="button" type="submit" value="">
                                </label>
                            </form>

                            <div class="talk-opponent-content-body">
                                <p class="talk-opponent-content-body-txt">
                                    {{ $talkData->talk_data }}
                                </p>
                            </div>
                            <div class="talk-opponent-content-footer">
                                <p class="talk-opponent-content-footer-time">
                                    {{ $talkData->created_at->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @endif
                    @error('message')
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->get('message') as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @enderror
                </div>

                <form action="{{ route('talk_users.contents.store', ['user' => $hisAccount->id]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="talk-send">
                        <input name="identify_id" type="hidden" value="{{ $identify_id }}">
                        @if($identify_id == 'find')
                        <input name="team_string" type="hidden" value="{{ $team_string }}">
                        <input name="era_id" type="hidden" value="{{ $era_id }}">
                        @endif
                        <textarea name="message" id="message" placeholder="メッセージを入力"></textarea>
                        <div class="talk-send-button">
                            <input class="" type="submit" value="送信">
                        </div>
                    </div>
                </form>

            </section>
            <!-- /.talk -->

        </div>
        <!-- .topTalk-wrap -->

    </div>
    <!-- .pc-wrap -->


</main>





@endsection