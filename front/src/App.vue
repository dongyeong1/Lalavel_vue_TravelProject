

<template>
  <div>
    <v-app-bar>
      <div></div>
      <v-btn id="mainbtn" @click="main"
        ><v-icon color="#0080FF" large>mdi-airplane</v-icon>
        <h4>영진투어</h4></v-btn
      >
      <v-btn id="btn" @click="naverMap">지도검색</v-btn>

      <v-btn id="btn" @click="geofind">내주변</v-btn>
      <v-btn
        v-if="this.$store.state.user.user.state == 'master'"
        id="btn"
        @click="house"
        >숙소등록</v-btn
      >
      <v-btn
        v-if="this.$store.state.user.user.state == 'master'"
        id="btn"
        @click="masterHouse"
        >등록한 숙소</v-btn
      >

      <v-btn
        id="btn"
        v-if="this.$store.state.user.user.state == 'dong'"
        @click="myPage"
      >
        마이페이지
      </v-btn>

      <v-spacer></v-spacer>
      <weather id="weather" />

      <div id="lo" class="mx-6" v-if="$store.state.user.user == 1">
        로그인해주세요
      </div>
      <div id="userName" v-else>
        <b>{{ userName }}</b
        >님이 접속하였습니다.
      </div>

      <v-btn
        icon
        class="mr-5"
        v-if="$store.state.user.user == 1"
        @click="login"
      >
        <v-icon>mdi-power</v-icon>login
      </v-btn>
      <v-btn icon id="logout" v-else @click="logout">
        <v-icon>mdi-power</v-icon>logout
      </v-btn>
    </v-app-bar>
    <v-main>
      <router-view />
    </v-main>
  </div>
</template>

<script>
import Weather from "./views/weather.vue";
export default {
  name: "App",
  components: {
    Weather,
  },
  data() {
    return {
      isUser: false,
      latitude: "",
      longitude: "",
      textContent: "",
      drawer: false,
      gradient: "{rgba(0,0,0,.7),rgba(0,0,0,.7)}",

      items: [
        {
          title: "Home",
          icon: "mdi-view-dashboard",
          to: "/home",
        },
        {
          title: "Create",
          icon: "mdi-view-dashboard",
          to: "/create",
        },
        {
          title: "dong",
          icon: "mdi-view-dashboard",
          to: "/dong",
        },
        {
          title: "yeong",
          icon: "mdi-view-dashboard",
          to: "/yeong",
        },
      ],
    };
  },
  computed: {
    userName() {
      return this.$store.state.user.user.name;
    },
  },
  methods: {
    masterHouse() {
      this.$router.push("/masterHouse");
    },
    house() {
      this.$router.push("/houseUpload");
    },
    myPage() {
      this.$router.push("/myPage");
    },
    login() {
      this.$router.push("/login");
    },
    logout() {
      this.$router.push({ name: "/Main" });

      this.$store.dispatch("logout");
    },
    naverMap() {
      this.$router.push({ name: "/naverMap" });
    },
    main() {
      this.$router.push({ name: "/Main" });
    },
    geofind() {
      if (!("geolocation" in navigator)) {
        this.textContent = "Geolocation is not available.";
        return;
      }
      this.textContent = "Locating...";

      // get position
      navigator.geolocation.getCurrentPosition(
        (pos) => {
          this.latitude = pos.coords.latitude;
          this.longitude = pos.coords.longitude;
          this.$router.push({
            name: "/myPosition",
            params: {
              latitude: this.latitude,
              longitude: this.longitude,
            },
          });
        },
        (err) => {
          this.textContent = err.message;
        }
      );
    },
  },
  created() {
    if (this.$store.state.user.user.state == "master") {
      this.isUser = true;
    }
  },
};
</script>

<style>
#lo {
  margin-right: 50px;
}
#weather {
  margin-top: 230px;
  height: 100px;
}
#mainbtn {
  box-shadow: none;
  font-size: "20px";
  font-family: Impact;
  width: 200px;
  height: 50px;
}
#btn {
  margin-left: 20px;
  box-shadow: none;
}
#userName {
  margin-right: 30px;
}
#logout {
  margin-right: 40px;
}
</style>
