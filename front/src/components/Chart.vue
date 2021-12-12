

<script>
import { Bar } from "vue-chartjs";
import axios from "axios";

export default {
  props: [],
  extends: Bar,
  data: () => ({
    chartdata: {
      labels: [],
      datasets: [
        {
          label: "Data One",
          backgroundColor: [
            "blue",
            "#f87979",
            "#f87979",
            "#f87979",
            "#f87979",
            "#f87979",
            "#f87979",
            "#f87979",
            "#f87979",
            "#f87979",
            "#f87979",
            "#f87979",
            "#f87979",
            "#f87979",
            "#f87979",
            "#f87979",
            "#f87979",
          ],
          data: [],
        },
      ],
    },
    options: {
      scales: {
        yAxes: [
          {
            ticks: {
              beginAtZero: true,
              stepSize: 2,
              fontColor: "white",
              fontSize: 14,
            },
          },
        ],
        xAxes: [
          {
            ticks: {
              fontColor: "white",
              fontSize: 14,
            },
          },
        ],
      },
      responsive: true,
      maintainAspectRatio: false,
    },
  }),

  mounted() {
    this.load();
  },
  methods: {
    load() {
      // var app =
      //   "U+oVvJTdthQBv4qekw0vLAuP0DUZd5IP7e8IbfcVUj0525/SzCtvxNvTj0blxDIxrE1SMKxQsLuk1GMlVtk0ig==";
      //   var url =
      //     "https://api.corona-19.kr/korea/?serviceKey=H2fPthi36cUSRVq7nMgaXbLuNxTD5lBOI";
      var url2 =
        "http://localhost:8081/one/korea/country/new/?serviceKey=H2fPthi36cUSRVq7nMgaXbLuNxTD5lBOI";
      axios
        .get(url2)
        .then((res) => {
          console.log("bbbbbb", res.data);
          var array = Object.entries(res.data);
          console.log("aaaaaa", array);
          for (var i = 2; i < array.length - 1; i++) {
            console.log("asddf", array[i][1].countryName);
            this.chartdata.labels.push(array[i][1].countryName);
            this.chartdata.datasets[0].data.push(
              array[i][1].newCase.replace(",", "")
            );
          }
          console.log(this.chartdata.labels);
          this.renderChart(this.chartdata, this.options);
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>