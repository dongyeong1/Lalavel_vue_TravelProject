
<template>
  <v-container>
    <reserve-calender></reserve-calender>
    <div></div>
  </v-container>
</template>

<script>
// import axios from "axios";
import ReserveCalender from "./userCalendar";
export default {
  data() {
    return {
      imagePath: "http://localhost:8000/storage/image/",
      startDay: "",
      endDay: "",
      title: "",
    };
  },
  components: { ReserveCalender },
  mounted() {},
  props: ["card"],
};
</script>