<a href="{{ route('myhomes.index' }}"></a>
<a href="{{ route('activities.index' }}"></a>
<a href="{{ route('finds.index' }}"></a>
<a href="{{ route('talk_users.index') }}"></a>


<form class="" method="get" action="{{ route('friends.index' }}">
  {{ csrf_field() }}
  <input name="identify_id" type="hidden" value="follower">
  <input type="submit" value="フォローワー">
</form>
<form class="" method="get" action="{{ route('friends.index' }}">
  {{ csrf_field() }}
  <input name="identify_id" type="hidden" value="follow">
  <input type="submit" value="フォロー中">
</form>


<a href="{{ route('profiles.index' }}"></a>

<a href="{{ route('results.index' }}"></a>
<a href="{{ route('results.show' }}"></a>

<a href="{{ route('follow_lists.invoke' }}"></a>

<a href="{{ route('results.show', ['user' =>$account->id]) }}">{{ $account->name }}さんにフォローされました</a>
<a href="{{ route('profiles.image_update' }}"></a>
<a href="{{ route('profiles.profile_update' }}"></a>
<a href="{{ route('backs.from_details' }}"></a>
<a href="{{ route('follow_details.invoke' }}"></a>
<a href="{{ route('backs.from_talk_show' }}"></a>
<a href="{{ route('friends.index' }}"></a>

{{ route('results.show', ['user' => $searchAll->user->id]) }}
{{ route('results.show', ['user' => $account->id]) }}
{{ route('talk_users.contents.index', ['user' => $account->id]) }}
{{ route('talk_users.contents.index', ['user' => $hisAccount->id]) }}
{{ route('talk_users.contents.create', ['user' => $hisAccount->id]) }}
{{ route('results.show', ['user' => $]) }}

{{ route('profile.index', ['' => ]) }}

<form class="" action="{{ route('backs.from_details' }}" method="GET">
  @if ($identify_id == 'talk_find' || $identify_id == 'find')
  <input name="team_id" type="hidden" value="{{ $team_id }}">
  <input name="era_id" type="hidden" value="{{ $era_id }}">
  @endif
  <input name="user_id" type="hidden" value="{{ $hisAccount->id }}">
  <input name="identify_id" type="hidden" value="{{ $identify_id }}">
  {{ csrf_field() }}
  <input class="profile-top-button" type="submit" value="&lt; back">
</form>

<form class="" action="{{ route('talk_users.show', ['user' => $hisAccount->id]) }}" method="get">
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










  <form action="{{ route('talk_users.show', ['user' => $hisAccount->id]) }}" method="get">
    {{ csrf_field() }}
    <label>
      <input name="user_id" type="hidden" value="{{ $hisAccount->id }}">
      @if($identify_id == 'find')
      <input name="team_id" type="hidden" value="{{ $team_id }}">
      <input name="era_id" type="hidden" value="{{ $era_id }}">
      @endif
      <input class="button" type="submit" value="">
    </label>
  </form>

  <!-- ↑ これには本来これがあったがその理由はdetails.blade.phpへ行くのはPeopleController@detailsだけだったから
  こっちの<form>で調整するしかなかったから -->
  @if($identify_id == "talk_list")
  <input name="identify_id" type="hidden" value="{{ $identify_id }}">
  @else
  <input name="identify_id" type="hidden" value="talk_{{ $identify_id }}">
  @endif









  <form action="{{ route('talk_users.contents.create', ['user' => $hisAccount->id]) }}" method="post">
    {{ csrf_field() }}
    <div class="talk-send">
      <input name="identify_id" type="hidden" value="{{ $identify_id }}">
      @if($identify_id == 'find')
      <input name="team_id" type="hidden" value="{{ $team_id }}">
      <input name="era_id" type="hidden" value="{{ $era_id }}">
      @endif
      <textarea name="message" id="message" placeholder="メッセージを入力"></textarea>
      <div class="talk-send-button">
        <input class="" type="submit" value="送信">
      </div>
    </div>
  </form>