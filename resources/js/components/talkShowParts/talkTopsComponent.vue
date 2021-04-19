<template>
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
</template>

<script>
// import { defineComponent } from '@vue/composition-api'

export default {
  props: {
    hisAccount: {
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
  },
  data: function () {
    return {
     
    
    };
  },
  computed: {
    returnTalkDatas: function () {
      return this.talkDatas;
    },
  },
  created() {
    
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
   
  },
};
</script>
