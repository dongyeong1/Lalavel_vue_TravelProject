<template>
  <div>
    <div>
      <carousel :perPage="10" :autoplay="true" :loop="true" id="main-banner">
        <slide v-for="(img, v) in images" :key="v">
          <v-row>
            <v-col id="col" cols="3">
              <img :src="img.imgs" alt="" style="border-radius: 70%" />

              <v-card-title @click="asd" id="size"
                ><button>{{ img.content }}</button></v-card-title
              >
            </v-col>
          </v-row>

          <!-- <img :src="`${img.imgs}`" alt="" width="100%" height="100%" /> -->
          <!-- <span>{{ img.content }}</span> -->
        </slide>
      </carousel>
      <!-- <start-rating @rating-selected="rr" v-model="dong"></start-rating> -->
    </div>
  </div>
</template>

<script>
import axios from "axios";

// import StartRating from "vue-star-rating";
import { Carousel, Slide } from "vue-carousel";
export default {
  components: {
    Carousel,
    Slide,
    // StartRating,
  },
  mounted() {
    for (var i = 0; i < this.city.length; i++) {
      this.weatherload(this.city[i]);
    }
    console.log("cityyyyyyyyyyyyyyy", this.datas);
    this.load();
    console.log("ttttttttttttttttttt", this.datas);
  },

  methods: {
    showPost() {
      this.showopen = true;
    },
    close() {
      this.showopen = false;
    },
    asd() {
      console.log("asssssssssssss");
    },
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
    onScroll() {
      this.scrollInvoked++;
    },
    rr() {
      console.log(this.dong);
    },
  },
  data() {
    return {
      titles: "경주",
      contents: "아름답다",
      showopen: false,
      datas: [],
      dialog: false,

      image: "",
      weat: "",
      city: ["seoul", "busan", "daegu", "Jeju", "gwangju", "ulsan"],
      scrollInvoked: 0,
      dong: "",
      images: [
        {
          imgs: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSz5XuJVIIjZXySAlGkVEBGj9NBDKZKwkWlbAT-wt0WIU1i-nEwoIPWCffZyENrWvTniL4&usqp=CAU",
          content: "서울(경복궁)",
        },
        {
          imgs: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT68-UV3AIjIsv3nEXw325KqW67LQdorxkx9cc-P7kbXM0ogkLZmES8dGB6r18zfmbkJKk&usqp=CAU",
          content: "울산(간절곶)",
        },
        {
          imgs: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTWxnU4-xzaZvpBv6_mNduYd7E3Ec_eDXJt3rXGc9J3jgcmy1DV8wwT_kDoYXhSnreu6T4&usqp=CAU",
          content: "경주(첨성대)",
        },
        {
          imgs: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRCcBGufEjOW5gfcLwhjIn0RcyTEQa_08A6SBNjfSIx1NDcNKRqIPKZFCUIJGj9obVEiwA&usqp=CAU",
          content: "제주도(돌하르방)",
        },

        {
          imgs: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTThfDffZSewe-SpDkOTiUbcu-SMbvrweJFXottwuDg8xobQ1_e4P8o4Y1psfzX5xBy0As&usqp=CAU",
          content: "대구(서문시장)",
        },
        {
          imgs: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTkqqBaMd0VpfDz0sJZdGp6lIKXibZjU5FhZLUEjyYY6l-gTqoSn9SeeMs6K9oOg1Jf7Rk&usqp=CAU",
          content: "용인(에버랜드)",
        },
        {
          imgs: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ2_m7JmZVohn7P7m3dabgcTzxddUZG2pES-xzDLjWmSa5B_UQYwicR1XmnwpHi634KmJw&usqp=CAU",
          content: "서울(명동)",
        },
        {
          imgs: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR-WoVazz3KsrpIaZcnDstLePwhomKzECaIfCUq07cWS_XCBjSPdOUAjhPGsNe_eOgmH74&usqp=CAU",
          content: "부산(해운대)",
        },
        {
          imgs: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR-WoVazz3KsrpIaZcnDstLePwhomKzECaIfCUq07cWS_XCBjSPdOUAjhPGsNe_eOgmH74&usqp=CAU",
          content: "강원도(설악산)",
        },
        {
          imgs: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQWeFV71Jiee29FgCudvz_XT_vGE-_f74XBp11F_UADNEyvLh3VNocTKhzORvni8eOx_Bo&usqp=CAU",
          content: "수원(수원화성)",
        },
        {
          imgs: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7oqSwYIaiTXihPFnoflmFPw7jb7sQ-IV0973yad6DLU11JHEsmTmgrssgOcsiVMTFcNE&usqp=CAU",
          content: "경남(지리산)",
        },
        {
          imgs: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRStXCupcZoJS8VmUvGBanZYraF6nHKi8NhzY7JloIZbqI1JVtx6JTzkrIy-QuK1769rfs&usqp=CAU",
          content: "양양(낙산해변)",
        },
      ],
    };
  },
};
</script>
<style>
#weather {
  /* margin-left: 0px; */
}
#col {
  margin-left: 20px;
}
#card {
  background-color: red;
}
#img {
  width: 10%;
}
#main-banner {
  height: 350px;
  display: flex;
  align-items: center;
  justify-content: flex-start;
}
#size {
  width: 200px;
}
.img-size {
  /* 	padding: 0;
	margin: 0; */
  height: 450px;
  width: 700px;
  background-size: cover;
  overflow: hidden;
}
.modal-content {
  width: 700px;
  border: none;
}
.modal-body {
  padding: 0;
}

.carousel-control-prev-icon {
  background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23009be1' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E");
  width: 30px;
  height: 48px;
}
.carousel-control-next-icon {
  background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23009be1' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E");
  width: 30px;
  height: 48px;
}
</style>