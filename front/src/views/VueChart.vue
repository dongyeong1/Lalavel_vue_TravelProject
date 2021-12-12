<template >
  <section>
    <div class="column">
      <button
        type="button"
        class="btn btn-danger wrn-btn"
        @click="isOpen = !isOpen"
      >
        {{ today }}코로나확진자수
      </button>
      <collapse-transition>
        <div v-if="isOpen">
          <chart class="container"></chart>
        </div>
      </collapse-transition>
    </div>
  </section>
</template>
 
<script>
import Chart from "@/components/Chart";

export default {
  name: "VueChartJS",
  components: {
    Chart,
  },
  data() {
    return {
      isOpen: false,
      today: "",
    };
  },
  mounted() {
    let today = new Date();

    let year = today.getFullYear(); // 년도
    let month = today.getMonth() + 1; // 월
    let date = today.getDate(); // 날짜
    this.today = year + "/" + month + "/" + date;
  },
};
</script>
 
<style scoped>
.container {
  height: 400px;
  width: 400px;
}
.column {
  width: 300px;
}
ul {
  list-style-type: none;
  padding: 0;
}

li {
  display: inline-block;
  margin: 0 10px;
}

a {
  color: #42b983;
}
</style>