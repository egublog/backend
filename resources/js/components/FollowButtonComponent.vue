<template>
  <div>
    <button
      type="button"
      v-if="followCheck"
      class="onfollow"
      @click="unfollow(userId)"
    >
      フォロー中
    </button>
    <button v-else type="button" class="notfollow" @click="follow(userId)">
      フォローする
    </button>
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
      type: '',
      required: true,
    },
  },
  data() {
    return {
      followCheck: false,
    };
  },
  created() {
    this.followCheck = this.initialFollowCheck;
    // あああああ
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
          // console.log(response);
        })
        .catch((error) => {
          alert(error);
        });
    },
    unfollow(userId) {
      let unfollow = `/follows/${userId}`;
      axios
        .delete(unfollow, {
          userId: userId,
        })
        .then((response) => {
          this.followCheck = false;
        })
        .catch((error) => {
          alert(error);
        });
    },
  },
};
</script>

<style scoped>
/* .notfollow {
   background-color: red;

 } */
</style>