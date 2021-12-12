<template>
  <div>
    캘린더
    <div v-for="(house, v) in houses" :key="v">
      <button
        id="color"
        v-bind:style="{
          backgroundColor: house.color,
          width: '30px',
          height: '15px',
          color: '#ffffff',
        }"
      ></button>
      {{ house.title }}
    </div>
    <Fullcalendar :options="calendarOptions" :events="calendarOptions.events">
      <template v-slot:eventContent="arg">
        <b>{{ arg.timeText }}</b>
        <i>{{ arg.event.title }}</i>
      </template>
    </Fullcalendar>
  </div>
</template>

<script>
// import moment from "moment";
import Fullcalendar from "@fullcalendar/vue";
import DayGridPlugin from "@fullcalendar/daygrid";
import TimeGridPlugin from "@fullcalendar/timegrid";
import InteractionPlugin from "@fullcalendar/interaction";
import ListPlugin from "@fullcalendar/list";
// import { createEventId } from "./event-utils";
import axios from "axios";
export default {
  components: {
    Fullcalendar,
  },
  props: ["dong", "id"],
  mounted() {
    this.load();

    console.log("ss", this.calendarOptions.events);
  },
  data() {
    return {
      colors: ["#FFDAB9", "	#7CFC00", "	#87CEEB", "	#8A2BE2", "#FF0000"],
      postsNum: 1,
      eventss: [],
      reservedDate: [],
      houses: [],

      startDay: "",
      endDay: "",
      title: "",
      calendarOptions: {
        plugins: [DayGridPlugin, InteractionPlugin, TimeGridPlugin, ListPlugin],

        initialView: "dayGridMonth",
        // eventColor: "#e60b0b",

        events: [
          // {
          //   id: 1,
          //   title: "여행일정 잡혀있음",
          //   start: "2021-11-21",
          //   end: "2021-11-24",
          // },
          // {
          //   id: 2,
          //   title: "지성이때리는날",
          //   start: "2021-11-10",
          //   end: "2021-11-15",
          // },
        ],
        editable: false,
        selectable: true,
        selectMirror: true,
        dayMaxEvents: true,
        weekends: true,
        select: this.handleDateSelect,

        eventsSet: this.handleEvents,
      },
      currentEvents: [],
    };
  },
  methods: {
    date_add(sDate, nDays) {
      var yy = parseInt(sDate.substr(0, 4), 10);
      var mm = parseInt(sDate.substr(5, 2), 10);
      var dd = parseInt(sDate.substr(8), 10);

      var d = new Date(yy, mm - 1, dd + nDays);

      yy = d.getFullYear();
      mm = d.getMonth() + 1;
      mm = mm < 10 ? "0" + mm : mm;
      dd = d.getDate();
      dd = dd < 10 ? "0" + dd : dd;

      return "" + yy + "-" + mm + "-" + dd;
    },
    load() {
      axios
        .post("/masterReserved", {
          userId: this.$store.state.user.user.id,
        })
        .then((res) => {
          console.log("ddddddddddddd", res.data);
          console.log(res.data[0]);
          this.eventss = res.data.reserveds;
          this.houses = res.data;
          // const r = {};

          for (var k = 0; k < res.data.length; k++) {
            for (var i = 0; i < res.data[k].reserveds.length; i++) {
              const r = {
                start: res.data[k].reserveds[i].start_day,
                end: this.date_add(res.data[k].reserveds[i].end_day, 1),
                title: res.data[k].reserveds[i].title,
                id: res.data[k].reserveds[i].id,
                color: res.data[k].color,
              };
              this.calendarOptions.events.push(r);
            }
          }
        });
    },
  },
};
</script>