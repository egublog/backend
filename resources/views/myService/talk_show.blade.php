@extends('layouts.default')

@section('css', '/css/myService/talk_show.css')

@section('content')

<main>

    @if ($identify_id == 'find')
    <talk-show :identify-id="{{ json_encode($identify_id) }}" :initial-user-id="{{ json_encode($user_id) }}" :initial-talk-datas="{{ json_encode($talkDatas) }}" :initial-his-account="{{ json_encode($hisAccount) }}" :initial-my-id="{{ json_encode($myId) }}" :initial-talk-lists-accounts="{{ json_encode($talk_lists_accounts) }}" :era-id="{{ json_encode($era_id) }}" :team-string="{{ json_encode($team_string) }}">
    </talk-show>
    @else
    <talk-show :identify-id="{{ json_encode($identify_id) }}" :initial-user-id="{{ json_encode($user_id) }}" :initial-talk-datas="{{ json_encode($talkDatas) }}" :initial-his-account="{{ json_encode($hisAccount) }}" :initial-my-id="{{ json_encode($myId) }}" :initial-talk-lists-accounts="{{ json_encode($talk_lists_accounts) }}">
    </talk-show>
    @endif

</main>



@endsection