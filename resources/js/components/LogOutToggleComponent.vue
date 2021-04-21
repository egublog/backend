<template>
 


 <!-- ログインのtoggle -->
  <div class="toggle">

      <button v-on:click="ifShow = !ifShow" class="toggle-button dropdown-toggle" href="#">
          {{ userName }}
      </button>

      <div v-if="ifShow" class="toggle-show dropdown-menu dropdown-menu-right">
          <button v-on:click="logout()" class="logout-button dropdown-item">
              Logout
          </button>

          <!-- <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form> -->
      </div>
  </div>

            <!-- ログインのtoggle -->



</template>

<script>
// import { defineComponent } from '@vue/composition-api'



export default {
  props: {
    userName: {
      required: true,
    },
  },
  data() {
    return {
      // 後でここのfollowCheckを変えるそもそものもらう値を変える。
      ifShow: false,
    };
  },
  computed: {
    
  },
  created() {
    // let url = `/axios/userName`;
    //   axios
    //     .get(url)
    //     .then((response) => {
    //       this.userName = response.data.userName;
    //     })
    //     .catch((error) => {
    //       alert(error);
    //     });
  },
  methods: {
     logout() {
     
        let url = '/axios/logout';

        console.log(url);
  
        axios
        .post(url)
        .then((response) => {
          console.log('logout!');
          window.location.href = '/'
        })
        .catch((error) => {
          alert(error);
          console.log(url);
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