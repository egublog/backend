@extends('layouts.default')

@section('css', '/css/myService/details.css')

@section('content')

<main>


    <section class="profile">

        <div class="profile-inner">

            <div class="profile-top">
                <form class="" action="{{ route('backs.from_details') }}" method="GET">
                    @if ($viewModel->identify_id == 'talk_find' || $viewModel->identify_id == 'find')
                    <input name="team_string" type="hidden" value="{{ $viewModel->team_string }}">
                    <input name="era_id" type="hidden" value="{{ $viewModel->era_id }}">
                    @endif
                    <input name="user_id" type="hidden" value="{{ $viewModel->hisAccount->id }}">
                    <input name="identify_id" type="hidden" value="{{ $viewModel->identify_id }}">
                    {{ csrf_field() }}
                    <input class="profile-top-button" type="submit" value="&lt; back">
                </form>

                <p class="profile-top-tit">{{ $viewModel->hisAccount->name }}</p>
            </div>

            <div class="profile-img">
                @if ($viewModel->hisAccount->image === null)
                <img src="https://banana2.s3-ap-northeast-1.amazonaws.com/test/E7F5CC7C-E1B0-4630-99B8-DDD050E8E99E_1_105_c.jpeg" alt="">
                @else
                <img src="{{ $viewModel->hisAccount->image }}">
                @endif
            </div>

            @if ($viewModel->identify_id == 'find')
            <follow-details-button :identify-id="{{ json_encode($viewModel->identify_id) }}" :initial-follow-check="{{ json_encode($viewModel->hisAccount->follow_check) }}" :user-id="{{ json_encode($viewModel->hisAccount->id) }}" :era-id="{{ json_encode($viewModel->era_id) }}" :team-string="{{ json_encode($viewModel->team_string) }}"></follow-details-button>
            @else
            <follow-details-button :identify-id="{{ json_encode($viewModel->identify_id) }}" :initial-follow-check="{{ json_encode($viewModel->hisAccount->follow_check) }}" :user-id="{{ json_encode($viewModel->hisAccount->id) }}"></follow-details-button>
            @endif

            <div class="profile-wrap">
                <div class="profile-name">
                    @if($viewModel->hisAccount->user_name)
                    <p class="profile-name-txt">{{ $viewModel->hisAccount->user_name }}</p>
                    @endif
                </div>
                <div class="profile-box">
                    <dl class="profile-def">
                        @if(isset($viewModel->hisAccount->age))
                        <div class="profile-def-box">
                            <dt class="profile-dtit">age : </dt>
                            <dd class="profile-data">{{ $viewModel->hisAccount->age }}</dd>
                        </div>
                        @endif
                        @foreach($viewModel->hisAccount->eras as $era)
                        
                        <div class="profile-def-box">
                            <dt class="profile-dtit">{{ $era->era_name }} : </dt>
                            <dd class="profile-data">{{ $era->team_name }}</dd>
                        </div>
                        @endforeach
                        @if($viewModel->hisAccount->area_id != '未設定です')
                        <div class="profile-def-box">
                            <dt class="profile-dtit profile-dtit-area">住んでいるところ : </dt>
                            <dd class="profile-data"> {{ $viewModel->hisAccount->area_name }}</dd>
                        </div>
                        @endif
                    </dl>
                    @if(isset($viewModel->hisAccount->introduction))
                    <p class="profile-intro">{{ $viewModel->hisAccount->introduction }}</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- /.profile -->

</main>

@endsection