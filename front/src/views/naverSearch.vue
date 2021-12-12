<template>
  <v-container>
    <v-card>
      <v-form ref="form" v-model="valid" @submit.prevent="onSubmitForm">
        <v-text-field v-model="keword" />

        <v-btn type="submit">검색</v-btn>
      </v-form>
    </v-card>
    <v-card>
      <div class="font-bold text-red-400" v-html="title" />
    </v-card>
  </v-container>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      keword: "",
      valid: false,
      content: "",
      title: "",
    };
  },
  methods: {
    onSubmitForm() {
      if (this.$refs.form.validate()) {
        axios
          .post("/naverSearch", {
            keword: this.keword,
          })
          .then((res) => {
            console.log(res.data);
            // console.log(res.data);
            const page = res.data.substring(res.data.indexOf("<?xml"));

            var oParser = new DOMParser();
            var oDOM = oParser.parseFromString(page, "text/xml");
            console.log(oDOM);
            // console.log(oDOM.getElementsByTagName("item")[0].innerHTML);
            let children = oDOM.getElementsByTagName("item")[0].childNodes;
            for (let i = 0; i < children.length; i++) {
              console.log(children[i].nodeName);
              if (children[i].nodeName == "title") {
                this.title = children[i].childNodes[0].nodeValue;
              }
              console.log(children[i].childNodes[0].nodeValue);
            }
            // this.title = oDOM
            //   .getElementsByTagName("item")[0]
            //   .getElementsByTagName("title")[0].innerText;
          })
          .catch((err) => {
            console.log(err);
          });
      }
    },
  },
};
</script>