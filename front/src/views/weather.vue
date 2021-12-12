<template>
  <div>
    <carousel :perPage="1" :autoplay="true" :loop="true">
      <slide
        v-for="(img, index) in datas"
        :key="index"
        width="50%"
        height="50%"
      >
        <img :src="`${img.image}`" alt="" width="50%" height="50%" />

        <span style="font-size: 1.5em">{{ img.city }}</span>
      </slide>
    </carousel>
  </div>
</template>
<script>
import axios from "axios";
import { Carousel, Slide } from "vue-carousel";
export default {
  components: {
    Carousel,
    Slide,
  },
  data() {
    return {
      datas: [],
      city: ["seoul", "busan", "daegu", "jeju", "incheon", "daejun", "gwangju"],
      image: "",
      weat: "",
    };
  },
  mounted() {
    for (var i = 0; i < this.city.length; i++) {
      this.weatherload(this.city[i]);
    }
  },
  methods: {
    weatherload(city) {
      const cityName = city;
      const apikey = "407c340ad45b9019b9732c3bf8018bc9";
      var url = `http://localhost:8081/two/data/2.5/weather?q=${cityName}&appid=${apikey}`;

      axios
        .get(url)
        .then((res) => {
          console.log(res.data);
          const data = res.data;
          var image = `http://openweathermap.com/img/w/${data.weather[0].icon}.png`;
          var weat = data.weather[0].description;
          var city = data.name;
          console.log("ccccccccccc", city);
          var abc = {
            image,
            weat,
            city,
          };

          this.datas.push(abc);
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
