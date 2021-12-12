<template>
  <div>
    <div id="a">
      <div id="back">
        <div id="text"><h1 style="font-size: 7em">welcome!!</h1></div>
        <section class="search-sec">
          <div class="container">
            <form action="#" method="post" novalidate="novalidate">
              <div class="row">
                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                      <input
                        type="text"
                        class="form-control search-slt"
                        placeholder="숙소이름을 입력해주세요"
                        v-model="houseName"
                      />
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                      <input
                        type="date"
                        id="date1"
                        width="35"
                        v-model="startDay"
                        class="체크인"
                        data-placeholder="체크인"
                        required
                        aria-required="true"
                      />
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                      <input
                        type="date"
                        width="35"
                        height="50"
                        v-model="endDay"
                        id="date2"
                        class="체크아웃"
                        data-placeholder="체크아웃"
                        required
                        aria-required="true"
                      />
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                      <button
                        type="button"
                        @click="houseSearch"
                        class="btn btn-danger wrn-btn"
                      >
                        Search
                        <v-icon>mdi-magnify</v-icon>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </section>
      </div>
      <v-row>
        <v-cols cols="12">
          <div id="ims">
            <car id="car" />
          </div>
        </v-cols>
      </v-row>

      <div id="chart">
        <v-row>
          <v-col cols="6">
            <corona-chart></corona-chart>
          </v-col>
        </v-row>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Car from "./testview.vue";
import CoronaChart from "./VueChart.vue";

export default {
  components: {
    Car,
    CoronaChart,
  },
  data() {
    return {
      searchResult: [],
      startDay: "",
      houseName: "",
      endDay: "",
    };
  },
  methods: {
    houseSearch() {
      axios
        .post("/houseSearch", {
          houseName: this.houseName,
        })
        .then((res) => {
          console.log("qweqweqwe", res.data.searchResult);
          this.searchResult = res.data.searchResult;
          this.$router.push({
            name: "/houseSearch",
            params: {
              searchResult: this.searchResult,
              startDay: this.startDay,
              endDay: this.endDay,
            },
          });
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  mounted() {
    console.log("ㄷ동영최고");
    console.log("dddddddddddddddddddddd", this.$store.state.user);

    console.log("qqqqqqqqqqqqqqqqqqq", this.$store.state.user.user.id);
  },
};
</script>

<style>
#text {
  position: absolute;
  top: 150px;
  left: 150px;
}
#abc {
  width: 100%;
  height: 100%;
}
#back {
  position: relative;
  background-image: url("https://mdbootstrap.com/img/Photos/Horizontal/Nature/full%20page/img%20%283%29.jpg");
  height: 700px;
  background-size: cover;
}
#chart {
  position: absolute;

  top: 1px;
  margin-top: 150px;
  margin-left: 1280px;
}
#ims {
  background: #0080ff;
  position: relative;
}
#car {
  margin-top: 60px;
  position: absolute;
}
#weather {
  width: 300px;
  height: 300px;
}
#ml {
  width: 1200px;
  top: 630px;
  left: 700px;
  margin-left: 300px;
  position: absolute;

  left: 1px;
}
#card {
  background-color: lightgray;
  opacity: 80%;
}
#date1 {
  background-color: white;
  width: 285px;
  height: 50px;
  border-radius: 3%;
}
#date2 {
  background-color: white;
  width: 285px;
  height: 50px;
  border-radius: 3%;
}
#search {
  background-color: white;
  width: 500px;
}

#backgr {
  background-color: white;
  width: 1000px;
  height: 300px;

  margin-left: 50px;
}
/*search box css start here*/
.search-sec {
  padding: 2rem;
}
.search-slt {
  display: block;
  width: 100%;
  font-size: 0.875rem;
  line-height: 1.5;
  color: #55595c;
  background-color: #fff;
  background-image: none;
  border: 1px solid #ccc;
  height: calc(3rem + 2px) !important;
  border-radius: 0;
}
.wrn-btn {
  width: 100%;
  font-size: 16px;
  font-weight: 400;
  text-transform: capitalize;
  height: calc(3rem + 2px) !important;
  border-radius: 0;
}
@media (min-width: 992px) {
  .search-sec {
    position: relative;

    background: rgba(26, 70, 104, 0.51);
  }
}

@media (max-width: 992px) {
  .search-sec {
    background: #1a4668;
  }
}
input[type="date"]::before {
  content: attr(data-placeholder);
  width: 100%;
}
input[type="date"]:focus::before,
input[type="date"]:valid::before {
  display: none;
}
</style>