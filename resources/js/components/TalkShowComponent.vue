<template>
  <div class="pc-wrap">
    <!-- @if($identify_id == 'talk_list') -->
    <!-- ↑ ↓ 上をしたに適用　上は消すやつ -->
    <section v-if="identifyId == 'talk_list'" class="results">
      <div class="results-inner">
        <ul class="results-list">
          <!-- @if(isset($talk_lists_accounts)) @forelse($talk_lists_accounts as
          $account) -->
          <!-- ↑ ↓ 上をしたに適用　上は消すやつ   後で下に:key=""をつける↓-->
          <template v-if="talkListsAccounts !== null">
            <template v-for="account in talkListsAccounts">
              <div
                :key="account.id"
                v-on:click="userChange(account.id)"
                class="results-wrap"
              >
                <!-- {{ console(account) }} -->
                <label for="">
                  <li class="results-item">
                    <div class="results-head">
                      <div class="results-img">
                        <img
                          v-if="account.image === null"
                          src="https://banana2.s3-ap-northeast-1.amazonaws.com/test/E7F5CC7C-E1B0-4630-99B8-DDD050E8E99E_1_105_c.jpeg"
                          alt=""
                        />
                        <img v-else :src="account.image" />
                      </div>
                    </div>

                    <div class="results-body">
                      <div class="results-body-first">
                        <p class="results-body-first-name">
                          {{ account.name }}
                        </p>
                        <p
                          v-if="account.user_name"
                          class="results-body-first-truename"
                        >
                          {{ account.user_name }}
                        </p>
                      </div>
                    </div>
                  </li>
                </label>
              </div>
            </template>
            <h1>成功中！！</h1>
          </template>
          <!-- @empty -->
          <p v-else class="results-nohit">見つかりませんでした</p>
        </ul>
      </div>
    </section>
    <!-- /.results -->
    <!-- @endif -->

    <div class="topTalk-wrap">
      <section class="top">
        <div class="top-inner">
          <div class="top-inner-back">
            <!-- <form
              class=""
              action="{{ route('backs.from_talk_show') }}"
              method="get"
            > -->
            <!-- ↑ ↓ 上をしたに適用　上は消すやつ -->
            <div class="" v-on:click="back(hisAccount.id)">
              <!-- @if($identify_id == "find")
              <input
                name="team_string"
                type="hidden"
                value="{{ $team_string }}"
              />
              <input name="era_id" type="hidden" value="{{ $era_id }}" />
              @endif -->
              <!-- <input
                name="user_id"
                type="hidden"
                value="{{ $hisAccount->id }}"
              /> -->
              <!-- <input
                name="identify_id"
                type="hidden"
                value="{{ $identify_id }}"
              /> -->
              <!-- {{ csrf_field() }} -->
              <!-- <input class="top-inner-back-button" type="submit" value="&lt;" /> -->
              <!-- ↑ ↓ 上をしたに適用　上は消すやつ -->
              <button>&lt;</button>

              <!-- </form> -->
              <!-- ↑ ↓ 上をしたに適用　上は消すやつ -->
            </div>
          </div>
          <p>{{ hisAccount.name }}とのトーク</p>
        </div>
      </section>
      <!-- /.top -->
  <!-- {{ setBaseDate('b') }} -->
      <!-- ここにtalk -->
      <section class="talk">
        <div class="talk-inner" id="talk-inner-scroll">
          <template v-if="talkDatas !== []">
            <template v-for="talkData in talkDatas">
              <div :key="talkData.id" class="">
                <!-- ↑　これは実際には表示しないやつstyle: noe -->
                <!-- {{ console(momentDate(talkData.created_at)) }} -->
                <template
                  v-if="baseDate != momentDate(talkData.created_at)"
                >
                <!-- ここの中にロジックを埋め込みたい！これはもうvueの使用の問題かも！！！！ -->
                  <!-- {{ setBaseDate(momentDate(talkData.created_at)) }} -->
                  <p class="talk-date">
                    {{ momentDate(talkData.created_at) }}
                    <span class="">
                        {{ momentDayOfTheWeek(talkData.created_at) }}
                    </span>
                  </p>
                </template>
              </div>
            </template>
          </template>
        </div>
      </section>
    </div>
    <!-- .topTalk-wrap -->
  </div>
  <!-- .pc-wrap -->
</template>

<script>
// import { defineComponent } from '@vue/composition-api'

export default {
  props: {
    identifyId: {
      required: true,
    },
    initialUserId: {
      required: true,
    },
    eraId: {
      required: false,
    },
    teamString: {
      required: false,
    },
  },
  data: function () {
    return {
      talkDatas: "",
      hisAccount: "",
      talkListsAccounts: "",
      myId: "",
      talk: "",
      baseDate: "aaaa",
    };
  },
  filters: {
    momentDate(date) {
      return moment(date).format("M/D");
      //   07/30
    },
    momentDayOfTheWeek(date) {
      return moment(date).format("dd");
      //   水
    },
    momentTime(date) {
      return moment(date).format("kk:mm");
      //   08:24
    },
  },
  created() {
    let createdUrl = `/talk_users/${this.initialUserId}/contents/axios`;
    axios
      .get(createdUrl)
      .then((response) => {
        // console.log(response.data.talkArray);
        this.talkDatas = response.data.talkArray.talkDatas;
        this.hisAccount = response.data.talkArray.hisAccount;
        this.myId = response.data.talkArray.myId;
        this.talkListsAccounts = response.data.talkArray.talkListsAccounts;
         this.baseDate = 'a';
        // これで初期値を設定できた
      console.log(this.baseDate);
      console.log(response.data.talkArray.talkDatas[0].created_at);

      })
      .catch((error) => {
        alert(error);
      });

  },
  methods: {
    userChange(userId) {
      let userChangeUrl = `/talk_users/${userId}/contents/axios`;
      axios
        .get(userChangeUrl)
        .then((response) => {
          console.log(response.data.talkArray.talkDatas);
          this.talkDatas = response.data.talkArray.talkDatas;
          this.hisAccount = response.data.talkArray.hisAccount;
          this.baseDate = 'a';

          // これで初期値を設定できた
        })
        .catch((error) => {
          alert(error);
        });
     this.baseDate = 'a';
    //   console.log(userId);
    },
    back(userId) {
      if (this.identifyId == "find") {
        let url =
          "/backs/from_talk_show?" +
          "identify_id=" +
          this.identifyId +
          "&user_id=" +
          userId +
          "&era_id=" +
          this.eraId +
          "&team_string=" +
          this.teamString;
        window.location.href = url;
      } else {
        let url =
          "/backs/from_talk_show?" +
          "identify_id=" +
          this.identifyId +
          "&user_id=" +
          userId;
        window.location.href = url;
      }
    },
    send(userId, content) {
      let url = `/talk_users/${userId}/contents`;

      axios
        .post(url, {
          content: content,
        })
        .then((response) => {
          this.talk = "";
        })
        .catch((error) => {
          alert(error);
        });
    },
    console(abc) {
      console.log(abc);
    },
    momentDate(date) {
      return moment(date).format("M/D");
      //   07/30
    },
    momentDayOfTheWeek(date) {
      return moment(date).format("d");
      //   水
    },
    momentTime(date) {
      return moment(date).format("kk:mm");
      //   08:24
    },
    setBaseDate(newDate) {
      if (this.baseDate != newDate) {
        this.baseDate = newDate;
      }
    },
  },
};
</script>
