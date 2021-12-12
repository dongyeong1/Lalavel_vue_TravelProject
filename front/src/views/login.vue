<template>
  <div id="dong">
    <div>
      <div class="container">
        <div class="d-flex justify-content-center h-100">
          <div class="card">
            <div class="card-header">
              <h3>Sign In</h3>
            </div>
            <div class="card-body">
              <v-form class="display-1 my-10" ref="form" v-model="valid">
                <div class="input-group form-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"
                      ><i class="fas fa-user"></i
                    ></span>
                  </div>
                  <input
                    type="text"
                    class="form-control"
                    v-model="email"
                    placeholder="username"
                  />
                </div>
                <div class="input-group form-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"
                      ><i class="fas fa-key"></i
                    ></span>
                  </div>
                  <input
                    v-model="password"
                    type="password"
                    @keyup.enter="login"
                    class="form-control"
                    placeholder="password"
                  />
                </div>

                <div class="form-group">
                  <v-btn
                    @click="login"
                    value="Login"
                    class="btn float-right login_btn"
                    color="#FFBF00"
                    :disabled="!valid"
                  >
                    login
                  </v-btn>
                </div>
              </v-form>
            </div>
            <div class="card-footer">
              <div class="d-flex justify-content-center links">
                회원이아닌가요?<button @click="register">
                  <a href="#">Sign Up</a>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      valid: true,
      email: "",
      password: "",
    };
  },

  methods: {
    login() {
      //   this.$store
      //     .dispatch("/dong", {})
      //     .then(() => {})
      //     .catch((err) => {
      //       console.log(err);
      //     });
      //   console.log("lllllllllll");
      this.$store
        .dispatch("login", {
          email: this.email,
          password: this.password,
        })
        .then(() => {
          if (!this.$store.state.user) {
            console.log("login failed");
            alert("아이디와 비밀번호를 확인해주세요.");
          } else {
            console.log("login successed");
            this.$router.push({ name: "/Main" });
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    register() {
      if (this.$store.state.user.user.id) {
        return alert("로그아웃 후 이용해주세요.");
      } else {
        this.$router.push({ name: "/register" });
      }
    },
  },
};
</script>

<style scoped>
.class {
  text-align: center;
}
.container {
  max-width: 800px;
}
#qwe {
  background-color: ghostwhite;
}
@import url("https://fonts.googleapis.com/css?family=Numans");

html,
#dong {
  height: 800px;
  background-image: url("http://getwallpapers.com/wallpaper/full/a/5/d/544750.jpg");
  background-size: cover;
  background-repeat: no-repeat;
  /* height: 100%; */
  font-family: "Numans", sans-serif;
}

.container {
  height: 100%;
  align-content: center;
}

.card {
  height: 370px;
  margin-top: 200px;
  margin-bottom: auto;
  width: 400px;
  background-color: rgba(0, 0, 0, 0.5) !important;
}

.social_icon span {
  font-size: 60px;
  margin-left: 10px;
  color: #ffc312;
}

.social_icon span:hover {
  color: white;
  cursor: pointer;
}

.card-header h3 {
  color: white;
}

.social_icon {
  position: absolute;
  right: 20px;
  top: -45px;
}

.input-group-prepend span {
  width: 50px;
  background-color: #ffc312;
  color: black;
  border: 0 !important;
}

input:focus {
  outline: 0 0 0 0 !important;
  box-shadow: 0 0 0 0 !important;
}

.remember {
  color: white;
}

.remember input {
  width: 20px;
  height: 20px;
  margin-left: 15px;
  margin-right: 5px;
}

.login_btn {
  color: black;
  background-color: #ffc312;
  width: 100px;
}

.login_btn:hover {
  color: black;
}

.links {
  color: white;
}

.links a {
  margin-left: 4px;
}
</style>