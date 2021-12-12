<template>
  <div ref="map"><slot name="overlay"></slot></div>
</template>

<script>
export default {
  props: ["options"],
  data() {
    return {
      mapInstance: null,
    };
  },
  mounted() {
    let kakao = window.kakao;
    console.log(this.$refs.map);
    var container = this.$refs.map; //지도를 담을 영역의 DOM
    const { level } = this.options;
    this.mapInstance = new kakao.maps.Map(container, {
      center: new kakao.maps.LatLng(35.8966045, 128.6204163),
      level,
    }); //지도 생성 및 객체 리턴
    // console.log(mapInstance);
  },
  watch: {
    "options.level"(cur) {
      this.mapInstance.setLevel(cur);
    },
    "options.center"(cur) {
      this.mapInstance.panTo(new window.kakao.maps.LatLng(cur.lat, cur.lng));
      // 부드럽게 이동
    },
  },
};
</script>

<style >
.kmap {
  width: 100%;
  height: 600px;
}
</style>