@extends('layouts.default')

@section('css', '/css/myService/details.css')

@section('content')

<main>


    <section class="profile">

        <div class="profile-inner">

            <div class="profile-top">
                <form class="" action="{{ route('backs.from_details') }}" method="GET">
                    @if ($identify_id == 'talk_find' || $identify_id == 'find')
                    <input name="team_string" type="hidden" value="{{ $team_string }}">
                    <input name="era_id" type="hidden" value="{{ $era_id }}">
                    @endif
                    <input name="user_id" type="hidden" value="{{ $hisAccount->id }}">
                    <input name="identify_id" type="hidden" value="{{ $identify_id }}">
                    {{ csrf_field() }}
                    <input class="profile-top-button" type="submit" value="&lt; back">
                </form>

                <p class="profile-top-tit">{{ $hisAccount->name }}</p>
            </div>

            <div class="profile-img">
                @if ($hisAccount->image === null)
                <img src="https://banana2.s3-ap-northeast-1.amazonaws.com/test/E7F5CC7C-E1B0-4630-99B8-DDD050E8E99E_1_105_c.jpeg" alt="">
                @else
                <img src="{{ $hisAccount->image }}">
                @endif
            </div>

            @if ($identify_id == 'find')
            <follow-details-button :identify-id="{{ json_encode($identify_id) }}" :initial-follow-check="{{ json_encode($follow_check) }}" :user-id="{{ json_encode($hisAccount->id) }}" :era-id="{{ json_encode($era_id) }}" :team-string="{{ json_encode($team_string) }}"></follow-details-button>
            @else
            <follow-details-button :identify-id="{{ json_encode($identify_id) }}" :initial-follow-check="{{ json_encode($follow_check) }}" :user-id="{{ json_encode($hisAccount->id) }}"></follow-details-button>
            @endif

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
                        @foreach($hisAccount->eras as $era)
                        
                        <div class="profile-def-box">
                            <dt class="profile-dtit">{{ $era->changeEraIdToEraName($era->era_id) }} : </dt>
                            <dd class="profile-data">{{ $era->team->team_name }}</dd>
                        </div>
                        @endforeach
                        @if($hisAccount->area_id != '未設定です')
                        <div class="profile-def-box">
                            <dt class="profile-dtit profile-dtit-area">住んでいるところ : </dt>
                            <dd class="profile-data"> {{ $hisAccount->changeAreaIdToPrefecturesName($hisAccount->area_id) }}</dd>
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