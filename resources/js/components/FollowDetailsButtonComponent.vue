<template>
  <div class="profile-button">
    <div v-if="followCheck">
      <div v-if="identifyIdCheck" class="profile-button-talk">
        <button class="profile-button-talk-button" @click="talkShow(userId)">
          メッセージ
        </button>
      </div>
    </div>

    <div class="profile-button-follow">
      <button
        type="button"
        v-if="followCheck"
        class="profile-button-follow-input onfollow"
        @click="unfollow(userId)"
      >
        フォロー中
      </button>
      <button v-else type="button" class="profile-button-follow-input notfollow" @click="follow(userId)">
        フォローする
      </button>
    </div>
  </div>
</template>

<script>
// import { defineComponent } from '@vue/composition-api'



export default {
  props: {
    userId: {
      required: true,
    },
    initialFollowCheck: {
      type: Boolean,
      required: true,
    },
    identifyId: {
      type: String,
      required: true,
    },
    eraId: {
      required: false,
    },
    teamString: {
      required: false,
    },
  },
  data() {
    return {
      followCheck: null,
      // 後でここのfollowCheckを変えるそもそものもらう値を変える。
    };
  },
  computed: {
    identifyIdCheck: function() {
      return this.identifyId == 'find' || this.identifyId == 'activity'|| this.identifyId == 'friend_follow' || this.identifyId == 'friend_follower';
    },
  
  },
  created() {
    this.followCheck = this.initialFollowCheck;
  },
  methods: {
    follow(userId) {
      let follow = `/follows`;
      axios
        .post(follow, {
          user_id: userId,
        })
        .then((response) => {
          this.followCheck = true;
        })
        .catch((error) => {
          alert(error);
        });
    },
    unfollow(userId) {
      let unfollow = `/follows/${userId}`;
      axios
        .delete(unfollow, {
          // userId: userId,多分要らないこれ
        })
        .then((response) => {
          this.followCheck = false;
        })
        .catch((error) => {
          alert(error);
        });
    },
    talkShow(userId) {
      // findかどうかを条件分岐してそれぞれの渡す値の配列を作る
      if (this.initialIdentifyId == "find" || "talk_find") {
        let url = `/talk_users/${userId}/contents?`
         + 'identify_id=' + this.identifyId
         + '&era_id=' + this.eraId
         + '&team_string=' + this.teamString;
        window.location.href = url;
      } else {
        let url = `/talk_users/${userId}/contents?`
         + 'identify_id=' + this.identifyId;
        window.location.href = url;
      }

        // window.location.href = url;
      // talk_usersContentsへリダイレクトする
      // window.location.href = '/search?q=' + this.searchData;
    },
  },
};
</script>

<style scoped>
/* .notfollow {
   background-color: red;

 } */
</style>