<template>
  <div>
    <form
      class="p-4 md:p-5 md:max-w-screen-md rounded-md border shadow-xs"
      :class="{
        'shadow-white  text-white border-gray-600': $store.getters.theme,
        '': !$store.getters.theme,
      }"
    >
      <!-- Form fields -->

      <div class="grid md:grid-cols-8 md:gap-6 p-5">
        <p class="col-span-2 text-lg font-bold text-end">Date start:</p>
        <div class="grid md:grid-cols-1 col-span-6 md:gap-6 group">
          <div class="relative z-0 w-full mb-5 group">
            <div class="relative z-0 w-full mb-5 group">
              <input
                type="date"
                pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none docus:outline-none focus:ring-0 peer"
                :class="{
                  'text-gray-50 arder-gray-600 dacus:border-blue-500 f':
                    $store.getters.theme,
                  'text-gray-900 border-gray-300 focus:border-blue-600':
                    !$store.getters.theme,
                }"
                placeholder=""
                required
                v-model="generate.date_start"
              />
            </div>
            <label
              for="floating_phone"
              class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
              >Start Date:</label
            >
          </div>
        </div>
        <p class="col-span-2 text-lg font-bold text-end">Date end:</p>
        <div class="grid md:grid-cols-1 col-span-6 md:gap-6 group">
          <div class="relative z-0 w-full mb-5 group">
            <input
              type="date"
              name="floating_phone"
              id="floating_phone"
              class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer"
              :class="{
                'text-gray-50  border-gray-600 focus:border-blue-500':
                  $store.getters.theme,
                'text-gray-900 border-gray-300 focus:border-blue-600':
                  !$store.getters.theme,
              }"
              placeholder=" "
              v-model="generate.date_end"
              required
            />
            <label
              for="floating_phone"
              class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
              >End Date:</label
            >
          </div>
        </div>
        <p class="col-span-2 text-lg font-bold text-end">STATUS:</p>

        <div class="col-span-6">
          <select
            v-model="generate.status"
            class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
          >
            <option selected value="">STATUS</option>
            <option value="report">REPORTED</option>
            <option value="respond">RESPONDED</option>
            <option value="reject">REJECTED</option>
            <option value="pending">PENDING</option>
            <option value="under investigation">UNDER INVESTIGATION</option>
            <option value="cleared">CLEARED</option>
            <option value="solved">SOLVED</option>
          </select>
        </div>

        <p class="col-span-2 text-lg font-bold text-end">TYPE OF INCIDENT:</p>

        <div class="relative z-0 w-full col-span-6 mb-5 group">
          <input
            type="text"
            name="floating_company"
            id="floating_company"
            class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-no00 focus:outline-none focus:ring-0 peer"
            :class="{
              'text-gray-50 tk:border-gray-60k:focus:border-blue-5':
                $store.getters.theme,
              'text-gray-900 border-gray-300 focus:border-blue-600':
                !$store.getters.theme,
            }"
            v-model="generate.tempType"
            @click="search('incidentT', generate.tempType)"
            @focusout="clearIt()"
            placeholder=" "
            required
          />
          <label
            for="floating_company"
            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >Type of Incident:</label
          >
          <div
            v-if="incidentT.list.length > 0"
            class="max-h-32 overflow-auto bg-white divide-y divide-gray-100 rounded-lg border shadow"
          >
            <ul class="py-2 text-sm text-gray-700 border-b">
              <li v-for="inc in incidentT.list" @click="data.incident_types">
                <span
                  @click.prevent="selectIncident(inc.incident_name, inc.id)"
                  class="block px-4 py-1 hover:bg-gray-100 border-b"
                  >{{ inc.incident_name }}
                  <span class="text-xs text-gray-600">{{
                    inc.sub_type != null ? `(${inc.sub_type})` : ""
                  }}</span></span
                >
              </li>
            </ul>
          </div>
        </div>

        <p class="col-span-2"></p>
        <button
          @click="printChart"
          type="button"
          class="text-white col-span-3 focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
          :class="{
            'bg-green-600 hover:bg-green-700 foutline-none focus:ring-green-800':
              $store.getters.theme,
            'bg-green-700 hover:bg-green-800 focus:ring-green-300':
              !$store.getters.theme,
          }"
        >
          GENERATE REPORT
        </button>
      </div>
    </form>
    <div id="contentPrint" class="hidden">
      <h1
        style="
          margin-bottom: 60px;
          display: flex;
          padding-right: 30px;
          padding-left: 30px;
        "
      >
        <img
          style="width: 50px; height: 50px; object-fit: cover"
          src="./logo.png"
          alt="police logo"
        />
        <span class="title" style="text-align: center; flex: 1"
          >Philippine National Police</span
        >
        <img
          style="width: 50px; height: 50px; object-fit: cover"
          src="./PoliceLogo.png"
          alt="police logo"
        />
      </h1>
      <h4 style="font-size: 10px; margin: 0px; margin-bottom: 5px">
        POLICE {{ station.name }}, {{ station.location }}, LEYTE
      </h4>
      <h4 style="font-size: 10px; margin: 0px; margin-bottom: 5px">
        CRIME NARRATIVES
      </h4>
      <h4 style="font-size: 10px; margin: 0px; margin-bottom: 5px">
        {{ start }} - {{ end }}
      </h4>
      <h4 style="font-size: 10px; margin: 0px; margin-bottom: 25px">
        Printed: {{ currentDate }}
      </h4>
      <line-charts v-if="report" :filter="generate"></line-charts>
      <bar-graphs v-if="report" :filter="generate" style="padding-bottom: 65px"></bar-graphs>
      <!-- <div style="display: flex; flex-direction: column;  padding-left: 0px; align-content: start;">
        <h1>MOST COMMON VICTIMS</h1>
      </div>
        <pie-charts-age :ids="'victimsAge'" style=" width: 600px;"></pie-charts-age>
        <pieChartsMF :ids="'victimsGender'" style=" width: 600px;"></pieChartsMF>
    --></div>
  </div>
</template>

<script>
import Highcharts from "highcharts";
import barGraphs from "./narrative/barGraphs.vue";
import lineCharts from "./narrative/lineCharts.vue";

import pieChartsAge from "./narrative/victims/pieChartsAge.vue";
import pieChartsMF from "./narrative/victims/pieChartsMF.vue";

export default {
  data() {
    return {
      arr: [],
      data: [],
      station: {},
      report: false,
      generate: {
        date_start: "",
        time_start: "",
        date_end: "",
        time_end: "",
        tempType: "",
        incident_type: -1,
        id: -1,
        status: "",
      },
      months: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],
      incidentT: {
        search: "",
        list: [],
      },
      currentDate: "",
      start: "",
      end: "",
    };
  },
  components: {
    barGraphs,
    lineCharts,
    pieChartsAge,
    pieChartsMF,
  },
  mounted() {
    const credential = JSON.parse(localStorage.getItem("credentials"));
    this.generate.id = credential.id;
  },
  methods: {
    async printChart() {
      await this.getTableData(
        this.generate,
        "api/incidents/generate/statistical/report"
      );

      this.report = !this.report;
      await this.sleep(500);
      const content = document.getElementById("contentPrint").innerHTML;
      const myWindow = window.open("", "", "width=800,height=600");
      myWindow.document.write("<html><head><title>Print Chart</title>");
      myWindow.document.write("</head><body>");
      myWindow.document.write(content);
      myWindow.document.write("</body></html>");
      myWindow.document.close();
      myWindow.focus();
      myWindow.print();
      this.report = !this.report;
    },
    async printContent() {
      await (async () => {
        const content = document.getElementById("content-to-print").innerHTML;
        const myWindow = window.open("", "", "width=800,height=600");
        myWindow.document.write("<html><head><title>Print</title>");
        myWindow.document.write("<style>" + this.printStyles() + "</style>");
        myWindow.document.write("</head><body>");
        myWindow.document.write(content);
        myWindow.document.write("</body></html>");
        myWindow.document.close();
        myWindow.focus();
        myWindow.close();
        myWindow.print();
      })();
    },
    printStyles() {
      return `
        body {
          font-family: Arial, sans-serif;
        }
        .title {
          font-size: 24px;
          font-weight: bold;
          margin-bottom: 20px;
        }
          
          *{
            font-size:12px;
          }
        .table {
          width: 100%;
          border-collapse: collapse;
        }
        .table th, .table td {
          border: 1px solid #dddddd;
          text-align: left;
          padding: 8px;
        }
        .table th {
          background-color: #f2f2f2;
        }
        .no-data {
          text-align: center;
          font-weight: bold;
          color: #555;
          height: 50px;
        }
        .print-button {
          padding: 10px 20px;
          background-color: #4CAF50;
          color: white;
          border: none;
          border-radius: 4px;
          cursor: pointer;
        }
        .print-button:hover {
          background-color: #45a049;
        }
      `;
    },
    async clearIt() {
      await this.sleep(500);
      this.incidentT.list = [];
    },
    sleep(ms) {
      return new Promise((resolve) => setTimeout(resolve, ms));
    },
    async search(key, param) {
      const send = await {
        data: { search: param },
        url: "api/incidentNames/search/Display",
      };

      const data = await this.$store.dispatch("sendData", send);
      this.res = await data["response"];

      if (this.res == "Success") {
        this[key].list = data.data;
        console.log(this[key].list);
      } else {
        await alert("An error occured, please try again.");
      }
    },
    formatDate(param) {
      const dateElems = param.split("-");
      return `${this.months[parseInt(dateElems[1]) - 1]} ${dateElems[2]}, ${
        dateElems[0]
      }`;
    },
    formatTime(hours, minutes) {
      const addLeadingZero = (num) => (num < 10 ? "0" : "") + num;

      const period = hours >= 12 ? "PM" : "AM";
      hours = hours % 12;
      hours = hours ? hours : 12; // the hour '0' should be '12'
      minutes = addLeadingZero(minutes);

      return `${hours}:${minutes} ${period}`;
    },
    async getTableData(param, url) {
      this.header = [];
      this.data = [];

      const send = await {
        data: param,
        url: url,
      };

      const data = await this.$store.dispatch("sendData", send);
      this.res = await data["response"];

      if (data.response == "Success") {
        this.header = await data["table"]["headers"];
        for (const key in this.header)
          this.header[key] = ("" + this.header[key]).toUpperCase();
        this.station = data.station;
        this.data = await data["table"]["data"];
        this.type = await data["table"]["type"];
        const now = new Date();
        const year = now.getFullYear();
        const month = now.getMonth() + 1; // Months are zero-indexed
        const day = now.getDate();
        const times = this.formatTime(now.getHours(), now.getMinutes());

        this.currentDate = `${year}-${month}-${day}`;
        this.currentDate = this.formatDate(this.currentDate) + " " + times;
        this.start = this.generate.date_start
          ? this.formatDate(this.generate.date_start)
          : "";
        this.end = this.generate.date_start
          ? this.formatDate(this.generate.date_end)
          : "";
      }
    },
    selectIncident(item, item_id) {
      this.generate.tempType = item;
      this.incidentT.list = [];
      this.generate.incident_type = item_id;
    },
  },
  watch: {
    "generate.tempType": function (newVal, oldVal) {
      if (newVal != oldVal) {
        this.search("incidentT", newVal);
      }
    },
  },
};
</script>

<style>
.highcharts-figure,
.highcharts-data-table table {
  min-width: 360px;
  width: 100%;
  margin: 1em auto;
}

.highcharts-data-table table {
  font-family: Verdana, sans-serif;
  border-collapse: collapse;
  border: 1px solid #ebebeb;
  margin: 10px auto;
  text-align: center;
  width: 100%;
  max-width: 500px;
}

.highcharts-data-table caption {
  padding: 1em 0;
  font-size: 1.2em;
  color: #555;
}

.highcharts-data-table th {
  font-weight: 600;
  padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
  padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
  background: #f8f8f8;
}

.highcharts-data-table tr:hover {
  background: #f1f7ff;
}
</style>
