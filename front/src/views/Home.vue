<template>
  <v-container>
    <v-row>
      <v-col v-for="item in items" :key="item.title" cols="3">
        <v-card class="pa-3" :to="item.to">
          <v-card-title>
            {{ item.title }}
          </v-card-title>
          <v-icon size="100px" color="green">{{ item.icon }}</v-icon>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      client_id: "5Gakk1RlhGu4lduKfdUx",
      client_secret: "BLGoVOeOJR",
      items: [
        {
          title: "게시판",
          icon: "mdi-pen",
          to: "/create",
        },
        {
          title: "번역기",
          icon: "mdi-autorenew",
          to: "/trance",
        },
        {
          title: "나의단어장",
          icon: "mdi-content-paste",
          to: "",
        },
        {
          title: "복습하기",
          icon: "mdi-theater",
          to: "",
        },
      ],
    };
  },
  created() {},
};
</script>
