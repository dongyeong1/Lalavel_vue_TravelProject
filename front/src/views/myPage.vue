<template>
  <v-container>
    <v-row>
      <v-col cols="6">
        <div id="profilecolors">
          <div id="profile">
            <img
              src="https://i.ibb.co/B3k89LJ/profile-2092113-960-720.png"
              alt=""
              width="100px"
              height="100px"
              style="border-radius: 80%"
            />

            <h3>이름:{{ this.$store.state.user.user.name }}</h3>
            <h3>이메일:{{ this.$store.state.user.user.email }}</h3>
            <h3>사용가능포인트:{{ point }}</h3>
          </div>
        </div>
      </v-col>
      <v-col cols="6">
        <v-card> <reserve-calender></reserve-calender> </v-card>
      </v-col>
      <v-row>
        <v-col cols="6">
          <v-card>
            <div>
              <svg
                aria-label="좋아요"
                class="_8-yf5"
                color="#ed4956"
                fill="#ed4956"
                height="30"
                role="img"
                viewBox="0 0 48 48"
                width="30"
              >
                <path
                  d="M34.6 3.1c-4.5 0-7.9 1.8-10.6 5.6-2.7-3.7-6.1-5.5-10.6-5.5C6 3.1 0 9.6 0 17.6c0 7.3 5.4 12 10.6 16.5.6.5 1.3 1.1 1.9 1.7l2.3 2c4.4 3.9 6.6 5.9 7.6 6.5.5.3 1.1.5 1.6.5s1.1-.2 1.6-.5c1-.6 2.8-2.2 7.8-6.8l2-1.8c.7-.6 1.3-1.2 2-1.7C42.7 29.6 48 25 48 17.6c0-8-6-14.5-13.4-14.5z"
                ></path></svg
              >찜한목록
            </div>
            <v-row>
              <v-col cols="6" v-for="(house, v) in houses" :key="v">
                <v-card>
                  <v-img
                    :src="imagePath + house.houses.image"
                    class="white--text align-end"
                    gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                    height="200px"
                  />

                  {{ house.houses.title }}
                </v-card>
              </v-col>
            </v-row>
          </v-card>
        </v-col>

        <v-col cols="6">
          <v-card>
            <div><v-icon> mdi-home-city </v-icon>예약목록</div>
            <v-row>
              <v-col cols="6" v-for="(house, v) in reservedHouse" :key="v">
                <v-card @click="gotoRes(house.houses)">
                  <v-img
                    :src="imagePath + house.houses.image"
                    class="white--text align-end"
                    gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                    height="200px"
                  />

                  {{ house.houses.title }}
                </v-card>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
      </v-row>
    </v-row>
  </v-container>
</template>

<script>
import axios from "axios";
import ReserveCalender from "./userCalendar";
export default {
  components: {
    ReserveCalender,
  },
  data() {
    return {
      point: 0,
      imagePath: "http://localhost:8000/storage/image/",
      houses: [],
      reservedHouse: [],
    };
  },
  mounted() {
    axios
      .post("/loadPoint", {
        userId: this.$store.state.user.user.id,
      })
      .then((res) => {
        this.point = res.data;
      })
      .catch((err) => {
        console.log(err);
      });
    this.userHeartLoad();
    this.userHouseUploads();
  },
  methods: {
    userHouseUploads() {
      axios
        .post("/userreservedUploads", {
          userId: this.$store.state.user.user.id,
        })
        .then((res) => {
          console.log("reserveddddddddddddddddddd", res.data);
          this.reservedHouse = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    gotoRes(house) {
      console.log("yyyyyyyyyyyyyyyyyy", house);
      this.$router.push({
        name: "/resHouse",
        params: { card: house },
      });
    },
    userHeartLoad() {
      axios
        .post("/userHeartLoad", {
          userId: this.$store.state.user.user.id,
        })
        .then((res) => {
          this.houses = res.data;
          console.log("qqqqqqqqqqqqqqq", this.$store.state.user.user.id);
          console.log("aaaaaaaaaaaa", res.data);
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>

<style>
#profilecolors {
  width: 400px;
  height: 400px;
  background-color: forestgreen;
  opacity: 90%;
  border-radius: 70%;
  margin-left: 100px;
  margin-bottom: 100px;
}
#profile {
  color: white;
  width: 300px;
  height: 300px;
  margin-left: 80px;
  margin-top: 130px;
}
</style>