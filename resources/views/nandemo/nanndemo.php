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




ここからがvueの上のやつ↓



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
                <!-- /.talk-inner -->


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











    ここからはbladeの方のやつ


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








    let createdAxiosGetUrl = `/talk_users/${userId}/contents/axios`;
      axios
        .get(createdAxiosGetUrl)
        .then((response) => {
          console.log(response.data.aas.myId);
        })
        .catch((error) => {
          alert(error);
        });































    <div class="topTalk-wrap">
      <section class="top">
        <div class="top-inner">
          <div class="top-inner-back">
            <form
              class=""
              action="{{ route('backs.from_talk_show') }}"
              method="get"
            >
              @if($identify_id == "find")
              <input
                name="team_string"
                type="hidden"
                value="{{ $team_string }}"
              />
              <input name="era_id" type="hidden" value="{{ $era_id }}" />
              @endif
              <input
                name="user_id"
                type="hidden"
                value="{{ $hisAccount->id }}"
              />
              <input
                name="identify_id"
                type="hidden"
                value="{{ $identify_id }}"
              />
              {{ csrf_field() }}
              <input class="top-inner-back-button" type="submit" value="&lt;" />
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
              <?php if ($talkData->created_at->format('w') == 0) : ?> (日)
              <?php elseif ($talkData->created_at->format('w') == 1) : ?> (月)
              <?php elseif ($talkData->created_at->format('w') == 2) : ?> (火)
              <?php elseif ($talkData->created_at->format('w') == 3) : ?> (水)
              <?php elseif ($talkData->created_at->format('w') == 4) : ?> (木)
              <?php elseif ($talkData->created_at->format('w') == 5) : ?> (金)
              <?php elseif ($talkData->created_at->format('w') == 6) : ?> (土)
              <?php endif; ?>
            </span>
          </p>
          <?php endif; ?>

          @if($talkData->from == $myId)
          <div class="talk-own">
            <div class="talk-own-content">
              <div class="talk-own-content-head">
                @if($talkData->yet)
                <p class="talk-own-content-head-yet">既読</p>
                @endif
                <p class="talk-own-content-head-time">
                  {{ $talkData->created_at->format('H:i') }}
                </p>
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
              <form
                class="talk-opponent-content-img"
                action="{{ route('talk_users.show', ['user' => $hisAccount->id]) }}"
                method="get"
              >
                {{ csrf_field() }}
                <label>
                  @if ($talkData->user->image === null)
                  <img
                    src="https://banana2.s3-ap-northeast-1.amazonaws.com/test/E7F5CC7C-E1B0-4630-99B8-DDD050E8E99E_1_105_c.jpeg"
                    alt=""
                  />
                  @else
                  <img src="{{ $talkData->user->image }}" />
                  @endif

                  <input
                    name="identify_id"
                    type="hidden"
                    value="{{ $identify_id }}"
                  />

                  @if($identify_id == 'find')
                  <input
                    name="team_string"
                    type="hidden"
                    value="{{ $team_string }}"
                  />
                  <input name="era_id" type="hidden" value="{{ $era_id }}" />
                  @endif
                  <input class="button" type="submit" value="" />
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
          @endif @endforeach @endif @error('message')
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->get('message') as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @enderror
        </div>

        <form
          action="{{ route('talk_users.contents.store', ['user' => $hisAccount->id]) }}"
          method="post"
        >
          {{ csrf_field() }}
          <div class="talk-send">
            <input
              name="identify_id"
              type="hidden"
              value="{{ $identify_id }}"
            />
            @if($identify_id == 'find')
            <input
              name="team_string"
              type="hidden"
              value="{{ $team_string }}"
            />
            <input name="era_id" type="hidden" value="{{ $era_id }}" />
            @endif
            <textarea
              name="message"
              id="message"
              placeholder="メッセージを入力"
            ></textarea>
            <div class="talk-send-button">
              <input class="" type="submit" value="送信" />
            </div>
          </div>
        </form>
      </section>
      <!-- /.talk -->
    </div>
    <!-- .topTalk-wrap -->












    <template v-for="account in talkListsAccounts" :key="account.myId">
              <!-- <form
            class="results-wrap"
            action="{{ route('talk_users.contents.index', ['user' => account.id]) }}"
            method="get"
          > -->
              <!-- ↑　これは削除するやつ代わりは↓ -->
              <div v-on:click="userChange(userId)" class="results-wrap">
                <!-- {{ csrf_field() }} -->
                <label>
                  <li class="results-item">
                    <div class="results-head">
                      <div class="results-img">
                        <!-- @if (account.image === null) -->
                        <!-- ↑ ↓ 上をしたに適用　上は消すやつ -->

                        <img
                          v-if="account.image === null"
                          src="https://banana2.s3-ap-northeast-1.amazonaws.com/test/E7F5CC7C-E1B0-4630-99B8-DDD050E8E99E_1_105_c.jpeg"
                          alt=""
                        />
                        <!-- @else -->
                        <!-- ↑ ↓ 上をしたに適用　上は消すやつ -->

                        <img v-else src="{{ account.image }}" />
                        <!-- @endif -->
                        <!-- ↑ 消す -->
                      </div>
                    </div>
                    <div class="results-body">
                      <div class="results-body-first">
                        <p class="results-body-first-name">
                          {{ account.name }}
                        </p>
                        <!-- @if(account.user_name) -->
                        <!-- ↑ ↓ 上をしたに適用　上は消すやつ -->
                        <p
                          v-if="account.user_name"
                          class="results-body-first-truename"
                        >
                          {{ account.user_name }}
                        </p>
                        <!-- @endif -->
                      </div>
                    </div>
                  </li>
                  <!-- <input
                name="identify_id"
                type="hidden"
                value="{{ $identify_id }}"
              /> -->
                  <!-- <input class="button" type="submit" value="" /> -->
                </label>
                <!-- </form> -->
                <!-- ↑　これは削除するやつ代わりは↓ -->
              </div>
              <!-- @endforelse @endif -->
              <!-- ↑ ↓ 上をしたに適用　上は消すやつ -->
            </template>



            /talk_users/2/contents/axios?pageNumber=2