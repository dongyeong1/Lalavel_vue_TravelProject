<template>
  <v-container>
    <v-card>
      <div id="con">
        <h1><v-icon large> mdi-home-city </v-icon>숙소등록</h1>
      </div>
      <hr />
      <v-form ref="form" v-model="valid" @submit.prevent="onsubmitForm">
        <v-row>
          <v-col cols="6">
            <v-card-text>
              <div><h3>*이미지업로드</h3></div>
              <br />

              <div v-if="!image">
                <v-row>
                  <v-col cols="6">
                    <div class="filebox">
                      <label for="ex_file">업로드</label>

                      <input
                        id="ex_file"
                        ref="productImage"
                        type="file"
                        @change="onFileChange"
                        name="imgfile"
                        enctype="multipart/form-data"
                      />
                    </div>
                  </v-col>
                </v-row>
              </div>
              <div v-else>
                <div style="width: 200">
                  <img :src="image" />
                </div>
                <button type="button" @click="removeImage">Remove image</button>
              </div>
            </v-card-text>
          </v-col>
          <v-col cols="6">
            <v-card-text>
              <div><h3>*숙소이름</h3></div>
              <v-text-field
                :rules="houseNameRules"
                placeholder="숙소이름을 입력해주세요"
                style="width: 500px"
                v-model="houseName"
              >
              </v-text-field>
            </v-card-text>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="6">
            <v-card-text>
              <div><h3>*숙소설명</h3></div>
              <v-textarea
                :rules="contentRules"
                outlined
                auto-grow
                clearable
                v-model="content"
              />
            </v-card-text>
          </v-col>
          <v-col cols="6">
            <h3>*숙소주소</h3>
            <v-card-text>
              <button @click="showApi">
                숙소검색<v-icon>mdi-magnify</v-icon>
              </button>

              <v-text-field
                :rules="addressRules"
                :value="this.address"
                :placeholder="this.address"
                style="width: 500px"
                v-model="address"
              >
              </v-text-field>
            </v-card-text>
          </v-col>
          <v-col cols="6">
            <v-card-text>
              <div><h3>*가격</h3></div>
              <v-text-field
                :rules="priceRules"
                placeholder="가격을 입력해주세요"
                v-model="price"
                style="width: 200px"
              />
            </v-card-text>
          </v-col>
          <v-col cols="6"
            ><v-card-text>
              <div><h3>*숙소최대인원</h3></div>
              <v-text-field
                :rules="peopleRules"
                placeholder="최대인원을 입력해주세요"
                v-model="peopleNumber"
                style="width: 200px"
              /> </v-card-text
          ></v-col>
        </v-row>

        <v-row>
          <v-col cols="3">
            <v-card-text>
              <div><h3>*흡연</h3></div>
              <p>{{ smoking }}</p>
              <v-checkbox v-model="smoking" label="가능" value="가능">
              </v-checkbox>
              <v-checkbox v-model="smoking" label="금지" value="금지">
              </v-checkbox>
            </v-card-text>
          </v-col>
          <v-col cols="3">
            <v-card-text>
              <div><h3>*애완동물</h3></div>

              <v-checkbox v-model="pet" label="가능" value="가능"> </v-checkbox>
              <v-checkbox v-model="pet" label="금지" value="금지"> </v-checkbox>
            </v-card-text>
          </v-col>
          <v-col cols="3">
            <v-card-text>
              <div><h3>*와이파이</h3></div>

              <v-checkbox v-model="wifi" label="가능" value="가능">
              </v-checkbox>
              <v-checkbox v-model="wifi" label="금지" value="금지">
              </v-checkbox>
            </v-card-text>
          </v-col>
          <v-col cols="3">
            <v-card-text>
              <div><h3>*주차</h3></div>

              <v-checkbox v-model="parking" label="가능" value="가능">
              </v-checkbox>
              <v-checkbox v-model="parking" label="금지" value="금지">
              </v-checkbox>
            </v-card-text>
          </v-col>
        </v-row>

        <v-btn id="btnssss" color="##088A08" type="submit">등록하기 </v-btn>
      </v-form>
    </v-card>
  </v-container>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      peopleNumber: "",
      address: "",
      colorCode: "",
      valid: false,
      productImage: "",
      image: "",
      houseName: "",
      content: "",
      price: "",
      pet: "",
      smoking: "",
      parking: "",
      wifi: "",
      dialog: false,
      dialogs: false,
      peopleRules: [(v) => !!v || "제한인원입력은 필수입니다"],
      addressRules: [(v) => !!v || "숙소주소는 필수입니다"],
      contentRules: [(v) => !!v || "숙소내용은 필수입니다"],
      houseNameRules: [(v) => !!v || "숙소이름은 필수입니다"],
      priceRules: [(v) => !!v || "가격은 필수입니다"],
    };
  },
  mounted() {
    this.colorCode = "#" + Math.round(Math.random() * 0xffffff).toString(16);
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
          this.address = fullRoadAddr;
          console.log(data.zonecode);
          console.log(fullRoadAddr);
        },
      }).open();
    },
    onsubmitForm() {
      if (this.$refs.form.validate()) {
        const form = new FormData();
        form.append("address", this.address);
        form.append("peopleNumber", this.peopleNumber);
        form.append("content", this.content);
        form.append("houseName", this.houseName);
        form.append("price", this.price);
        form.append("pet", this.pet);
        form.append("smoking", this.smoking);
        form.append("parking", this.parking);
        form.append("wifi", this.wifi);
        form.append("productImage", this.productImage);
        form.append("userId", this.$store.state.user.user.id);
        form.append("colorCode", this.colorCode);
        axios
          .post("/addHouse", form)
          .then((res) => {
            alert("숙소등록성공");
            console.log(res);
          })
          .catch((err) => {
            console.log(this.image + "sadasd");
            console.log(err);
          });
      }
    },
    onFileChange(e) {
      // console.log(this.productImage);
      console.log(this.$refs.productImage.files);
      this.productImage = this.$refs.productImage.files[0];
      console.log("asdsa");
      console.log(e.target.files);
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

<style >
#d {
  margin-left: 20px;
}

.text-center {
  margin-bottom: 50px;
}
#con {
  margin-left: 450px;
}
#btnssss {
  background-color: #2e64fe;
  margin-left: 500px;
  margin-top: 100px;
}
.filebox label {
  display: inline-block;
  padding: 0.5em 0.75em;
  color: #999;
  font-size: inherit;
  line-height: normal;
  vertical-align: middle;
  background-color: #fdfdfd;
  cursor: pointer;
  border: 1px solid #ebebeb;
  border-bottom-color: #e2e2e2;
  border-radius: 0.25em;
}
.filebox input[type="file"] {
  /* 파일 필드 숨기기 */
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  border: 0;
}
</style>
