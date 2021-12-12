<template >
  <section>
    <!-- <h1>Demo examples of vue-chartjs</h1> -->
    <div class="column">
      <h1>실시간평점Top3</h1>

      <star-chart
        :width="350"
        :height="250"
        class="container"
        :houses="house"
      />
    </div>
  </section>
</template>
 
<script>
import StarChart from "@/components/starsChart";

export default {
  name: "VueChartJS",
  components: {
    StarChart,
  },
  mounted() {
    console.log("starssssssss", this.house);
  },
  props: ["house"],
};
</script>

 
<style scoped>
.column {
  width: 300px;
}
</style>