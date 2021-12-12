<template>
  <v-container>
    <v-row>
      <v-col cols="6">
        <v-row>
          <h3>등록한숙소List</h3>
          <v-col cols="6" v-for="(house, v) in calData" :key="v">
            <v-card @click="gotoRes(house)">
              <v-img
                :src="imagePath + house.image"
                class="white--text align-end"
                gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                height="200px"
              />

              <v-card-title>{{ house.title }}</v-card-title>
              <v-spacer></v-spacer>

              <v-btn @click="houseDelete(house.id)">삭제하기 </v-btn>
              <v-btn @click="update(house)">수정하기</v-btn>
            </v-card>
          </v-col>
          <v-pagination
            v-model="curPageNum"
            :length="numOfPages"
            circle
          ></v-pagination>
        </v-row>
      </v-col>
      <v-col cols="6">
        <h3>예약한사용자</h3>
        <v-card><reserve-calender></reserve-calender></v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import axios from "axios";
import ReserveCalender from "./masterCalendar";
export default {
  components: {
    ReserveCalender,
  },
  data() {
    return {
      houses: [],
      imagePath: "http://localhost:8000/storage/image/",
      dataPerPage: 4,
      curPageNum: 1,
      page: 1,
    };
  },
  computed: {
    startOffset() {
      return (this.curPageNum - 1) * this.dataPerPage;
    },
    endOffset() {
      return this.startOffset + this.dataPerPage;
    },
    numOfPages() {
      return Math.ceil(this.houses.length / this.dataPerPage);
    },
    calData() {
      return this.houses.slice(this.startOffset, this.endOffset);
    },
  },

  mounted() {
    axios
      .post("/masterHouseUpload", {
        userId: this.$store.state.user.user.id,
      })
      .then((res) => {
        console.log(res.data);
        this.houses = res.data;
      })
      .catch((err) => {
        console.log(err);
      });
  },
  methods: {
    houseDelete(houseId) {
      if (confirm("삭제하시겠습니까?")) {
        axios
          .post("/houseDelete", {
            houseId,
          })
          .then(() => {
            alert("삭제완료");
            location.reload();
          })
          .catch((err) => {
            console.log(err);
          });
      }
    },
    update(house) {
      this.$router.push({
        name: "/masterHouseUpdate",
        params: { house: house },
      });
    },
    gotoRes(house) {
      this.$router.push({
        name: "/resHouse",
        params: { card: house },
      });
    },
  },
};
</script>

<style>
</style>