<template>
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
</template>

<script>
// import { defineComponent } from '@vue/composition-api'

export default {
  props: {
    talkListsAccounts: {
      required: true,
    },
    identifyId: {
      required: true,
    },
  },
  data: function () {
    return {
     
    };
  },
  computed: {
    // returnTalkDatas: function () {
    //   return this.talkDatas;
    // },
  },
  created() {
    console.log("TalkUsersのcreatedを通りました");
    
  },
  beforeMount() {

  },
  mounted() {
    console.log("TalkUsersのmountedを通りました");
    
  },
  beforeCreate() {
   
  },
  updated() {
    console.log("talkUsersのupdated");
    
  },
  beforeUpdate() {

  },
  methods: {
    userChange(userId) {
      let userChangeUrl = `/talk_users/${userId}/contents/axios/userChange`;
      axios
        .get(userChangeUrl)
        .then((response) => {
          // this.talkDatas = response.data.talkArray.talkDatas;
          // this.hisAccount = response.data.talkArray.hisAccount;
          // this.errorExist = false;
          // this.errorMessages = "";
          // this.message = "";
          // this.pageNumber = 1;
          this.$emit("usesr-change-parent", response);
        })
        .catch((error) => {
          alert(error);
        });
    },
  },
};
</script>
