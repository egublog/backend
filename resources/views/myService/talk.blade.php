@extends('layouts.default')

@section('css', '/css/myService/talk.css')

@section('content')



<main>


    <section class="results">
        <div class="results-inner">

            <p class="results-tit">トーク</p>
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
                                    <div class="results-body-first-name">
                                        <span>{{ $account->name }}</span>
                                    </div>
                                    @if($account->user_name)
                                    <span class="results-body-first-truename">{{ $account->user_name }}</span>
                                    @endif
                                    @if($account->age)
                                    <span class="results-body-first-age">age: {{ $account->age }} </span>
                                    @endif
                                </div>
                                <div class="results-body-second">
                                    @foreach($account->alls()->orderBy('id', 'desc')->get() as $all)
                                    <span class="results-body-second-team">
                                        {{ $all->team->team_name }}
                                        /</span>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                        <input name="identify_id" type="hidden" value="talk_list">
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

</main>

@endsection

