<template>
  <div>
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
import { createEventId } from "./event-utils";
import axios from "axios";
export default {
  components: {
    Fullcalendar,
  },
  props: ["dong", "id", "color"],
  mounted() {
    this.load();

    console.log("colorrrrrrrrrrrrrr", this.color);
  },
  data() {
    return {
      postsNum: 1,
      eventss: [],
      reservedDate: [],

      startDay: "",
      endDay: "",
      title: "",
      calendarOptions: {
        plugins: [DayGridPlugin, InteractionPlugin, TimeGridPlugin, ListPlugin],

        initialView: "dayGridMonth",
        eventColor: "#e60b0b",

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
        eventClick: this.handleEventClick,
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
        .post("/loadreserve", {
          postNum: this.id,
        })
        .then((res) => {
          console.log(res.data[0]);
          this.eventss = res.data;
          // const r = {};
          for (var i = 0; i < res.data.length; i++) {
            const r = {
              start: res.data[i].start_day,
              end: this.date_add(res.data[i].end_day, 1),
              title: res.data[i].title,
              id: res.data[i].id,
              color: this.color,
            };
            this.calendarOptions.events.push(r);
          }
        });
    },
    handleDateSelect(selectInfo) {
      console.log("ss", selectInfo);
      let title = prompt("예약자성함을 입력해주세요!");
      let calendarApi = selectInfo.view.calendar;

      calendarApi.unselect(); // clear date selection

      if (title) {
        this.startDay = selectInfo.startStr;

        this.endDay = this.date_add(selectInfo.endStr, -1);
        console.log("eeeee222222", this.endDay);
        console.log("22222");
        var clickdatearr = this.getDatesStartToLast(this.startDay, this.endDay);
        // console.log("dddddddddddd", datearr);

        for (var i = 0; i < this.calendarOptions.events.length; i++) {
          // console.log("aqqqqqqqqqqqqqqqqq");
          var arr = this.getDatesStartToLast(
            this.calendarOptions.events[i].start,
            this.date_add(this.calendarOptions.events[i].end, -1)
          );

          this.reservedDate = this.reservedDate.concat(arr);
        }
        console.log("aaaaaaaaaaaaaaa", this.reservedDate);
        var arrrr = clickdatearr.filter((x) => this.reservedDate.includes(x));
        if (arrrr.length != 0) {
          alert("이미예약되어있음");
        } else {
          calendarApi.addEvent({
            id: createEventId(),
            //   id: 1,
            title,
            color: this.color,

            start: selectInfo.startStr,
            end: selectInfo.endStr,
            allDay: selectInfo.allDay,
          });
          // this.handleEventClick(1);
          // console.log(start);

          const object = {
            startDay: selectInfo.startStr,
            endDay: this.date_add(selectInfo.endStr, -1),
            title: title,
          };
          this.$emit("scor", object);

          this.eventss.push({
            startDay: this.startDay,
            endDay: this.date_add(selectInfo.endStr, -1),
            id: this.id,
            title: "asd",
            color: this.color,
          });

          console.log("qq", this.calendarOptions.initialEvents);
          console.log("ddddd", this.startDay);
        }

        // if(this.calendarOptions.events.)
        // var vm = this;
      }
    },
    handleEventClick(clickInfo) {
      if (clickInfo == 1) {
        clickInfo.event.remove();
      } else {
        if (
          confirm(
            `Are you sure you want to delete the event '${clickInfo.event.title}'`
          )
        ) {
          clickInfo.event.remove();
        }
      }
    },
    handleEvents(events) {
      this.currentEvents = [];
      for (var i = 0; i < events.length; i++) {
        this.currentEvents.push(events[i]);
      }
      console.log("easdas", events);
    },
    getDatesStartToLast(startDate, lastDate) {
      var regex = RegExp(/^\d{4}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/);
      if (!(regex.test(startDate) && regex.test(lastDate)))
        return "Not Date Format";
      var result = [];
      var curDate = new Date(startDate);
      while (curDate <= new Date(lastDate)) {
        result.push(curDate.toISOString().split("T")[0]);
        curDate.setDate(curDate.getDate() + 1);
      }
      return result;
    },
  },
};
</script>