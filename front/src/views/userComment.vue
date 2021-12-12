<template>
  <v-container>
    <div>
      <start-rating @rating-selected="rr" v-model="stars"></start-rating>
    </div>
    <v-form @submit.prevent="onSubmit" id="form">
      <v-row>
        <v-col cols="6">
          <v-text-field
            v-model="cmt"
            :prepend-icon="icon"
            filled
            clear-icon="mdi-close-circle"
            clearable
            label="Comment"
            type="text"
            @click:append="toggleMarker"
            @click:append-outer="sendMessage"
            @click:prepend="changeIcon"
            @click:clear="clearMessage"
          ></v-text-field>
        </v-col>
        <v-col cols="6"
          ><v-btn color="#2E64FE" id="submitbutton" type="submit"
            >등록
          </v-btn></v-col
        >
      </v-row>
    </v-form>
    <div v-for="(comment, v) in comments" :key="v">
      <div class="media">
        <div class="media-left">
          <img
            src="http://fakeimg.pl/50x50"
            class="media-object"
            style="width: 40px"
          />
        </div>
        <div class="media-body">
          <h4 class="media-heading title">{{ comment.users.name }}</h4>
          <p class="komen">
            {{ comment.comment }}
            <v-rating
              v-model="comment.star"
              background-color="orange lighten-3"
              color="#FFFF00"
            ></v-rating>
          </p>
        </div>
      </div>

      <div v-if="(userState == 'master') & (userId == house.user_id)">
        <button @click="open(v, comment.id)">답글쓰기</button>

        <collapse-transition>
          <div v-if="x == v">
            <v-row>
              <v-col cols="6">
                <v-textarea
                  label="One row"
                  v-model="masterContent"
                  auto-grow
                  outlined
                  rows="1"
                  row-height="15"
                ></v-textarea>
              </v-col>
              <v-col cols="6">
                <v-btn
                  type="button"
                  color="#2E64FE"
                  @click="masterComment(comment.id, comment.user_id)"
                >
                  등록
                </v-btn>
              </v-col>
            </v-row>

            <div v-for="(com, v) in masterComments" :key="v">
              <div class="geser">
                <div class="media">
                  <div class="media-left">
                    <img
                      src="http://fakeimg.pl/50x50"
                      class="media-object"
                      style="width: 40px"
                    />
                  </div>
                  <div class="media-body">
                    <h4 class="media-heading title">관리자</h4>
                    <p class="komen">{{ com.reComment }}<br /></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </collapse-transition>
      </div>

      <div v-else>
        <button @click="isOpens(comment.id, v)">답글확인</button>

        <collapse-transition>
          <div v-if="userId == comment.user_id">
            <div v-if="x == v">
              <div @click="x = 100">올리기</div>
              <div v-for="(comment, v) in reCommend" :key="v">
                <div class="geser">
                  <div class="media">
                    <div class="media-left">
                      <img
                        src="http://fakeimg.pl/50x50"
                        class="media-object"
                        style="width: 40px"
                      />
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading title">관리자</h4>
                      <p class="komen">{{ comment.reComment }}<br /></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <div v-if="x == v">
              <div @click="x = 100">올리기</div>
              <div class="geser">
                <div class="media">
                  <div class="media-left">
                    <img
                      src="http://fakeimg.pl/50x50"
                      class="media-object"
                      style="width: 40px"
                    />
                  </div>
                  <div class="media-body">
                    <p class="komen">비밀글입니다<br /></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </collapse-transition>
      </div>
      <hr />
    </div>

    <comment-pagenate
      :links="posts.links"
      v-if="posts.links != null"
      v-on:pageClicked="getPage"
    />
  </v-container>
</template>

<script>
import { CollapseTransition } from "@ivanv/vue-collapse-transition";
import CommentPagenate from "./pagination.vue";
import axios from "axios";
import StartRating from "vue-star-rating";
export default {
  props: ["house"],
  components: {
    CollapseTransition,
    StartRating,
    CommentPagenate,
  },
  data() {
    return {
      x: 100,
      masterComments: [],
      reservedUser: "",
      isOpen: false,
      userState: "",
      masterContent: "",
      reCommend: [],
      listData: [],
      userId: "",
      page: 1,
      limit: 5,
      block: 5,
      posts: [],
      cmt: "",
      comments: [],
      stars: "",
      star: "",
      marker: true,
      iconIndex: 0,
      icons: [
        "mdi-emoticon",
        "mdi-emoticon-cool",
        "mdi-emoticon-dead",
        "mdi-emoticon-excited",
        "mdi-emoticon-happy",
        "mdi-emoticon-neutral",
        "mdi-emoticon-sad",
        "mdi-emoticon-tongue",
      ],
    };
  },
  mounted() {
    console.log("uuuuuuuuuuuuuuuuuuuu", this.$store.state.user.user.id);
    console.log("aaaaaaaaaaaaaaaaaaaa", this.house);
    this.userState = this.$store.state.user.user.state;
    this.userId = this.$store.state.user.user.id;
    this.isUser();
    this.commentLoad();
  },
  methods: {
    isUser() {
      axios
        .post("/isUser", {
          userId: this.userId,
          houseId: this.house.id,
        })
        .then((res) => {
          console.log("resssssssssssss", res.data);
          if (res.data == 1) {
            this.reservedUser = 1;
          } else {
            this.reservedUser = 0;
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    open(v, commentId) {
      this.x = v;
      this.masterCommentLoad(commentId);
    },
    isOpens(comment, v) {
      this.reCommentLoad(comment);
      this.x = v;
    },
    reCommentLoad(commentId) {
      axios
        .post("/reCommentLoad", {
          userId: this.$store.state.user.user.id,
          commentId,
          houseId: this.house.id,
        })
        .then((res) => {
          this.reCommend = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    masterComment(commentId, writeUser) {
      axios
        .post("/masterComment", {
          writeUser,
          masterContent: this.masterContent,
          userId: this.$store.state.user.user.id,
          commentId,
          houseId: this.house.id,
        })
        .then((res) => {
          console.log(res.data);
          this.masterCommentLoad(commentId);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    masterCommentLoad(commentId) {
      axios
        .post("/masterCommentLoad", {
          commentId,
        })
        .then((res) => {
          this.masterComments = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getPage(url2) {
      console.log("sssssssssssssssss", url2);
      axios
        .get(url2)
        .then((res) => {
          this.comments = res.data.data;
          this.posts = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    onSubmit() {
      if (this.reservedUser == 1) {
        axios
          .post("/comment", {
            houseId: this.house.id,
            star: this.star,
            comment: this.cmt,
            userId: this.$store.state.user.user.id,
          })
          .then(() => {
            alert("댓글등록완료");
            this.commentLoad();
          })
          .catch((err) => {
            console.log(err);
          });
      } else {
        alert("예약된 사용자만 댓글을 입력할수있습니다.");
      }
    },
    rr() {
      console.log(this.stars);
      this.star = this.stars;
    },
    commentLoad() {
      axios
        .get("/commentLoad/" + this.house.id)
        .then((res) => {
          this.comments = res.data.data;
          this.posts = res.data;
          console.log("cccccccccccccccccc", res);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    toggleMarker() {
      this.marker = !this.marker;
    },
    sendMessage() {
      this.resetIcon();
      this.clearMessage();
    },
    clearMessage() {
      this.message = "";
    },
    resetIcon() {
      this.iconIndex = 0;
    },
    changeIcon() {
      this.iconIndex === this.icons.length - 1
        ? (this.iconIndex = 0)
        : this.iconIndex++;
    },
  },
  computed: {
    icon() {
      return this.icons[this.iconIndex];
    },
  },
};
</script>
<style>
#form {
  /* position: relative; */
}
.title {
  font-size: 14px;
  font-weight: bold;
}
.komen {
  font-size: 14px;
}
.geser {
  margin-left: 55px;
  margin-top: 5px;
}
#submitbutton {
  margin-top: 20px;
}
</style>