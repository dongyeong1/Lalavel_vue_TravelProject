<template>
  <div id="con">
    <v-form mt-10 ref="form" @submit.prevent="onSubmit">
      <v-container>
        <h1 class="title">회원가입</h1>
        <br />

        <span>이름</span>
        <v-text-field
          v-model="name"
          :counter="10"
          :rules="nameRules"
          label="Name"
          required
          outlined
        ></v-text-field>
        이메일
        <v-text-field
          v-model="email"
          :rules="emailRules"
          label="E-mail 입력"
          required
          outlined
        ></v-text-field>
        비밀번호
        <v-text-field
          type="password"
          v-model="password"
          :rules="passwordRules"
          label="password 입력"
          required
          outlined
        ></v-text-field>

        비밀번호 확인
        <v-text-field
          type="password"
          v-model="password2"
          label="password 확인"
          required
          outlined
        ></v-text-field>
        <v-checkbox v-model="state" label="사용자" value="dong"> </v-checkbox>
        <v-checkbox v-model="state" label="사장님" value="master"> </v-checkbox>

        <v-btn
          block
          type="submit"
          :disabled="!buttonActivation"
          color="#01DF3A"
          class="mr-4"
        >
          go register
        </v-btn>
      </v-container>
    </v-form>
  </div>
</template>

<script>
import axios from "axios";
// import axios from "axios";

export default {
  data() {
    return {
      state: "",
      valid: false,
      name: "",
      password: "",
      password2: "",
      email: "",
      password_confirmation: true,

      nameRules: [
        (v) => !!v || "이름을 입력해주세요.",
        (v) => (v && v.length <= 10) || "이름은 10글자 이하로 입력해주세요.",
      ],
      emailRules: [
        (v) => !!v || "이메일을 입력해주세요.",
        (v) => /.+@.+\..+/.test(v) || "이메일 형식이 올바르지 않습니다.",
      ],
      passwordRules: [
        (v) => !!v || "비밀번호를 입력해주세요.",
        (v) => v.length > 7 || "비밀번호는 최소 8자 이상으로 입력해주세요.",
      ],
    };
  },
  computed: {
    buttonActivation: function () {
      if (
        this.name === "" ||
        this.password === "" ||
        this.password2 === "" ||
        this.email === "" ||
        this.password !== this.password2 ||
        /.+@.+\..+/.test(this.email) == false
      ) {
        return false;
      } else return true;
    },
  },
  methods: {
    onSubmit() {
      if (this.password != this.password2) {
        return alert("비밀번호가 일치하지 않습니다.");
      } else {
        this.password_confirmation = true;
      }
      axios
        .post("/register", {
          state: this.state,
          email: this.email,
          name: this.name,
          password: this.password,
          password_confirmation: this.password_confirmation,
        })
        .then((res) => {
          console.log(res.status);
          this.$router.push("/login");
        })
        .catch((err) => {
          console.log(err);
          console.log("가입이 안됐어용ㅠ");
          if (err.response.data.email.length == 1) {
            alert("이미 사용 중인 이메일입니다. 이메일을 다시 입력해주세요.");
          } else
            alert("사용 불가능한 이메일 입니다. 이메일을 다시 입력해주세요.");
          this.email = "";
        });
    },
  },
};
</script>

<style scoped>
#con {
  background-color: ghostwhite;
}
.title {
  text-align: center;
}
.container {
  max-width: 500px;
}
</style>