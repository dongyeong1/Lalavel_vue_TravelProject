

<script>
import { Bar } from "vue-chartjs";
import axios from "axios";

export default {
  props: [],
  extends: Bar,
  data: () => ({
    obj: {},
    sortobj: [],
    stars: [],
    commentNumber: [],
    setNumber: [],
    starplusarray: [],
    chartdata: {
      labels: [],
      datasets: [
        {
          label: "Data One",

          data: [],
          backgroundColor: ["red", "blue", "forestgreen"],
          count: 0,
          st: 0,
        },
      ],
    },
    options: {
      responsive: false,
      scales: {
        yAxes: [
          {
            ticks: {
              beginAtZero: true,
              fontSize: 14,
            },
          },
        ],
      },
      maintainAspectRatio: false,
    },
  }),

  mounted() {
    this.load();
  },
  methods: {
    load() {
      axios
        .get("/loadStarChart")
        .then((res) => {
          console.log("aaaaaaaaaaaaaaaaaa");
          console.log(res.data);
          for (var i = 0; i < res.data.length; i++) {
            this.commentNumber.push(res.data[i].houses.title);
          }
          const set = new Set(this.commentNumber);
          // this.setNumber[set];
          this.chartdata.labels = Array.from(set);
          console.log(this.chartdata.labels);
          console.log(this.commentNumber);

          for (var k = 0; k < this.chartdata.labels.length; k++) {
            this.count = 0;
            this.st = 0;

            for (var j = 0; j < res.data.length; j++) {
              if (res.data[j].houses.title == this.chartdata.labels[k]) {
                this.count += 1;
                this.st += res.data[j].star;
              }
            }
            this.obj[this.chartdata.labels[k]] = this.st / this.count;

            // this.chartdata.datasets[0].data.push(this.st / this.count);
          }
          console.log("oringobjjjjj", this.obj);

          var sortable = [];
          for (var vehicle in this.obj) {
            sortable.push([vehicle, this.obj[vehicle]]);
          }

          sortable.sort(function (a, b) {
            return b[1] - a[1];
          });
          console.log("objjjjjjjjjjjjjjjsort", sortable);
          this.chartdata.labels = [];

          for (var a = 0; a < 3; a++) {
            this.chartdata.labels.push(sortable[a][0]);
            this.chartdata.datasets[0].data.push(sortable[a][1]);
          }

          this.renderChart(this.chartdata, this.options);
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
<style>
</style>