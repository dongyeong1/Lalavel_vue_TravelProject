<template>
  <v-container>
    <div>
      <v-row>
        <div><h1>검색List</h1></div>
        <v-col cols="6" v-for="(house, v) in calData" :key="v">
          <v-card>
            <v-img
              :src="imagePath + house.image"
              class="white--text align-end"
              gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
              height="200px"
            />

            <v-card-title>{{ house.title }}</v-card-title>
            <v-card-content v-text="'주소:' + house.address"></v-card-content>
            <br />
            <v-card-content
              v-text="'가격:' + house.pay + '원'"
            ></v-card-content>
            <v-card-actions>
              <v-spacer></v-spacer>

              <v-btn @click="goToReserve(house)"> 예약하기 </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
        <v-pagination
          v-model="curPageNum"
          :length="numOfPages"
          circle
        ></v-pagination>
      </v-row>
    </div>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      dataPerPage: 10,
      curPageNum: 1,
      imagePath: "http://localhost:8000/storage/image/",
      userDay: [],
      houses: [],
    };
  },
  props: ["searchResult", "startDay", "endDay"],
  computed: {
    startOffset() {
      return (this.curPageNum - 1) * this.dataPerPage;
    },
    endOffset() {
      return this.startOffset + this.dataPerPage;
    },
    numOfPages() {
      return Math.ceil(this.searchResult.length / this.dataPerPage);
    },
    calData() {
      return this.searchResult.slice(this.startOffset, this.endOffset);
    },
  },
  mounted() {
    console.log(this.searchResult);
    console.log(this.startDay);
    console.log(this.endDay);
    this.userDay = this.getDatesStartToLast(this.startDay, this.endDay);

    console.log(this.getDatesStartToLast(this.startDay, this.endDay));
    this.houseLoad();
  },
  methods: {
    houseLoad() {
      for (var i = 0; i < this.searchResult.length; i++) {
        var count = 0;
        for (var k = 0; k < this.searchResult[i].reserveds.length; k++) {
          var arr = this.getDatesStartToLast(
            this.searchResult[i].reserveds[k].start_day,
            this.searchResult[i].reserveds[k].end_day
          );
          console.log("rrrrrrrrrrrrrrrrrrrrr", arr);
          let arrrr = this.userDay.filter((x) => arr.includes(x));
          count += 1;
          if (arrrr.length > 0) {
            break;
          } else {
            if (count == this.searchResult[i].reserveds.length) {
              this.houses.push(this.searchResult[i]);
            }
            continue;
          }
        }
        count = 0;
      }
      console.log("asssssssssss", this.houses);
    },
    getDatesStartToLast(startDate, lastDate) {
      var regex = RegExp(/^\d{4}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/);
      if (!(regex.test(startDate) && regex.test(lastDate)))
        return "Not Date Format";
      var result = [];
      var curDate = new Date(startDate);
      while (curDate <= new Date(lastDate)) {
        result.push(curDate.toISOString().split("T")[0]);
        curDate.setDate(curDate.getDate() + 1);
      }
      return result;
    },
    goToReserve(house) {
      this.$router.push({
        name: "/resHouse",
        params: {
          card: house,
        },
      });
    },
  },
};
</script>