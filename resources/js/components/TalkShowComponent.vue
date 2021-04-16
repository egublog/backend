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
            <div class="" v-on:click="back()">
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
              <button class="top-inner-back-button">&lt;</button>

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
        <div class="talk-inner" ref="talkInnerScroll">
          <template v-if="talkDatas !== []">
            <template v-for="talkData in returnTalkDatas">
              <div :key="talkData.id" class="">
                <!-- ↑　これは実際には表示しないやつstyle: noe -->
                <!-- {{ console(momentDate(talkData.created_at)) }} -->
                <template v-if="talkData.talkCheck === 1">
                  <!-- ここの中にロジックを埋め込みたい！これはもうvueの仕様の問題かも！！！！ -->
                  <!-- {{ setBaseDate(momentDate(talkData.created_at)) }} -->
                  <p class="talk-date">
                    {{ momentDate(talkData.created_at) }}
                    <span
                      v-if="momentDayOfTheWeek(talkData.created_at) == 0"
                      class=""
                    >
                      (日)
                    </span>
                    <span
                      v-else-if="momentDayOfTheWeek(talkData.created_at) == 1"
                    >
                      (月)
                    </span>
                    <span
                      v-else-if="momentDayOfTheWeek(talkData.created_at) == 2"
                    >
                      (火)
                    </span>
                    <span
                      v-else-if="momentDayOfTheWeek(talkData.created_at) == 3"
                    >
                      (水)
                    </span>
                    <span
                      v-else-if="momentDayOfTheWeek(talkData.created_at) == 4"
                    >
                      (木)
                    </span>
                    <span
                      v-else-if="momentDayOfTheWeek(talkData.created_at) == 5"
                    >
                      (金)
                    </span>
                    <span
                      v-else-if="momentDayOfTheWeek(talkData.created_at) == 6"
                    >
                      (土)
                    </span>
                  </p>
                </template>

                <template v-if="talkData.from == myId">
                  <div class="talk-own">
                    <div class="talk-own-content">
                      <div class="talk-own-content-head">
                        <p
                          v-if="talkData.yet"
                          class="talk-own-content-head-yet"
                        >
                          既読
                        </p>
                        <p class="talk-own-content-head-time">
                          {{ momentTime(talkData.created_at) }}
                        </p>
                      </div>
                      <div class="talk-own-content-body">
                        <p class="talk-own-content-body-txt">
                          {{ talkData.talk_data }}
                        </p>
                      </div>
                    </div>
                  </div>
                </template>
                <template v-else>
                  <div class="talk-opponent">
                    <div
                      v-on:click="showDetail()"
                      class="talk-opponent-content"
                    >
                      <div class="talk-opponent-content-img">
                        <label>
                          <!-- @if ($talkData->user->image === null) -->
                          <img
                            v-if="talkData.user.image == null"
                            src="https://banana2.s3-ap-northeast-1.amazonaws.com/test/E7F5CC7C-E1B0-4630-99B8-DDD050E8E99E_1_105_c.jpeg"
                            alt=""
                          />
                          <!-- @else -->
                          <img v-else :src="talkData.user.image" />
                          <!-- @endif -->

                          <!-- <input name="identify_id" type="hidden" value="{{ $identify_id }}"> -->

                          <!-- @if($identify_id == 'find')
                                    <input name="team_string" type="hidden" value="{{ $team_string }}">
                                    <input name="era_id" type="hidden" value="{{ $era_id }}">
                                    @endif -->
                          <!-- <input class="button" type="submit" value=""> -->
                          <!-- ↑ ↓ 上をしたに適用　上は消すやつ -->
                          <button class="button"></button>
                        </label>
                      </div>

                      <div class="talk-opponent-content-body">
                        <p class="talk-opponent-content-body-txt">
                          {{ talkData.talk_data }}
                          <!-- {{ console(talkData.user.id) }}
                          {{ console("iu") }} -->
                        </p>
                      </div>
                      <div class="talk-opponent-content-footer">
                        <p class="talk-opponent-content-footer-time">
                          {{ momentTime(talkData.created_at) }}
                        </p>
                      </div>
                    </div>
                  </div>
                  <!-- @endif -->
                </template>
              </div>
            </template>
            <!-- endfor↑ -->
          </template>
          <!-- endif ↑ -->

          <!-- @error('message') -->
          <div v-if="errorExist" class="alert alert-danger error-message">
            <ul>
              <!-- @foreach ($errors->get('message') as $error) -->
              <li v-for="errorMessage in errorMessages" :key="errorMessage">
                {{ errorMessage }}
              </li>
              <!-- @endforeach -->
            </ul>
          </div>
          <!-- @enderror -->
        </div>
        <!-- talk-inner ↑ -->
        <div>
          <!-- ↑ これがformタグの代わり -->
          <!-- {{ csrf_field() }} -->
          <div class="talk-send">
            <!-- <input name="identify_id" type="hidden" value="{{ $identify_id }}"> -->
            <!-- @if($identify_id == 'find')
                        <input name="team_string" type="hidden" value="{{ $team_string }}">
                        <input name="era_id" type="hidden" value="{{ $era_id }}">
                        @endif -->
            <textarea
              v-model="message"
              name="message"
              id="message"
              placeholder="メッセージを入力"
            ></textarea>
            <div class="talk-send-button">
              <!-- <input class="" type="submit" value="送信"> -->
              <button v-on:click="talkSend()">送信</button>
            </div>
          </div>
        </div>
      </section>
      <!-- talk ↑ -->
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
      message: "",
      baseDate: "aaaa",
      talkSendDatas: "",
      errorExist: false,
      errorMessages: "",
      pageNumber: 1,
      preTalkInnerScrollHeight: 0,
      nowTalkInnerScrollHeight: 0,
    };
  },
  computed: {
      returnTalkDatas: function() {
          return this.talkDatas;
      }

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
    let createdUrl = `/talk_users/${this.initialUserId}/contents/axios?pageNumber=1`;
    axios
      .get(createdUrl)
      .then((response) => {
        console.log("createdと通りました");
        this.talkDatas = response.data.talkArray.talkDatas;
        this.hisAccount = response.data.talkArray.hisAccount;
        this.myId = response.data.talkArray.myId;
        this.talkListsAccounts = response.data.talkArray.talkListsAccounts;
        this.baseDate = "a";
        // これで初期値を設定できた
        // console.log(this.baseDate);
        // console.log(response.data.talkArray.talkDatas[0].created_at);
       
      })
      .catch((error) => {
        alert(error);
      });
  },
  beforeMount() {
    // let talkInnerElement = this.$refs.talkInnerScroll;

    // talkInnerElement.scrollTo({
    //   top: talkInnerElement.scrollHeight,
    //   behavior: "auto",
    // });
    console.log("mounted");
  },
  mounted() {
      
      console.log("beforeMounted");
      let talkInnerElement = this.$refs.talkInnerScroll;
      talkInnerElement.addEventListener('scroll', this.scroll);
    //   this.scroll();

  },
  beforeCreate() {
      console.log("beforeCreated");
  },
  updated() {
    console.log("updated");

    if(this.pageNumber == 1) {
        
        
        let talkInnerElement = this.$refs.talkInnerScroll;
        talkInnerElement.scrollTo({
            top: talkInnerElement.scrollHeight,
          behavior: "auto",
        });

        console.log(talkInnerElement.scrollHeight);

    } else {
        
        let talkInnerElement = this.$refs.talkInnerScroll;
        
        let talkInnerElementNew = this.$refs.talkInnerScroll;
          this.nowTalkInnerScrollHeight = talkInnerElement.scrollHeight;
        
                let differrenceTalkInnerScrollHeight = this.nowTalkInnerScrollHeight - this.preTalkInnerScrollHeight;

        talkInnerElementNew.scrollTo({
            top: differrenceTalkInnerScrollHeight,
            behavior: "auto",
          });
          console.log(2);
          console.log(this.nowTalkInnerScrollHeight);
          console.log(this.preTalkInnerScrollHeight);
          console.log(differrenceTalkInnerScrollHeight);
    }




    //     window.addEventListener('scroll', this.console);
    // this.console(window.scrollY);
  },
  beforeUpdate() {
    console.log("beforeUpdate");
     
  },
  methods: {
    userChange(userId) {
      let userChangeUrl = `/talk_users/${userId}/contents/axios?pageNumber=1`;
      axios
        .get(userChangeUrl)
        .then((response) => {
          //   console.log(response.data.talkArray.talkDatas);
          this.talkDatas = response.data.talkArray.talkDatas;
          this.hisAccount = response.data.talkArray.hisAccount;
          this.baseDate = "a";
          this.errorExist = false;
          this.errorMessages = "";
          this.message = "";
          this.pageNumber = 1;

          //   let talkInnerElement = document.getElementById("#talk-inner-scroll");
          let talkInnerElement = this.$refs.talkInnerScroll;

          talkInnerElement.scrollTo({
            top: talkInnerElement.scrollHeight,
            behavior: "auto",
          });
          //   console.log(talkInnerElement);

          //   talkInnerElement.scrollTop = talkInnerElement.scrollHeight;
          // これで初期値を設定できた
        })
        .catch((error) => {
          alert(error);
        });
      this.baseDate = "a";
      //   console.log(userId);
    },
    back() {
      if (this.identifyId == "find") {
        let url =
          "/backs/from_talk_show?" +
          "identify_id=" +
          this.identifyId +
          "&user_id=" +
          this.hisAccount.id +
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
          this.hisAccount.id;
        window.location.href = url;
      }
    },
    talkSend() {

          this.pageNumber = 1;


      let url = `/talk_users/${this.hisAccount.id}/contents`;

      if (this.identifyId == find) {
        this.talkSendDatas = {
          message: this.message,
          identify_id: this.identifyId,
          era_id: this.eraId,
          team_string: this.teamString,
          pageNumber: 1,
        };
      } else {
          this.talkSendDatas = {
              message: this.message,
          identify_id: this.identifyId,
            pageNumber: 1,
        };
      }

      axios
        .post(url, this.talkSendDatas)
        .then((response) => {
          console.log("then側！");
          this.message = "";
          this.talkDatas = response.data.talkArray.talkDatas;
          this.talkListsAccounts = response.data.talkArray.talkListsAccounts;
          this.errorExist = false;
          this.errorMessages = "";



          let talkInnerElement = this.$refs.talkInnerScroll;

          talkInnerElement.scrollTo({
            top: talkInnerElement.scrollHeight,
            behavior: "auto",
          });

        })
        .catch((error) => {
          console.log(error.response);
          this.errorExist = true;
          this.errorMessages = error.response.data.errors.message;
          //   alert(error);
          // console.log("エラー");
          let talkInnerElement = this.$refs.talkInnerScroll;

          talkInnerElement.scrollTo({
            top: talkInnerElement.scrollHeight,
            behavior: "auto",
          });
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
      return moment(date).format("HH:mm");
      //   08:24
    },
    setBaseDate(newDate) {
      if (this.baseDate != newDate) {
        this.baseDate = newDate;
      }
    },
    showDetail() {
      if (this.identifyId == "find") {
        let url =
          `/talk_users/${this.hisAccount.id}?` +
          "identify_id=" +
          this.identifyId +
          "&era_id=" +
          this.eraId +
          "&team_string=" +
          this.teamString;
        window.location.href = url;
      } else {
        let url =
          `/talk_users/${this.hisAccount.id}?` +
          "identify_id=" +
          this.identifyId;
        window.location.href = url;
      }
    },
    // window: (scroll = function () {
    //   //   let talkInnerElement = document.getElementById("#talk-inner-scroll");

    //   //   talkInnerElement.scrollTop = talkInnerElement.scrollHeight;

    //   let talkInnerElement = this.$refs.talkInnerScroll;

    //   talkInnerElement.scrollTo({
    //     top: talkInnerElement.scrollHeight,
    //     behavior: "auto",
    //   });
    // window.addEventListener('scroll', this.console);
    // this.scroll();
    // }),
    scroll() {
        let talkInnerElement = this.$refs.talkInnerScroll;
        // this.console(talkInnerElement.scrollTop);
        // this.console('スクロールされてるよ！');
        this.console(talkInnerElement.scrollTop);

        if (talkInnerElement.scrollTop == 0) {
            // console.log('oioiooiooiooi');

            let talkInnerElement = this.$refs.talkInnerScroll;
            this.preTalkInnerScrollHeight = talkInnerElement.scrollHeight;

        //   talkInnerElement.scrollTo({
        //     top: talkInnerElement.scrollHeight,
        //     behavior: "auto",
        //   });
            this.pageNumber++;

            let url = `/talk_users/${this.hisAccount.id}/contents/axios?pageNumber=${this.pageNumber}`;
      axios
        .get(url)
        .then((response) => {
          //   console.log(response.data.talkArray.talkDatas);
          this.talkDatas = response.data.talkArray.talkDatas;

        //   talkInnerElement = this.$refs.talkInnerScroll;
        //   this.nowTalkInnerScrollHeight = talkInnerElement.scrollHeight;

         

        //   this.hisAccount = response.data.talkArray.hisAccount;
        //   this.baseDate = "a";
        //   this.errorExist = false;
        //   this.errorMessages = "";
        //   this.message = "";
        //   this.pageNumber = 1;

          //   let talkInnerElement = document.getElementById("#talk-inner-scroll");
        //   let talkInnerElement = this.$refs.talkInnerScroll;

        //   talkInnerElement.scrollTo({
        //     top: talkInnerElement.scrollHeight,
        //     behavior: "auto",
        //   });
          //   console.log(talkInnerElement);

          //   talkInnerElement.scrollTop = talkInnerElement.scrollHeight;
          // これで初期値を設定できた
        })
        .catch((error) => {
          alert(error);
        });

        }

    },
  },
};
</script>
