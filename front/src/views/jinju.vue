<template>
  <div>ss</div>
</template>

<script>
import axios from "axios";

export default {
  mounted() {
    axios
      .get("http://localhost:8081/three/openapi/tour/tourinfo.do")
      //   .get("https://www.jinju.go.kr/openapi/tour/tourinfo.do")
      .then((res) => {
        console.log(res.data);
      })
      .catch((err) => {
        console.log(err);
      });
  },
};
</script>
<style>
</style>