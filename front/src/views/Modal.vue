<template>
  <v-row justify="left" class="mt-3">
    <v-dialog v-model="dialog" width="600px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="primary" dark v-bind="attrs" v-on="on"> 수정하기 </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="text-h5">수정하기</span>
        </v-card-title>
        <v-card-text>
          <div class="originImage" v-if="this.img">
            <v-img :src="imagePath + this.img"> </v-img>
          </div>

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

          제목:<v-text-field
            v-model="updatedContent"
            placeholder="제목을 입력해주세요"
          >
          </v-text-field>
          내용:<v-text-field
            v-model="updatedTitle"
            placeholder="내용을 입력해주세요"
          >
          </v-text-field>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="dialog = false">
            취소하기
          </v-btn>
          <v-btn color="green darken-1" text @click="update()">
            수정하기
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
import axios from "axios";
export default {
  props: ["contentId", "img"],
  data() {
    return {
      imagePath: "http://localhost:8000/storage/image/",
      updatedTitle: "",
      updatedContent: "",
      dialog: false,
      deleteImage: "",
      imageFile: "",
      image: "",
    };
  },
  methods: {
    update() {
      const form = new FormData();
      form.append("updatedContent", this.updatedContent);
      form.append("updatedTitle", this.updatedTitle);
      form.append("contentId", this.contentId);
      form.append("imageFile", this.imageFile);
      form.append("deleteImage", this.deleteImage);
      axios
        .post("/update", form)
        .then(() => {
          this.dialog = false;
          this.$emit("updated");
        })
        .catch((err) => {
          console.log(err);
        });
    },
    onFileChange(e) {
      // console.log(this.productImage);
      this.deleteImage = this.img;
      this.img = null;
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
};
</script>

<style scoped>
.originImage {
  width: 20%;
}
.product-image {
  width: 20%;
}
</style>