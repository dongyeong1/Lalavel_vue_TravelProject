<template>
  <div class="animated fadeIn">
    <b-card-group deck>
      <b-card
        v-for="(club, index) in currentPageClubs"
        :key="index"
        img-src="https://placekitten.com/g/300/300"
        img-alt="Img"
        img-top
      >
        <h4 class="card-title">
          {{ club.description }}
        </h4>
        <p class="card-text">
          {{ club.price }}
        </p>
        <p class="card-text">
          {{ club.country }}
        </p>
        <div slot="footer">
          <b-btn variant="primary" block>Add</b-btn>
        </div>
      </b-card>
    </b-card-group>

    <div class="card-pagination">
      <div
        class="page-index"
        v-for="i in nbPages"
        :key="i"
        @click="goto(i)"
        :class="{ active: currentPage(i) }"
      ></div>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      clubs: [
        {
          id: 1,
          description:
            "chelsea is the best club in the world and chelsea has a great player",
          price: 1000,
          country: "england",
        },
        {
          id: 2,
          description: "liverpool has salah",
          price: 900,
          country: "england",
        },
        { id: 3, description: "mu fans", price: 800, country: "england" },
        {
          id: 4,
          description: "city has a great coach. Thas is guardiola",
          price: 700,
          country: "england",
        },
        {
          id: 5,
          description: "arsenal player",
          price: 600,
          country: "england",
        },
        {
          id: 6,
          description: "tottenham in london",
          price: 500,
          country: "england",
        },
        {
          id: 7,
          description: "juventus stadium",
          price: 400,
          country: "italy",
        },
        {
          id: 8,
          description: "madrid sell ronaldo",
          price: 300,
          country: "spain",
        },
        {
          id: 9,
          description: "barcelona in the spain",
          price: 200,
          country: "spain",
        },
        {
          id: 10,
          description: "psg buys neymar at a fantastic price",
          price: 100,
          country: "france",
        },
      ],
      paginatedClubs: [],
      nbPages: 0,
      nbRowPerPage: 4,
      currentPageIndex: 0,
    };
  },
  computed: {
    formattedClubs() {
      return this.clubs.reduce((c, n, i) => {
        if (i % 4 === 0) c.push([]);
        c[c.length - 1].push(n);
        return c;
      }, []);
    },
    currentPageClubs() {
      this.createPages();

      return this.paginatedClubs[this.currentPageIndex];
    },
  },
  methods: {
    currentPage(i) {
      return i - 1 === this.currentPageIndex;
    },
    createPages() {
      let lengthAll = Object.keys(this.clubs).length;
      this.nbPages = 0;
      for (let i = 0; i < lengthAll; i = i + this.nbRowPerPage) {
        this.paginatedClubs[this.nbPages] = this.clubs.slice(
          i,
          i + this.nbRowPerPage
        );
        this.nbPages++;
      }
    },
    goto(i) {
      this.currentPageIndex = i - 1;
    },
  },
};
</script>
<style>
.card-pagination {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
}
.page-index {
  margin-left: 10px;
  width: 15px;
  height: 15px;
  border-radius: 15px;
  background: #007bff;
}
.active {
  width: 20px;
  height: 20px;
  border-radius: 20px;
}
