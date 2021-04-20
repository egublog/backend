<template>
  <div class="pc-wrap">
    <!-- @if($identify_id == 'talk_list') -->
    <!-- ↑ ↓ 上をしたに適用　上は消すやつ -->

<!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! <talkUsers>-->
    <talkUsers :talkListsAccounts="talkListsAccounts" :identifyId="identifyId" @usesr-change-parent="userChangeParent"></talkUsers>
<!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! </talkUsers> -->

    <!-- /.results -->
    <!-- @endif -->

    <div class="topTalk-wrap">

<!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!<talkTop> -->
      <talkTops :hisAccount="hisAccount" :identifyId="identifyId" :eraId="eraId" :teamString="teamString"></talkTops>
<!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!</talkTop> -->

      <!-- /.top -->
      <!-- {{ setBaseDate('b') }} -->
      <!-- ここにtalk -->
      <section class="talk">

<!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! <talkMessages>-->
        <talkMessages :talkDatas="talkDatas" :errorMessages="errorMessages" :errorExist="errorExist" :identifyId="identifyId" :eraId="eraId" :teamString="teamString" :hisAccount="hisAccount" :myId="myId" :pageNumber="pageNumber" @scroll-talk-update-parent="scrollTalkUpdateParent"></talkMessages>
<!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!</talkMessages> -->


        <!-- talk-inner ↑ -->
<!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!<talkSend> -->
       <talkSend :message="message" :hisAccount="hisAccount" :identifyId="identifyId" @talk-send-parent="talkSendParent" @talk-send-parent-error="talkSendParentError" @textarea-update="textareaUpdate"></talkSend>
<!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!</talkSend> -->

      </section>
      <!-- talk ↑ -->
    </div>
    <!-- .topTalk-wrap -->
  </div>
  <!-- .pc-wrap -->
</template>

<script>
// import { defineComponent } from '@vue/composition-api'
import talkUsers from "./talkShowParts/talkUsersComponent.vue";
import talkTops from "./talkShowParts/talkTopsComponent.vue";
import talkMessages from "./talkShowParts/talkMessagesComponent.vue";
import talkSend from "./talkShowParts/talkSendComponent.vue";



export default {
    components: {
        talkUsers,
        talkTops,
        talkMessages,
        talkSend,
    },
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
    initialTalkDatas: {
      required: true,
    },
    initialTalkListsAccounts: {
      required: true,
    },
    initialHisAccount: {
      required: true,
    },
    initialMyId: {
      required: true,
    },
  },
  data: function () {
    return {
      talkDatas: "",
      hisAccount: "",
      talkListsAccounts: "",
      myId: "",
      message: "",
    //   talkSendDatas: "",
      errorExist: false,
      errorMessages: "",
      pageNumber: 1,
    //   preTalkInnerScrollHeight: 0,
    //   nowTalkInnerScrollHeight: 0,
    };
  },
  computed: {
    returnTalkDatas: function () {
      return this.talkDatas;
    },
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
    console.log("TalkShowのcreatedを通りました");

    this.talkDatas = this.initialTalkDatas;
    this.hisAccount = this.initialHisAccount;
    this.myId = this.initialMyId;
    this.talkListsAccounts = this.initialTalkListsAccounts;
  },
  beforeMount() {
    // console.log("beforeMounted");
  },
  mounted() {
    console.log("TalkShowのmountedを通りました");

    // let talkInnerElement = this.$refs.talkInnerScroll;
    // talkInnerElement.scrollTo({
    //   top: talkInnerElement.scrollHeight,
    //   behavior: "auto",
    // });
    // console.log("mounted");
    // talkInnerElement = this.$refs.talkInnerScroll;
    // talkInnerElement.addEventListener("scroll", this.scroll);
  },
  beforeCreate() {
    // console.log("beforeCreated");
  },
  updated() {
    console.log("親のupdated");
    console.log(this.talkDatas);


    // if (this.pageNumber == 1) {
    //   let talkInnerElement = this.$refs.talkInnerScroll;
    //   talkInnerElement.scrollTo({
    //     top: talkInnerElement.scrollHeight,
    //     behavior: "auto",
    //   });

    //   console.log(talkInnerElement.scrollHeight);
    // } else {
    //   let talkInnerElement = this.$refs.talkInnerScroll;

    //   let talkInnerElementNew = this.$refs.talkInnerScroll;
    //   this.nowTalkInnerScrollHeight = talkInnerElement.scrollHeight;

    //   let differrenceTalkInnerScrollHeight =
    //     this.nowTalkInnerScrollHeight - this.preTalkInnerScrollHeight;

    //   talkInnerElementNew.scrollTo({
    //     top: differrenceTalkInnerScrollHeight,
    //     behavior: "auto",
    //   });
    //   console.log(2);
    //   console.log(this.nowTalkInnerScrollHeight);
    //   console.log(this.preTalkInnerScrollHeight);
    //   console.log(differrenceTalkInnerScrollHeight);
    // }
  },
  beforeUpdate() {
    // console.log("beforeUpdate");
  },
  methods: {
    userChangeParent(response) {
    //   let userChangeUrl = `/talk_users/${userId}/contents/axios/userChange`;
    //   axios
        // .get(userChangeUrl)
        // .then((response) => {
          this.talkDatas = response.data.talkArray.talkDatas;
          this.hisAccount = response.data.talkArray.hisAccount;
          this.errorExist = false;
          this.errorMessages = "";
          this.message = "";
          this.pageNumber = 1;
        // })
        // .catch((error) => {
        //   alert(error);
        // });
    },
    // back() {
    //   if (this.identifyId == "find") {
    //     let url =
    //       "/backs/from_talk_show?" +
    //       "identify_id=" +
    //       this.identifyId +
    //       "&user_id=" +
    //       this.hisAccount.id +
    //       "&era_id=" +
    //       this.eraId +
    //       "&team_string=" +
    //       this.teamString;
    //     window.location.href = url;
    //   } else {
    //     let url =
    //       "/backs/from_talk_show?" +
    //       "identify_id=" +
    //       this.identifyId +
    //       "&user_id=" +
    //       this.hisAccount.id;
    //     window.location.href = url;
    //   }
    // },
    talkSendParent(response) {
    //   let url = `/talk_users/${this.hisAccount.id}/contents`;

    //   if (this.identifyId == find) {
    //     this.talkSendDatas = {
    //       message: this.message,
    //       identify_id: this.identifyId,
    //       era_id: this.eraId,
    //       team_string: this.teamString,
    //     };
    //   } else {
    //     this.talkSendDatas = {
    //       message: this.message,
    //       identify_id: this.identifyId,
    //     };
    //   }

    //   axios
        // .post(url, this.talkSendDatas)
        // .then((response) => {
          console.log("then側！");
          this.message = "";
          this.talkDatas = response.data.talkArray.talkDatas;
          this.talkListsAccounts = response.data.talkArray.talkListsAccounts;
          this.errorExist = false;
          this.errorMessages = "";
          this.pageNumber = 1;

          console.log(this.talkDatas);
        // })
        // .catch((error) => {
        //   console.log(error.response);
        //   this.errorExist = true;
        //   this.errorMessages = error.response.data.errors.message;
        //   this.pageNumber = 1;
        // });
    },
    talkSendParentError(error) {
    //   let url = `/talk_users/${this.hisAccount.id}/contents`;

    //   if (this.identifyId == find) {
    //     this.talkSendDatas = {
    //       message: this.message,
    //       identify_id: this.identifyId,
    //       era_id: this.eraId,
    //       team_string: this.teamString,
    //     };
    //   } else {
    //     this.talkSendDatas = {
    //       message: this.message,
    //       identify_id: this.identifyId,
    //     };
    //   }

    //   axios
    //     .post(url, this.talkSendDatas)
    //     .then((response) => {
    //       console.log("then側！");
    //       this.message = "";
    //       this.talkDatas = response.data.talkArray.talkDatas;
    //       this.talkListsAccounts = response.data.talkArray.talkListsAccounts;
    //       this.errorExist = false;
    //       this.errorMessages = "";
    //       this.pageNumber = 1;

    //       console.log(this.talkDatas);
    //     })
    //     .catch((error) => {
          console.log("aiueo");
          this.errorExist = true;
          this.errorMessages = error.response.data.errors.message;
          this.pageNumber = 1;
        // });
    },
    console(abc) {
      console.log(abc);
    },
    // momentDate(date) {
    //   return moment(date).format("M/D");
    //   //   07/30
    // },
    // momentDayOfTheWeek(date) {
    //   return moment(date).format("d");
    //   //   水
    // },
    // momentTime(date) {
    //   return moment(date).format("HH:mm");
    //   //   08:24
    // },
    // showDetail() {
    //   if (this.identifyId == "find") {
    //     let url =
    //       `/talk_users/${this.hisAccount.id}?` +
    //       "identify_id=" +
    //       this.identifyId +
    //       "&era_id=" +
    //       this.eraId +
    //       "&team_string=" +
    //       this.teamString;
    //     window.location.href = url;
    //   } else {
    //     let url =
    //       `/talk_users/${this.hisAccount.id}?` +
    //       "identify_id=" +
    //       this.identifyId;
    //     window.location.href = url;
    //   }
    // },
    // scroll() {
    //   let talkInnerElement = this.$refs.talkInnerScroll;
    //   this.console(talkInnerElement.scrollTop);

    //   if (talkInnerElement.scrollTop == 0) {
    //     let talkInnerElement = this.$refs.talkInnerScroll;
    //     this.preTalkInnerScrollHeight = talkInnerElement.scrollHeight;

    //     this.pageNumber++;

    //     let url = `/talk_users/${this.hisAccount.id}/contents/axios/talkUpdate?pageNumber=${this.pageNumber}`;
    //     axios
    //       .get(url)
    //       .then((response) => {
    //         this.talkDatas = response.data.talkArray.talkDatas;
    //       })
    //       .catch((error) => {
    //         alert(error);
    //       });
    //   }
    // },
    scrollTalkUpdateParent() {
        // this.talkDatas = response.data.talkArray.talkDatas;
        this.pageNumber++;

        let url = `/talk_users/${this.hisAccount.id}/contents/axios/talkUpdate?pageNumber=${this.pageNumber}`;
        axios
          .get(url)
          .then((response) => {
            this.talkDatas = response.data.talkArray.talkDatas;
            // this.$emit("scroll-talk-update-parent", response);
          })
          .catch((error) => {
            alert(error);
          });
    },
    textareaUpdate(message) {
        this.message = message;
    },
  },
};
</script>
