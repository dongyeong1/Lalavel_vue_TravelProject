<template>
  <v-container>
    <v-form
      ref="form"
      v-model="valid"
      @submit.prevent="onSubmitForm"
      @keyup.enter="onSubmitForm"
    >
      <v-card-text>
        <div><h3>일본어</h3></div>
        <v-text-field
          :rules="titleRules"
          placeholder="번역할것을 입력해"
          style="width: 500px"
          v-model="lang"
        >
        </v-text-field>
      </v-card-text>
      <v-btn primary type="submit"> 등록 </v-btn>
    </v-form>
    <div v-if="tranced">
      {{ tranced }}
    </div>
  </v-container>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      tranced: "",
      lang: "",
    };
  },
  methods: {
    onSubmitForm() {
      axios
        .post("/trance", {
          lang: this.lang,
        })
        .then((res) => {
          this.tranced = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>