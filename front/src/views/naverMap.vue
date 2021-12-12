<template>
  <div id="aaaaa">
    <div class="controll">
      <button @click="zoom(1)">
        <span class="material-icons"> zoom_in </span>
      </button>
      <button @click="zoom(-1)">
        <span class="material-icons"> zoom_out </span>
      </button>
      <h1>검색하기</h1>
    </div>
    <v-row>
      <v-col cols="3">
        <div id="cardss" style="width: 150px; height: 530px">
          <div class="searchbox">
            <div id="searchh">
              <v-text-field
                id="field"
                type="text"
                @keyup.enter="searchPlace"
                placeholder="입력해주세요"
              />
            </div>
            <div class="results">
              <div style="overflow: scroll; width: 230px; height: 530px">
                <ul
                  id="messages"
                  v-chat-scroll="{ always: false, smooth: true }"
                >
                  <li
                    class="message"
                    v-for="rs in search.results"
                    :key="rs.id"
                    @click="showPlace(rs)"
                  >
                    {{ rs.place_name }}<br />

                    {{ rs.address_name }}
                    <hr />
                  </li>
                </ul>
                <div id="pagination"></div>
              </div>

              <div class="text-center">
                <!-- <div v-if="search">
                <v-pagination
                  v-if="search"
                  v-model="page"
                  :length="search.pgn.last"
                  circle
                ></v-pagination>
              </div> -->
              </div>
            </div>
          </div>
        </div>
      </v-col>

      <v-col cols="9">
        <div id="parentcard">
          <KakaoMap ref="kmap" class="kmap" :options="mapOption">
            <div class="overlay-popup" ref="harborOverlay" slot="overlay">
              <h6>*상세보기*</h6>

              <div v-if="overlayHarber" @click="goRouter">
                <div>{{ overlayHarber.place }}</div>
              </div>

              <a @click="closeOverlay()">close</a>
            </div>
          </KakaoMap>
          <div
            class="harbor"
            v-for="(hbr, v) in harbors"
            :key="v"
            @click="showOnMap(hbr)"
          >
            {{ hbr.place }}
            {{ hbr.abc }}
          </div>
        </div>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import KakaoMap from "./kakaoMap.vue";
import MarkerHandler from "./marker-handler";
import KakaoOverlay from "./overlay/index";
export default {
  components: {
    KakaoMap,
  },
  data() {
    return {
      scrollInvoked: 0,
      clickedd: "",
      page: 1,
      mapOption: {
        center: {
          lat: 33.450701,
          lng: 126.570667,
        },
        level: 8,
      },
      harbors: [],
      // markers: null,
      search: {
        keword: null,
        pgn: {},
        results: [],
      },
      activeHarbor: null,
      overlay: null,
      overlayHarber: null,
    };
  },
  mounted() {
    this.load();
  },
  methods: {
    goRouter() {
      this.$router.push({
        name: "/resCalender",
        params: { dong: this.clickedd },
      });
    },

    closeOverlay() {
      this.overlay.hide();
    },
    showOnMap(harbor) {
      console.log("activesadas", this.activeHarbor);
      this.activeHarbor = harbor;
      // this.activeHarbor.push(harbor);
      // console.log("[center]", harbor);
      this.mapOption.center = {
        lat: harbor.lat,
        lng: harbor.lng,
      };
    },
    load() {
      const vueKakaoMap = this.$refs.kmap;
      // const marker = [];
      this.markers = new MarkerHandler(vueKakaoMap, {
        markerClicked: (harbor) => {
          this.clickedd = harbor;
          console.log("{cliked}ss", harbor);

          console.log("active", this.activeHarbor);
          this.showOnMap(harbor);
          this.overlayHarber = harbor;
          //마커 클릭시
          // this.overlayharbor = harbor;

          this.overlay.showAt(harbor.lat, harbor.lng);
        },
      });
      this.overlay = new KakaoOverlay(vueKakaoMap, this.$refs.harborOverlay);
      //created
      this.markers.add(this.harbors, (harbor) => {
        // this.activeHarbor[0] = harbor;
        return {
          lat: harbor.lat,
          lng: harbor.lng,
        };
      });
    },
    showPlace(place) {
      console.log("장소");
      console.log(place);
      this.harbors.push({
        place: place.address_name,
        lat: place.y,
        lng: place.x,
      });

      this.load();
      this.mapOption.center = {
        lat: place.y,
        lng: place.x,
      };
      console.log(this.mapOption.center.lat);
    },
    searchPlace(e) {
      console.log(e.target.value);
      const keword = e.target.value.trim();
      if (keword.length === 0) {
        return;
      }
      var ps = new window.kakao.maps.services.Places();
      ps.keywordSearch(keword, (data, status, pagination) => {
        console.log("동영");
        console.log(data);
        this.search.keword = keword;
        this.search.pgn = pagination;
        this.search.results = data;
        console.log("search", this.search);
        this.displayPagination(pagination);
      });
    },
    zoom(delta) {
      console.log(delta);
      const level = Math.max(3, this.mapOption.level + delta);
      this.mapOption.level = level;
    },
    displayPagination(pagination) {
      var paginationEl = document.getElementById("pagination"),
        fragment = document.createDocumentFragment(),
        i;

      // 기존에 추가된 페이지번호를 삭제합니다
      while (paginationEl.hasChildNodes()) {
        paginationEl.removeChild(paginationEl.lastChild);
      }

      for (i = 1; i <= pagination.last; i++) {
        var el = document.createElement("a");
        el.href = "#";
        el.innerHTML = i;

        if (i === pagination.current) {
          el.className = "on";
        } else {
          el.onclick = (function (i) {
            return function () {
              pagination.gotoPage(i);
            };
          })(i);
        }

        fragment.appendChild(el);
      }
      paginationEl.appendChild(fragment);
    },
  },
};
</script>

<style >
#parentcard {
  /* position: relative; */
}
#weather {
  width: 300px;
  height: 300px;
}
#messages {
  list-style: none;
  padding-left: 0px;
}
#cardss {
  /* margin-left: 300px;
  position: absolute;
  top: 200px;
  left: 1px;
  opacity: 60%; */
}

.overlay-popup {
  background-color: #ffffffcc;
  box-shadow: 0 0 8px #0000004d, 0 0 1px 2px #00000022;
  max-width: 200px;
  min-width: 160px;
  position: absolute;
  bottom: 44px;
  left: 50%;
  transform: translateX(-50%);
}
#aaaaa {
  padding: 20px;
}
#searchh {
  position: relative;
  width: 200px;
}
#zxc {
  position: absolute;
  margin-left: 20;
}
</style>
