<template>
  <div>
    <v-container>
      <v-row justify="center">
        <v-dialog v-model="dialog" persistent max-width="600px">
          <template v-slot:activator="{ on }">
            <v-btn color="primary" dark v-on="on">결제하기</v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">결제 정보 입력</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="6">
                    <v-select
                      :items="items"
                      v-model="value"
                      label="충전금액*"
                      required
                    ></v-select>
                  </v-col>
                </v-row>
              </v-container>
              <small>결제는 카카오페이로 진행됩니다</small>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="dialog = false"
                >취소</v-btn
              >
              <v-btn color="blue darken-1" text @click="pay">결제</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import axios from "axios";

export default {
  mounted() {
    this.pay();
  },
  name: "Payment",
  data: () => ({
    dialog: false,
    items: [5000, 10000, 20000],
    value: "",
  }),
  methods: {
    pay() {
      var url = "https://kapi.kakao.com";
      var headerss = {
        Authorization: "KakaoAK " + "Admin Key Here",
        "Content-type": "application/x-www-form-urlencoded;charset=utf-8",
      };
      var paramss = {
        cid: "TC0ONETIME",
        partner_order_id: "1001",
        partner_user_id: "dongsik",
        item_name: "포인트",
        quantity: 1,
        total_amount: 0,
        vat_amount: 200,
        tax_free_amount: 0,
        approval_url: "http://localhost:8080",
        fail_url: "http://localhost:8080",
        cancel_url: "http://localhost:8080",
      };
      //   const vm = this;
      let form = new FormData();
      form.append("amount", this.value);
      axios
        .post(url + "/v1/payment/ready", paramss, headerss, form)
        .then((res) => {
          console.log(res);
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>