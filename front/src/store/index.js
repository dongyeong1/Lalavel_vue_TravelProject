import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";
Vue.use(Vuex);



const store = new Vuex.Store({
 
  state: {
    user: {
      user:1
    },
  },
  mutations: {
    setUserData(state, userData) {
      state.user = userData;
      localStorage.setItem("user", JSON.stringify(userData));
      axios.defaults.headers.common.Authorization = `Bearer ${userData.token}`;
    },

    clearUserData(state) {
      state.user = null;
      localStorage.removeItem("user");
      

      location.reload();
      this.$router.push({ name: "/Main" });
    },
  },
  actions: {
    async login({ commit }, credentials) {
        console.log('aaaaaaaaaaaaa')
      try {
        const response = await axios.get(
            "http://localhost:8000/sanctum/csrf-cookie"
          );

        console.log(response.status);
        const { data } = await axios.post("/login", credentials);

        commit("setUserData", data);
      } catch (err) {
        console.log(err);
      }
    },
    dong(){
        console.log('ddddddddddddddd');
    },
      
    logout({ commit }) {
      
      
      axios.post("/logout").then((res) => {
        console.log(res.data);
      });
      commit("clearUserData");
    },
  },


});

export default store;