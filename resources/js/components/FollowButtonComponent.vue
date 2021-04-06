<template>
  <div>
      <p>aaajdkajkflsjaskl</p>
      <p>aaajdkajkflsjaskl</p>
      <p>aaajdkajkflsjaskl</p>
      <p>aaajdkajkflsjaskl</p>
      <p>aaajdkajkflsjaskl</p>
  </div>
</template>

<script>
// import { defineComponent } from '@vue/composition-api'

export default {
  props: {
    userId: {
      required: true,
    },
    followCheck: {
      type: Boolean,
      required: true,
    },
  },
  data: function () {
    return {
      followOrNot: false,
    };
  },
  created() {
    this.followOrNot = this.followCheck;
  },
  methods: {
    follow(userId) {
      let follow = `/follows`;
      axios
        .post(follow, {
          user_id: userId,
        })
        .then((response) => {
          this.followOrNot = true;
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
          this.followOrNot = false;
        })
        .catch((error) => {
          alert(error);
        });
    },
  },
};
</script>
