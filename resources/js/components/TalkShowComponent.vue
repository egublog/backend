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
      errorExist: false,
      errorMessages: "",
      pageNumber: 1,
    };
  },
  computed: {

  },
  created() {
    this.talkDatas = this.initialTalkDatas;
    this.hisAccount = this.initialHisAccount;
    this.myId = this.initialMyId;
    this.talkListsAccounts = this.initialTalkListsAccounts;
  },
  beforeMount() {

  },
  mounted() {

  },
  beforeCreate() {

  },
  updated() {
 
  },
  beforeUpdate() {
  
  },
  methods: {
    userChangeParent(response) {
          this.talkDatas = response.data.talkArray.talkDatas;
          this.hisAccount = response.data.talkArray.hisAccount;
          this.errorExist = false;
          this.errorMessages = "";
          this.message = "";
          this.pageNumber = 1;
    },
    talkSendParent(response) {
          this.message = "";
          this.talkDatas = response.data.talkArray.talkDatas;
          this.talkListsAccounts = response.data.talkArray.talkListsAccounts;
          this.errorExist = false;
          this.errorMessages = "";
          this.pageNumber = 1;
    },
    talkSendParentError(error) {
          this.errorExist = true;
          this.errorMessages = error.response.data.errors.message;
          this.pageNumber = 1;
    },
    scrollTalkUpdateParent() {
        this.pageNumber++;

        let url = `/talk_users/${this.hisAccount.id}/contents/axios/talkUpdate?pageNumber=${this.pageNumber}`;
        axios
          .get(url)
          .then((response) => {
            this.talkDatas = response.data.talkArray.talkDatas;
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
