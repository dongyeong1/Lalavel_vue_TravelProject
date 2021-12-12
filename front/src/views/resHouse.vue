<template>
  <v-container>
    <div id="qwe">
      <v-card id="cad">
        <v-row>
          <v-col cols="5">
            <div id="heart">
              <v-btn icon large>
                <!-- <v-icon @click="clickheart(card.id)">mdi-heart</v-icon> -->

                <div>
                  <svg
                    @click="likeCliked(card.id)"
                    v-if="like == false"
                    aria-label="좋아요"
                    class="_8-yf5"
                    color="#262626"
                    fill="#262626"
                    height="40"
                    role="img"
                    viewBox="0 0 48 48"
                    width="40"
                  >
                    <path
                      d="M34.6 6.1c5.7 0 10.4 5.2 10.4 11.5 0 6.8-5.9 11-11.5 16S25 41.3 24 41.9c-1.1-.7-4.7-4-9.5-8.3-5.7-5-11.5-9.2-11.5-16C3 11.3 7.7 6.1 13.4 6.1c4.2 0 6.5 2 8.1 4.3 1.9 2.6 2.2 3.9 2.5 3.9.3 0 .6-1.3 2.5-3.9 1.6-2.3 3.9-4.3 8.1-4.3m0-3c-4.5 0-7.9 1.8-10.6 5.6-2.7-3.7-6.1-5.5-10.6-5.5C6 3.1 0 9.6 0 17.6c0 7.3 5.4 12 10.6 16.5.6.5 1.3 1.1 1.9 1.7l2.3 2c4.4 3.9 6.6 5.9 7.6 6.5.5.3 1.1.5 1.6.5.6 0 1.1-.2 1.6-.5 1-.6 2.8-2.2 7.8-6.8l2-1.8c.7-.6 1.3-1.2 2-1.7C42.7 29.6 48 25 48 17.6c0-8-6-14.5-13.4-14.5z"
                    ></path>
                  </svg>
                  <svg
                    @click="likeCliked(card.id)"
                    aria-label="좋아요 취소"
                    v-if="like == true"
                    class="_8-yf5"
                    color="#ed4956"
                    fill="#ed4956"
                    height="40"
                    role="img"
                    viewBox="0 0 48 48"
                    width="40"
                  >
                    <path
                      d="M34.6 3.1c-4.5 0-7.9 1.8-10.6 5.6-2.7-3.7-6.1-5.5-10.6-5.5C6 3.1 0 9.6 0 17.6c0 7.3 5.4 12 10.6 16.5.6.5 1.3 1.1 1.9 1.7l2.3 2c4.4 3.9 6.6 5.9 7.6 6.5.5.3 1.1.5 1.6.5s1.1-.2 1.6-.5c1-.6 2.8-2.2 7.8-6.8l2-1.8c.7-.6 1.3-1.2 2-1.7C42.7 29.6 48 25 48 17.6c0-8-6-14.5-13.4-14.5z"
                    ></path>
                  </svg>
                </div>
              </v-btn>
            </div>

            <div id="img">
              <img
                :src="this.imagePath + this.card.image"
                alt=""
                width="300px"
                height="300px"
              />
            </div>
          </v-col>

          <v-col cols="6">
            <div id="content">
              <h1>{{ card.title }}</h1>
              <h4>설명:{{ card.description }}</h4>
              <h4>주소:{{ card.address }}</h4>
              <h4>최대인원:{{ card.peoplenumber }}</h4>
              <div>
                <v-icon large v-if="card.parking == '가능'">mdi-car</v-icon>
                <v-icon large v-if="card.parking == '금지'">mdi-car-off</v-icon>
                <v-icon large v-if="card.wifi == '가능'">mdi-wifi</v-icon>
                <v-icon large v-if="card.wifi == '금지'">mdi-wifi-off</v-icon>
                <v-icon large v-if="card.pet == '가능'">mdi-dog-side</v-icon>
                <v-icon large v-if="card.pet == '금지'"
                  >mdi-dog-side-off</v-icon
                >
                <v-icon large v-if="card.smoking == '가능'">mdi-smoking</v-icon>
                <v-icon large v-if="card.smoking == '금지'"
                  >mdi-smoking-off</v-icon
                >
              </div>
              <div v-if="userstate">
                <h4>사용할수있는 포인트:{{ currentPoint - points }}</h4>

                <v-text-field
                  :rules="numberRule"
                  placeholder="얼마 사용하세요?"
                  v-model="points"
                  style="width: 200px"
                />
                <h4>가격:{{ card.pay - points }}</h4>

                <div>
                  <button @click="py">결제하기</button>
                </div>
              </div>

              <div>
                <div class="layer"></div>
                <div class="layers">
                  <div ref="paypal"></div>
                </div>
              </div>
            </div>
          </v-col>
        </v-row>
      </v-card>
      <button type="button" class="btn btn-primary" @click="isOpen = !isOpen">
        예약목록
      </button>

      <v-row>
        <v-col cols="6">
          <collapse-transition>
            <div v-if="isOpen">
              <reserve-calender
                v-on:scor="scor"
                :id="this.card.id"
                :color="this.card.color"
              ></reserve-calender>
            </div>
          </collapse-transition>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12">
          <collapse-transition>
            <v-card>
              <user-comment :house="this.card" />
            </v-card>
          </collapse-transition>
        </v-col>
      </v-row>
    </div>
  </v-container>
</template>

<script>
import UserComment from "./userComment";
import axios from "axios";
import ReserveCalender from "./calender";
export default {
  data() {
    return {
      numberRule: [(v) => !(v && v > this.currentPoint) || "사용범위초과"],
      currentPoint: "",
      points: 0,
      userstate: "",
      isCommentOpen: false,
      isOpen: false,
      product: {
        description: "this test app",
        price: (this.card.pay - this.points) / 100,
      },
      itemsId: 1,
      total_amount: 2000,
      userId: this.$store.state.user.user.id,
      itemName: 1,
      paymentInfo: "",
      like: false,
      imagePath: "http://localhost:8000/storage/image/",
      startDay: "",
      endDay: "",
      title: "",
    };
  },
  components: { ReserveCalender, UserComment },
  mounted() {
    if (
      this.$store.state.user.user.state == "master" ||
      this.$store.state.user.user.state == "dong"
    ) {
      this.userstate = true;
    }
    this.alert();
    axios
      .post("/loadPoint", {
        userId: this.$store.state.user.user.id,
      })
      .then((res) => {
        console.log("asdfg", res.data);
        this.currentPoint = res.data;
      })
      .catch((err) => {
        console.log(err);
      });
    console.log("qwertyu", this.$store.state.user.user);
    console.log("hhhhhhhhhhhhhhhhhh", this.card);
    this.loadHeart();
  },
  props: ["card"],

  methods: {
    py() {
      window.paypal
        .Buttons({
          createOrder: (data, actions) => {
            return actions.order.create({
              purchase_units: [
                {
                  description: this.product.description,
                  amount: {
                    currency_code: "USD",
                    value: (this.card.pay - this.points) / 100,
                  },
                },
              ],
            });
          },
          onApprove: async () => {
            alert("결제완료");
            this.reserve();
          },
        })
        .render(this.$refs.paypal);
    },
    alert() {
      if (this.currentPoint < 0) {
        alert("초과");
      }
    },
    aaa(houseNum) {
      axios
        .post("/clickHeart", {
          houseNum,
          userId: this.$store.state.user.user.id,
        })
        .then(() => {
          alert("찜했습니다.");
          this.loadHeart();
        })
        .catch((err) => {
          console.log(err);
        });
    },
    bbb(houseNum) {
      axios
        .post("/unClickHeart", {
          houseNum,
          userId: this.$store.state.user.user.id,
        })
        .then(() => {
          alert("찜이해제되었습니다.");
          this.loadHeart();
        })
        .catch((err) => {
          console.log(err);
        });
    },
    likeCliked(houseNum) {
      if (this.like == false) {
        if (confirm("찜하시겠습니까?")) {
          this.aaa(houseNum);
        }
      } else {
        if (confirm("해제하시겠습니까?")) {
          this.like = !this.like;
          this.bbb(houseNum);
        }
      }
    },
    loadHeart() {
      axios
        .post("/loadHeart", {
          userId: this.$store.state.user.user.id,
          houseNum: this.card.id,
        })
        .then((res) => {
          console.log("qqqqqqqqqqqqqqqqqqqqqqq", res.data);
          if (res.data == 1) {
            this.like = true;
          } else {
            this.like = false;
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    scor(abc) {
      this.startDay = abc.startDay;
      this.endDay = abc.endDay;
      this.title = abc.title;
    },
    reserve() {
      axios
        .post("/reserve", {
          startDay: this.startDay,
          endDay: this.endDay,
          title: this.title,
          id: this.card.id,
          userId: this.$store.state.user.user.id,
        })
        .then(() => {
          alert("예약성공");
          axios
            .post("/addpoint", {
              userId: this.$store.state.user.user.id,
              point: this.card.pay / 100 - this.points,
            })
            .then((res) => {
              console.log(res.data);
            })
            .catch((err) => {
              console.log(err);
            });

          this.$router.push({ name: "/Main" });
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
<style>
#img {
  margin-top: 10px;
  margin-left: 150px;
}
#qwe {
  margin-top: 100px;
}
#content {
  margin-left: 50px;
}
#heart {
  margin-right: 100px;
}
#cad {
  margin-bottom: 100px;
}
</style>