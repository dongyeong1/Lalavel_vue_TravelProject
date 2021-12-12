<template>
  <div>
    <button @click="geofind">위치찾기</button>
    <p>{{ textContent }}</p>
    <KakaoMap id="map" ref="kmap" class="kmap" :options="mapOption"> </KakaoMap>
  </div>
</template>

<script>
import KakaoMap from "./kakaoMap.vue";
export default {
  components: {
    KakaoMap,
  },
  data() {
    return {
      latitude: "",
      longitude: "",
      textContent: "",
      mapOption: {
        center: {
          lat: "",
          lng: "",
        },
        level: 8,
      },
    };
  },

  methods: {
    markLoad() {
      //   console.log("asd");
      //   console.log("makload");
      console.log("mark", this.x, this.y);
      var mapContainer = document.getElementById("map");
      var mapOption = {
        center: new window.kakao.maps.LatLng(this.latitude, this.longitude),
        level: 5,
      };
      var markerPosition = new window.kakao.maps.LatLng(
        this.latitude,
        this.longitude
      );
      var map = new window.kakao.maps.Map(mapContainer, mapOption);
      var marker = new window.kakao.maps.Marker({
        position: markerPosition,
      });
      //   this.markers.push(marker);

      marker.setMap(map);
    },
    mapLoad(a, b) {
      this.mapOption.center.lat = a;
      this.mapOption.center.lng = b;
    },
    geofind() {
      if (!("geolocation" in navigator)) {
        this.textContent = "Geolocation is not available.";
        return;
      }
      this.textContent = "Locating...";

      // get position
      navigator.geolocation.getCurrentPosition(
        (pos) => {
          this.latitude = pos.coords.latitude;
          this.longitude = pos.coords.longitude;
          this.textContent =
            "Your location data is " + this.latitude + ", " + this.longitude;
        },
        (err) => {
          this.textContent = err.message;
        }
      );
      this.mapLoad();
      this.markLoad(this.latitude, this.longitude);
    },
  },
};
</script>