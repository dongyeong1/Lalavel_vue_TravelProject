<template>
  <v-container>
    <v-card>
      <v-card-title>게시물작성</v-card-title>
      <v-form ref="form" v-model="valid" @submit.prevent="onSubmitForm">
        <button type="button" @click="showApi">주소</button>

        <v-card-text>
          <div><h3>*이미지업로드</h3></div>
          <br />

          <div v-if="!image">
            <v-row>
              <v-col cols="6">
                <input
                  ref="productImage"
                  type="file"
                  @change="onFileChange"
                  name="imgfile"
                  enctype="multipart/form-data"
                />
              </v-col>
            </v-row>
          </div>
          <div v-else>
            <div class="product-image">
              <v-img :src="image" />
            </div>
            <button type="button" @click="removeImage">Remove image</button>
          </div>
          <div><h3>제목</h3></div>
          <v-text-field
            :rules="titleRules"
            placeholder="제목을 입력해주세요"
            style="width: 500px"
            v-model="title"
          >
          </v-text-field>
        </v-card-text>
        <v-card-text>
          <div><h3>내용</h3></div>
          <v-text-field
            :rules="contentRules"
            placeholder="내용을 입력해주세요"
            style="width: 500px"
            v-model="content"
          >
          </v-text-field>
        </v-card-text>
        <v-btn primary type="submit"> 등록 </v-btn>
      </v-form>
    </v-card>

    <v-row class="mt-3">
      <v-col v-for="content in contents" :key="content" cols="12">
        <v-card :key="content" class="pa-3">
          <v-img class="img" :src="imagePath + content.image"></v-img>
          사용자:{{ content.user.name }}<br />
          제목:{{ content.title }}<br />
          내용:{{ content.content }}<br />

          <v-icon @click="deletes(content.id)">mdi-delete</v-icon>
          <modal
            :contentId="content.id"
            v-on:updated="getContent"
            :img="content.image"
          />
        </v-card>
      </v-col>
    </v-row>
    <div v-for="data in datas" :key="data.id">
      {{ data.country_nm }}
      <img :src="`${data.download_url}`" alt="" :width="100" />
    </div>
  </v-container>
</template>

<script>
import Modal from "./Modal.vue";
import axios from "axios";
export default {
  components: {
    Modal,
  },
  data() {
    return {
      imagePath: "http://localhost:8000/storage/image/",
      imageFile: "",
      image: "",
      updatedTitle: "",
      updatedContent: "",
      contents: [],
      valid: false,
      title: "",
      content: "",
      datas: [],

      titleRules: [(v) => !!v || "제목은 필수입니다."],
      contentRules: [(v) => !!v || "내용은 필수입니다."],
    };
  },
  methods: {
    showApi() {
      new window.daum.Postcode({
        oncomplete: (data) => {
          let fullRoadAddr = data.roadAddress;
          let extraRoadAddr = "";
          if (data.bname !== "" && /[동|로|가]$/g.test(data.bname)) {
            extraRoadAddr += data.bname;
          }
          if (data.buildingName !== "" && data.apartment === "Y") {
            extraRoadAddr +=
              extraRoadAddr !== ""
                ? ", " + data.buildingName
                : data.buildingName;
          }
          if (extraRoadAddr !== "") {
            extraRoadAddr = " (" + extraRoadAddr + ")";
          }
          if (fullRoadAddr !== "") {
            fullRoadAddr += extraRoadAddr;
          }

          console.log(data.zonecode);
          console.log(fullRoadAddr);
        },
      }).open();
    },
    deletes(contentId) {
      if (confirm("진짜삭제할꺼야?")) {
        this.postDelete(contentId);
      }
    },
    postDelete(contentId) {
      axios
        .post("/delete", {
          contentId,
        })
        .then((res) => {
          console.log(res);
          alert("삭제완료");
          this.getContent();
        })
        .catch((err) => {
          console.log(err);
        });
    },
    onSubmitForm() {
      if (this.$refs.form.validate()) {
        const form = new FormData();
        form.append("title", this.title);
        form.append("content", this.content);
        form.append("imageFile", this.imageFile);
        axios
          .post("/create", form)
          .then((res) => {
            alert("게시물 등록성공");
            this.getContent();
            console.log(res);
          })
          .catch((err) => {
            console.log(err);
          });
      }
    },
    getContent() {
      axios
        .get("/get")
        .then((res) => {
          this.contents = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    onFileChange(e) {
      // console.log(this.productImage);
      console.log(this.$refs.productImage.files);
      this.imageFile = this.$refs.productImage.files[0];
      console.log("imagefile" + this.imageFile);
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);
    },
    createImage(file) {
      var reader = new FileReader();
      var vm = this;
      reader.readAsDataURL(file);
      reader.onload = (e) => {
        console.log(e.target.result);
        vm.image = e.target.result;
      };
      // const aa =
      // reader.readAsText(file);
      console.log("asdasdad");
      // console.log(aa + "동영");
    },
    removeImage: function () {
      this.image = "";
    },
  },
  created() {
    this.getContent();
    axios
      .get(
        "http://apis.data.go.kr/1262000/CountryMapService2/getCountryMapList2?serviceKey=U%2BoVvJTdthQBv4qekw0vLAuP0DUZd5IP7e8IbfcVUj0525%2FSzCtvxNvTj0blxDIxrE1SMKxQsLuk1GMlVtk0ig%3D%3D"
      )
      .then((res) => {
        console.log(res.data);
        this.datas = res.data.data;
      })
      .catch((err) => {
        console.log(err);
      });
  },
};
</script>

<style scoped>
.product-image {
  width: 20%;
}
.img {
  width: 20%;
}
</style>