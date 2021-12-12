<template>
  <v-container>
    <v-card>
      <v-card-title> 수정하기 </v-card-title>
      <v-form ref="form" v-model="valid" @submit.prevent="onUpdate">
        <v-card-text>
          <br />

          <div v-if="!image">
            <v-row>
              <v-img :src="imagePath + house.image" />

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
            <div style="width: 200">
              <img :src="image" />
            </div>
            <button type="button" @click="removeImage">Remove image</button>
          </div>
        </v-card-text>

        <hr />

        <v-card-text>
          <div><h3>*숙소이름</h3></div>
          <v-text-field
            :placeholder="house.title"
            style="width: 500px"
            v-model="houseName"
          >
          </v-text-field>
        </v-card-text>
        <hr />

        <v-card-text>
          <div><h3>*숙소설명</h3></div>
          <v-textarea
            outlined
            auto-grow
            clearable
            v-model="content"
            :placeholder="house.description"
          />
        </v-card-text>
        <hr />

        <v-card-text>
          <button @click="showApi"><h3>*숙소주소</h3></button>

          <v-text-field
            :value="this.address"
            :placeholder="house.address"
            style="width: 500px"
            v-model="address"
          >
          </v-text-field>
        </v-card-text>
        <hr />

        <v-card-text>
          <div><h3>*가격</h3></div>
          <v-text-field
            :placeholder="house.pay"
            v-model="price"
            style="width: 200px"
          />
        </v-card-text>
        <hr />

        <v-card-text>
          <div><h3>*숙소최대인원</h3></div>
          <v-text-field
            :placeholder="house.peoplenumber"
            v-model="peopleNumber"
            style="width: 200px"
          />
        </v-card-text>
        <hr />

        <v-card-text>
          <div><h3>*흡연</h3></div>
          <p>이전값:{{ house.smoking }}</p>
          <v-checkbox v-model="smoking" label="가능" value="가능"> </v-checkbox>
          <v-checkbox v-model="smoking" label="금지" value="금지"> </v-checkbox>
        </v-card-text>
        <hr />

        <v-card-text>
          <div><h3>*애완동물</h3></div>
          <p>이전값:{{ house.pet }}</p>
          <v-checkbox v-model="pet" label="가능" value="가능"> </v-checkbox>
          <v-checkbox v-model="pet" label="금지" value="금지"> </v-checkbox>
        </v-card-text>
        <hr />

        <v-card-text>
          <div><h3>*와이파이</h3></div>
          <p>이전값:{{ house.wifi }}</p>
          <v-checkbox v-model="wifi" label="가능" value="가능"> </v-checkbox>
          <v-checkbox v-model="wifi" label="금지" value="금지"> </v-checkbox>
        </v-card-text>
        <hr />

        <v-card-text>
          <div><h3>*주차</h3></div>
          <p>이전값:{{ house.parking }}</p>
          <v-checkbox v-model="parking" label="가능" value="가능"> </v-checkbox>
          <v-checkbox v-model="parking" label="금지" value="금지"> </v-checkbox>
        </v-card-text>
        <hr />

        <v-btn color="green darken-1" type="submit">수정 </v-btn>
      </v-form>
    </v-card>
  </v-container>
</template>

<script>
import axios from "axios";
export default {
  props: ["house"],
  data() {
    return {
      imagePath: "http://localhost:8000/storage/image/",
      peopleNumber: this.house.peoplenumber,
      address: this.house.address,
      image: "",

      valid: false,
      houseName: this.house.title,
      content: this.house.description,
      price: this.house.pay,
      pet: this.house.pet,
      smoking: this.house.smoking,
      parking: this.house.parking,
      wifi: this.house.wifi,
      productImage: this.house.image,
      imagess: "",
      houseNum: this.house.id,
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
          this.address = fullRoadAddr;
          console.log(data.zonecode);
          console.log(fullRoadAddr);
        },
      }).open();
    },
    onUpdate() {
      const form = new FormData();
      form.append("houseNum", this.houseNum);
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
      form.append("imagess", this.imagess);

      axios
        .post("/houseUpdate", form)
        .then(() => {
          alert("업데이트성공");
        })
        .catch((err) => {
          console.log(err);
        });
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
        vm.imagess = e.target.result;
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
  mounted() {
    console.log(this.house);
  },
};
</script>