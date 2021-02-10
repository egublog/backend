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
                    <form class="results-wrap" action="{{ action('PeopleController@talk_show') }}" method="post">
                        {{ csrf_field() }}
                        <label>
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
                                        <p class="results-body-first-name">
                                            {{ $account->name }}
                                        </p>
                                        @if($account->user_name)
                                        <p class="results-body-first-truename">{{ $account->user_name }}</p>
                                        @endif
                                    </div>
                                </div>
                            </li>
                            <input name="user_id" type="hidden" value="{{ $account->id }}">
                            <input name="identify_id" type="hidden" value="{{ $identify_id }}">
                            @if($identify_id == 'find')
                            <input name="team_id" type="hidden" value="{{ $team_id }}">
                            <input name="era_id" type="hidden" value="{{ $era_id }}">
                            @endif
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
                        @if ($identify_id == "talk_list")
                        <form class="" action="{{ action('PeopleController@talk') }}" method="get">
                            @else
                            <form class="" action="{{ action('PeopleController@details') }}" method="post">
                                @if($identify_id == "find")
                                <input name="team_id" type="hidden" value="{{ $team_id }}">
                                <input name="era_id" type="hidden" value="{{ $era_id }}">
                                @endif
                                <input name="user_id" type="hidden" value="{{ $hisAccount->id }}">
                                <input name="identify_id" type="hidden" value="{{ $identify_id }}">
                                @endif
                                {{ csrf_field() }}
                                <input class="top-inner-back-button" type="submit" value="&lt;">
                            </form>
                    </div>
                    <p>{{ $hisAccount->user_name }}とのトーク</p>
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
                            <form class="talk-opponent-content-img" action="{{ action('PeopleController@details') }}" method="post">
                                {{ csrf_field() }}
                                <label>
                                    @if ($talkData->user->image == 1)
                                    <img src="/storage/profile_images/{{ $talkData->user->id }}.jpg" alt="">
                                    @else
                                    <img src="/storage/profile_images/no-image.png" alt="">
                                    @endif

                                    <input name="user_id" type="hidden" value="{{ $hisAccount->id }}">
                                    @if($identify_id == "talk_list")
                                    <input name="identify_id" type="hidden" value="{{ $identify_id }}">
                                    @else
                                    <input name="identify_id" type="hidden" value="talk_{{ $identify_id }}">
                                    @endif

                                    @if($identify_id == 'find')
                                    <input name="team_id" type="hidden" value="{{ $team_id }}">
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

                <form class="talk-send-form" action="{{ action('SecondController@talk_store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="talk-send">
                        <input name="user_id" type="hidden" value="{{ $hisAccount->id }}">
                        <input name="identify_id" type="hidden" value="{{ $identify_id }}">
                        @if($identify_id == 'find')
                        <input name="team_id" type="hidden" value="{{ $team_id }}">
                        <input name="era_id" type="hidden" value="{{ $era_id }}">
                        @endif
                        <input type="hidden" name="user_id" value="{{ $user_id }}">
                        <textarea name="message" id="message" resize="vertical" placeholder="メッセージを入力"></textarea>
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