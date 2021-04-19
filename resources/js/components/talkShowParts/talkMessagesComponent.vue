<template>
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
              <span v-else-if="momentDayOfTheWeek(talkData.created_at) == 1">
                (月)
              </span>
              <span v-else-if="momentDayOfTheWeek(talkData.created_at) == 2">
                (火)
              </span>
              <span v-else-if="momentDayOfTheWeek(talkData.created_at) == 3">
                (水)
              </span>
              <span v-else-if="momentDayOfTheWeek(talkData.created_at) == 4">
                (木)
              </span>
              <span v-else-if="momentDayOfTheWeek(talkData.created_at) == 5">
                (金)
              </span>
              <span v-else-if="momentDayOfTheWeek(talkData.created_at) == 6">
                (土)
              </span>
            </p>
          </template>

          <template v-if="talkData.from == myId">
            <div class="talk-own">
              <div class="talk-own-content">
                <div class="talk-own-content-head">
                  <p v-if="talkData.yet" class="talk-own-content-head-yet">
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
              <div v-on:click="showDetail()" class="talk-opponent-content">
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
</template>

<script>
// import { defineComponent } from '@vue/composition-api'

export default {
  props: {
    talkDatas: {
      required: true,
    },
    identifyId: {
      required: true,
    },
    eraId: {
      required: false,
    },
    teamString: {
      required: false,
    },
    hisAccount: {
      required: true,
    },
    myId: {
      required: true,
    },
    errorMessages: {
      required: true,
    },
    errorExist: {
      required: true,
    },
    pageNumber: {
      required: true,
    },
  },
  data: function () {
    return {
      preTalkInnerScrollHeight: 0,
      nowTalkInnerScrollHeight: 0,
    };
  },
  computed: {
    returnTalkDatas: function () {
      return this.talkDatas;
    },
  },
  created() {},
  beforeMount() {},
  mounted() {
    let talkInnerElement = this.$refs.talkInnerScroll;

      this.scrollToBottom();

    // talkInnerElement.scrollTo({
    //   top: talkInnerElement.scrollHeight,
    //   behavior: "auto",
    // });
    console.log("mounted");
    talkInnerElement = this.$refs.talkInnerScroll;
    talkInnerElement.addEventListener("scroll", this.scrollTalkUpdate);
  },
  beforeCreate() {},
  updated() {
    console.log("updated");

    if (this.pageNumber == 1) {
      this.scrollToBottom();

      let talkInnerElement = this.$refs.talkInnerScroll;
      // talkInnerElement.scrollTo({
      //   top: talkInnerElement.scrollHeight,
      //   behavior: "auto",
      // });

      console.log(talkInnerElement.scrollHeight);
    } else {
      let talkInnerElement = this.$refs.talkInnerScroll;

      let talkInnerElementNew = this.$refs.talkInnerScroll;
      this.nowTalkInnerScrollHeight = talkInnerElement.scrollHeight;

      let differrenceTalkInnerScrollHeight =
        this.nowTalkInnerScrollHeight - this.preTalkInnerScrollHeight;

      talkInnerElementNew.scrollTo({
        top: differrenceTalkInnerScrollHeight,
        behavior: "auto",
      });
      // console.log(2);
      console.log(this.nowTalkInnerScrollHeight);
      console.log(this.preTalkInnerScrollHeight);
      console.log(differrenceTalkInnerScrollHeight);
    }
  },
  beforeUpdate() {},
  methods: {
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
    scrollTalkUpdate() {
      let talkInnerElement = this.$refs.talkInnerScroll;
      // this.console(talkInnerElement.scrollTop);

      if (talkInnerElement.scrollTop == 0) {
        let talkInnerElement = this.$refs.talkInnerScroll;
        this.preTalkInnerScrollHeight = talkInnerElement.scrollHeight;

        this.$emit("scroll-talk-update-parent");

        // this.pageNumber++;

        // let url = `/talk_users/${this.hisAccount.id}/contents/axios/talkUpdate?pageNumber=${this.pageNumber}`;
        // axios
        //   .get(url)
        //   .then((response) => {
        //     this.talkDatas = response.data.talkArray.talkDatas;
        //     // this.$emit("scroll-talk-update-parent", response);
        //   })
        //   .catch((error) => {
        //     alert(error);
        //   });
      }
    },
    scrollToBottom() {
      let talkInnerElement = this.$refs.talkInnerScroll;
      talkInnerElement.scrollTo({
        top: talkInnerElement.scrollHeight,
        behavior: "auto",
      });
    },
  },
};
</script>
