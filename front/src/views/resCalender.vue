<template>
  <v-container fluid>
    <v-row no-gutter>
      <v-col cols="4">
        <div id="btnqqq">
          <div id="posss"><h3>위치</h3></div>
          <KakaoMap
            id="map"
            ref="kmap"
            class="kmap"
            :options="mapOption"
            :style="{ width: '350px', height: '400px' }"
          >
          </KakaoMap>
          <star-chart :width="300" :height="300"></star-chart>
        </div>
      </v-col>

      <v-col cols="8">
        <v-row>
          <v-col v-for="(card, v) in calData" :key="v" :cols="6">
            <v-card>
              <v-img
                @click="search(threekm[card].address)"
                :src="imagePath + threekm[card].image"
                class="white--text align-end"
                gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                height="200px"
              >
              </v-img>
              <v-card-title v-text="threekm[card].title"></v-card-title>
              <v-card-content
                v-text="'거리:' + Math.round(card * 10) / 10 + 'km'"
              ></v-card-content
              ><br />
              <v-card-content
                v-text="'가격:' + threekm[card].pay + '원'"
              ></v-card-content>

              <v-card-actions>
                <v-spacer></v-spacer>

                <v-btn @click="goto(threekm[card])"> 예약하기 </v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-col>
      <v-pagination
        v-model="curPageNum"
        :length="numOfPages"
        circle
      ></v-pagination>
    </v-row>
  </v-container>
</template>


<script>
import StarChart from "./starChart.vue";
import axios from "axios";
import KakaoMap from "./kakaoMap.vue";
// import MarkerHandler from "./marker-handler";
export default {
  props: ["dong"],

  components: {
    StarChart,
    KakaoMap,
  },
  computed: {
    startOffset() {
      return (this.curPageNum - 1) * this.dataPerPage;
    },
    endOffset() {
      return this.startOffset + this.dataPerPage;
    },
    numOfPages() {
      return Math.ceil(this.three.length / this.dataPerPage);
    },
    calData() {
      return this.three.slice(this.startOffset, this.endOffset);
    },
  },

  mounted() {
    this.houseLoad();

    console.log("place", this.dong);

    console.log("???", this.houses);
  },
  data() {
    return {
      dataPerPage: 10,
      curPageNum: 1,
      page: 1,
      like: false,

      hearts: [],
      imagePath: "http://localhost:8000/storage/image/",
      houses: [],
      threekm: {},
      starHouse: [],
      three: [],
      one: [],
      two: [],

      markers: [],
      x: "",
      y: "",
      mapOption: {
        center: {
          lat: this.dong.lat,
          lng: this.dong.lng,
        },
        level: 8,
      },
      kmCards: [],
      cardAddress: [],
    };
  },
  methods: {
    heartcheck(houseNum) {
      console.log(this.hearts, "시발라라라라ㅏㄹ");
      for (var i = 0; i < this.hearts.length; i++) {
        if (this.hearts[i].house_id == houseNum) {
          return true;
        } else {
          return false;
        }
      }
    },

    goto(card) {
      console.log("card", card);
      this.$router.push({
        name: "/resHouse",
        params: { card: card },
      });
    },

    houseLoad() {
      axios
        .post("/loadHouse", {})
        .then((res) => {
          this.houses = res.data;
          console.log("hhhhhhhhhhhhhhhhhhqwe", res);
          for (var i = 0; i < this.houses.length; i++) {
            this.cardAddress.push(this.houses[i].address);
            console.log(i);
          }
          this.markLoad();
          this.card();
        })
        .catch((err) => {
          console.log(err);
        });
    },
    card() {
      console.log("card");
      var geocoder = new window.kakao.maps.services.Geocoder();
      var vm = this;
      this.cardAddress.forEach(function (addr, index) {
        geocoder.addressSearch(addr, function (result, status) {
          if (status === window.kakao.maps.services.Status.OK) {
            var kms = vm.Km(vm.dong.lat, vm.dong.lng, result[0].y, result[0].x);
            //   console.log("thenindex", i);
            if (kms < 30) {
              vm.threekm[kms] = vm.houses[index];
              vm.starHouse.push(vm.houses[index]);

              vm.three.push(kms);

              vm.three.sort(function (a, b) {
                return a - b;
              });
            }
          }
        });
      });

      console.log("fffffffffffffffft", vm.threekm);
      console.log("kkkkkkkkkkkkkkkkkkk", vm.three);
    },
    Km(a, b, c, d) {
      var x = b - d;
      var x2 =
        Math.sin(this.deg2rad(a)) * Math.sin(this.deg2rad(c)) +
        Math.cos(this.deg2rad(a)) *
          Math.cos(this.deg2rad(c)) *
          Math.cos(this.deg2rad(x));

      var x3 = Math.acos(x2);
      var x4 = this.rad2deg(x3);
      var x5 = x4 * 60 * 1.1515 * 1.609344;

      console.log("km", x5);
      return x5;
    },
    deg2rad(x) {
      return (x * Math.PI) / 180.0;
    },
    rad2deg(x) {
      return (x * 180) / Math.PI;
    },
    addressSearchs() {
      //   console.log("ssssssssssssssssss", address);
      var geocoder = new window.kakao.maps.services.Geocoder();
      var abcd = "aaa";
      geocoder.addressSearch("부산 연제구 연산동 1000", (result, status) => {
        if (status === window.kakao.maps.services.Status.OK) {
          console.log("result", result[0].x);

          console.log("results", abcd);
          abcd = result[0].x;
          console.log("sssresults", abcd);

          //   return addressXY;
        }
      });
      return abcd;
    },

    search(address) {
      console.log("ddd");
      var geocoder = new window.kakao.maps.services.Geocoder();
      const vm = this;
      geocoder.addressSearch(address, function (result, status) {
        if (status === window.kakao.maps.services.Status.OK) {
          console.log("asdasd");
          console.log("y", result[0].y, result[0].x);
          vm.x = result[0].x;
          vm.y = result[0].y;
          console.log("d");
          console.log("x", vm.x, "y", vm.y);
          var mapContainer = document.getElementById("map");
          var mapOption = {
            center: new window.kakao.maps.LatLng(vm.y, vm.x),
            level: 5,
          };
          var markerPosition = new window.kakao.maps.LatLng(vm.y, vm.x);
          var map = new window.kakao.maps.Map(mapContainer, mapOption);
          console.log("center", map.getCenter());
          var marker = new window.kakao.maps.Marker({
            position: markerPosition,
          });
          vm.markers.push(marker);
          for (var i = 0; i < 2; i++) {
            console.log("maaaaa", i);
            vm.markers[i].setMap(map);
          }
          vm.markers.pop();
          //   marker.setMap(map);
          return vm.x, vm.y;
        }
      });
    },
    con() {
      console.log("do");
      var mapContainer = document.getElementById("map");
      var mapOption = {
        center: new window.kakao.maps.LatLng(
          33.24127212174994,
          126.59230607000688
        ),
        level: 5,
      };
      var markerPosition = new window.kakao.maps.LatLng(
        33.24127212174994,
        126.59230607000688
      );
      var map = new window.kakao.maps.Map(mapContainer, mapOption);
      var marker = new window.kakao.maps.Marker({
        position: markerPosition,
      });
      marker.setMap(map);
    },
    markLoad() {
      //   console.log("asd");
      //   console.log("makload");
      console.log("mark", this.x, this.y);
      var mapContainer = document.getElementById("map");
      var mapOption = {
        center: new window.kakao.maps.LatLng(this.dong.lat, this.dong.lng),
        level: 5,
      };
      var markerPosition = new window.kakao.maps.LatLng(
        this.dong.lat,
        this.dong.lng
      );
      var map = new window.kakao.maps.Map(mapContainer, mapOption);
      var marker = new window.kakao.maps.Marker({
        position: markerPosition,
      });
      this.markers.push(marker);
      console.log("111111111");
      marker.setMap(map);
    },
  },
};
</script>

<style>
#map {
  width: 500px;
  height: 500px;
}
#btnqqq {
  display: inline-block;
  position: sticky;
  width: 50px;
  height: 50px;
  top: 30px;
}
#posss {
  width: 100px;
  height: 40px;
}
</style>