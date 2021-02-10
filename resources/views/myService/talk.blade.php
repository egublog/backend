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
                                    @if(isset($account->alls()->first()->team_id))
                                    @foreach($account->alls()->orderBy('id', 'desc')->get() as $all)
                                    <span class="results-body-second-team">
                                        @if($all->team->team)
                                        {{ $all->team->team }}
                                        @else
                                        未入力です。
                                        @endif
                                        /</span>
                                    @endforeach
                                    <!-- <span></span> -->
                                    @endif
                                </div>
                            </div>
                        </li>
                        <input name="user_id" type="hidden" value="{{ $account->id }}">
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

</main>

@endsection