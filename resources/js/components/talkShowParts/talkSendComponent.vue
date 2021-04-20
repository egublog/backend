<template>
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
              :value="message"
              @input="$emit('textarea-update', $event.target.value)"
              name="inputMessage"
              id="message"
              placeholder="メッセージを入力"
            ></textarea>
            <div class="talk-send-button">
              <!-- <input class="" type="submit" value="送信"> -->
              <button v-on:click="talkSend()">送信</button>
            </div>
          </div>
        </div>
</template>

<script>
// import { defineComponent } from '@vue/composition-api'

export default {
  props: {
    message: {
      required: true,
    },
    hisAccount: {
      required: true,
    },
     identifyId: {
      required: true,
    },
  },
  data: function () {
    return {
      talkSendDatas: "",
    };
  },
  computed: {

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
   talkSend() {
      let url = `/talk_users/${this.hisAccount.id}/contents`;

        this.talkSendDatas = {
          message: this.message,
          identify_id: this.identifyId,
        };
  
      axios
        .post(url, this.talkSendDatas)
        .then((response) => {
          this.$emit("talk-send-parent", response);
        })
        .catch((error) => {
          this.$emit("talk-send-parent-error", error);
        });
    },
  },
};
</script>
