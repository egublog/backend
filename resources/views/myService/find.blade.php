@extends('layouts.default')

@section('css', '/css/myService/find.css')

@section('content')


<main>
    <section class="search">
        <form class="search-form" method="get" action="{{ route('results.index') }}">
            {{ csrf_field() }}
            <dl class="search-def">
                <label class="search-def-box">
                    <dt class="search-dtit">年代</dt>
                    <dd class="search-data">
                        <select class="" id="era" name="era_id" value="{{ $era_id }}">
                            <option value="1" @if($era_id=='1' ) selected @endif>小学校</option>
                            <option value="2" @if($era_id=='2' ) selected @endif>中学校</option>
                            <option value="3" @if($era_id=='3' ) selected @endif>高校</option>
                            <option value="4" @if($era_id=='4' ) selected @endif>大学</option>
                        </select>
                    </dd>
                </label>
                @error('team_string')
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->get('team_string') as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @enderror
                <label class="search-def-box">
                    <dt class="search-dtit">所属チーム</dt>
                    <dd class="search-data">
                        <input type="text" class="" name="team_string" value="{{ old('team_string', $team_string) }}">
                    </dd>
                </label>
            </dl>
            <div class="search-button">
                <input class="" type="submit" value="検索">
            </div>
        </form>
    </section>
    <!-- /.search -->

    <section class="results">
        <div class="results-inner">
            <ul class="results-list">
                @if(isset($searchAllses))
                @forelse($searchAllses as $searchAlls)
                @foreach($searchAlls as $searchAll)
                @if($searchAll->user->id != $myAccount->id)

                <li class="results-item">
                    <div class="results-head">
                        <div class="results-img">
                            @if ($searchAll->user->image === null)
                            <img src="https://banana2.s3-ap-northeast-1.amazonaws.com/test/E7F5CC7C-E1B0-4630-99B8-DDD050E8E99E_1_105_c.jpeg" alt="">
                            @else
                            <img src="{{ $searchAll->user->image }}">
                            @endif
                        </div>
                    </div>
                    <div class="results-body">
                        <div class="results-body-first">
                            <form action="{{ route('results.show', ['user' => $searchAll->user->id]) }}" method="get">
                                {{ csrf_field() }}
                                <input name="team_string" type="hidden" value="{{ $team_string }}">
                                <input name="era_id" type="hidden" value="{{ $era_id }}">
                                <input type="submit" value="{{ $searchAll->user->name }}">
                                <br>
                            </form>
                            @if($searchAll->user->user_name)
                            <span class="results-body-first-truename">{{ $searchAll->user->user_name }}</span>
                            @endif
                            @if($searchAll->user->age)
                            <span class="results-body-first-age">age: {{ $searchAll->user->age }} </span>
                            @endif
                            <?php
                            // $follow_check = $myAccount->show_follow()->where('receive_user_id', $searchAll->user->id)->first();
                            $follow_check = $myAccount->followCheck($searchAll->user->id);
                            ?>
                            <div class="results-body-first-follow">
                                <follow-button :initial-follow-check="{{ json_encode($follow_check) }}" :user-id="{{ json_encode($searchAll->user->id) }}"></follow-button>
                            </div>
                            
                        </div>
                        <div class="results-body-second">
                            <!-- @if($searchAll->user->alls()->first()->team_id) -->
                            @foreach($searchAll->user->alls()->orderBy('id', 'desc')->get() as $all)
                            <span class="results-body-second-team">
                                <!-- @if($all->team->team_name) -->
                                {{ $all->team->team_name }}
                                <!-- @else -->
                                <!-- 未入力です。 -->
                                <!-- @endif -->
                                <span class="hidden-sp">/</span></span>
                            @endforeach
                            <!-- <span></span> -->
                            <!-- @endif -->
                        </div>
                    </div>
                </li>
                @endif
                @endforeach
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