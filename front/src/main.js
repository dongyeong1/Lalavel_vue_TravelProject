import Vue from 'vue'
import App from './App.vue'
import router from './router'
import vuetify from './plugins/vuetify'
import axios from 'axios'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import VueCarousel from 'vue-carousel';
import store from './store'
import VueGeolocationApi from 'vue-geolocation-api'
// import VueChatScroll from 'vue-chat-scroll'
// Vue.use(VueChatScroll)
Vue.use(VueCarousel);
Vue.use(VueGeolocationApi);

axios.defaults.baseURL = "http://localhost:8000/api";
Vue.use(BootstrapVue)
// Vue.use(vuex)
Vue.config.productionTip = false

new Vue({
  store,
  router,
  vuetify,

  created() {
   
    const userInfo = localStorage.getItem("user");
    if (userInfo) {
      const userData = JSON.parse(userInfo);
      this.$store.commit("setUserData", userData);
    }
    // axios.interceptors.response.use(
    //   (response) => response,
    //   (error) => {
    //     if (error.response.status === 401) {
    //       this.$store.dispatch("logout");
    //     }
    //     return Promise.reject(error);
    //   }
    // );
  },
  render: (h) => h(App),
}).$mount("#app");