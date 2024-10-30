<template>
  <div class="p-6 rounded-lg shadow-lg mb-6">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
      <div class="w-full md:w-auto flex gap-4 mb-4 md:mb-0">
        <input
          type="date"
          v-model="filter.date_start"
          class="px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        <input
          type="date"
          v-model="filter.date_end"
          class="px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>
      <div class="flex gap-4">
        <div class="relative">
          <button
            v-if="!(incidentToggle && !barangayToggle)"
            @click="toggleI"
            class="bg-white hover:bg-blue-100 text-gray-700 font-semibold py-2 px-4 border border-blue-300 rounded-lg shadow transition duration-300 ease-in-out flex items-center"
            :disabled="barangayToggle"
          >
            SELECT INCIDENT
            <svg
              class="h-5 w-5 ml-2"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
          </button>
          <div
            v-else-if="incidentToggle && !barangayToggle"
            class="relative my-auto w-64 rounded-md"
          >
            <incident-lists :toggle="toggleI" :setIncident="selectIncident" />
          </div>
        </div>
        <div class="relative">
          <button
            v-if="!(barangayToggle && !incidentToggle)"
            @click="toggleB"
            class="bg-white hover:bg-blue-100 text-gray-700 font-semibold py-2 px-4 border border-blue-300 rounded-lg shadow transition duration-300 ease-in-out flex items-center"
            :disabled="incidentToggle"
          >
            SELECT BARANGAY
            <svg
              class="h-5 w-5 ml-2"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
          </button>
          <div
            v-else-if="barangayToggle && !incidentToggle"
            class="w-64 rounded-md relative"
          >
            <barangaylists :setAddress="setAddress" :toggle="toggleB" />
          </div>
        </div>
      </div>
    </div>
    <figure class="highcharts-figure border p-3 rounded-md">
      <div id="AnalyticsBar"></div>
    </figure>
  </div>
</template>
  
  
  <script>
import Highcharts from "highcharts";

import barangaylists from "./filters/barangaylists.vue";
import incidentLists from "./filters/incidentLists.vue";

export default {
  data() {
    return {
      data: {
        barangay: [],
        count: [],
      },
      arr: [],
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
      filter: {
        date_start: "2024-10-25",
        date_end: "2024-11-25",
      },
      tempType: "",
      barangayToggle: false,
      incidentToggle: false,
      smonth: "",
      emonth: "",
    };
  },
  mounted() {
    (async () => {
      await this.getDate("date_start", -1);
      await this.getDate("date_end", 0);
      this.smonth = this.months[parseInt(this.filter.date_start.split("-")[1])];
      this.emonth = this.months[parseInt(this.filter.date_end.split("-")[1])];
      await this.generateData();
      await this.highChartsBargraphy();
    })();
  },
  methods: {
    highChartsBargraphy() {
      Highcharts.chart("AnalyticsBar", {
        chart: {
          type: "bar",
        },
        title: {
          text: "Ormoc City Top Barangay Incident",
          align: "left",
        },
        subtitle: {
          text:
            "Top " +
            this.data.barangay.length +
            " Barangay with the highest Incident rates",
          align: "left",
        },
        xAxis: {
          categories: this.data.barangay,
          title: {
            text: null,
          },
          gridLineWidth: 1,
          lineWidth: 0,
        },
        yAxis: {
          min: 0,
          title: {
            text: "Incidents",
            align: "high",
          },
          labels: {
            overflow: "justify",
          },
          gridLineWidth: 0,
        },
        tooltip: {
          valueSuffix: " Incidents",
        },
        plotOptions: {
          bar: {
            borderRadius: "20%",
            dataLabels: {
              enabled: true,
            },
            groupPadding: 0.1,
          },
        },
        legend: {
          layout: "vertical",
          align: "right",
          verticalAlign: "top",
          x: -40,
          y: 80,
          floating: true,
          borderWidth: 1,
          backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || "#FFFFFF",
          shadow: true,
        },
        credits: {
          enabled: false,
        },
        series: [
          {
            name:
              "From date " +
              this.filter.date_start +
              " to " +
              this.filter.date_end,
            data: this.data.count,
          },
        ],
      });
    },
    async generateData() {
      const dt = await this.$store.dispatch("sendData", {
        url: "api/dashboard/generate/incident/top/barangay/bar",
        data: this.filter,
      });

      if (dt["response"] == "Success") {
        this.data.barangay = [];
        this.data.count = [];
        let data = dt["data"];
        for (let i = 0; i < data.length; i++) {
          this.data.barangay.push(data[i]["barangay"]);
          this.data.count.push(data[i].count);
        }
      } else {
        alert("Error!");
      }
    },
    setAddress(value) {
      this.filter["barangay"] = value;
      this.barangayToggle = false;
      (async () => {
        await this.generateData();
        await this.highChartsBargraphy();
      })();
    },
    toggleB() {
      this.barangayToggle = !this.barangayToggle;
    },
    toggleI() {
      this.incidentToggle = !this.incidentToggle;
    },
    selectIncident(item, item_id) {
      this.tempType = item;
      this.filter["incident_type"] = item_id;
      this.toggleI();
      (async () => {
        await this.generateData();
        await this.highChartsBargraphy();
      })();
    },
    getDate(key, add = 0) {
      const today = new Date();
      today.setMonth(today.getMonth() + add); // Adjust the month
      const year = today.getFullYear();
      const month = String(today.getMonth() + 1).padStart(2, "0"); // Month starts at 0, so add 1
      const day = String(today.getDate()).padStart(2, "0");
      this.filter[key] = `${year}-${month}-${day}`;
      console.log(this.filter);
    },
  },
  watch: {
    "filter.date_start": function (newVal, oldVal) {
      if (newVal != oldVal) {
        (async () => {
          await this.generateData();
          await this.highChartsBargraphy();
        })();
      }
    },
    "filter.date_end": function (newVal, oldVal) {
      if (newVal != oldVal) {
        (async () => {
          await this.generateData();
          await this.highChartsBargraphy();
        })();
      }
    },
  },
  components: {
    barangaylists,
    incidentLists,
  },
};
</script>
  
    
  <style scoped>
.highcharts-figure,
.highcharts-data-table table {
  min-width: 310px;
  max-width: 100%;
  margin: 1em auto;
}

#AnalyticsBar {
  height: 400px;
}

.highcharts-data-table table {
  font-family: Verdana, sans-serif;
  border-collapse: collapse;
  border: 1px solid #ebebeb;
  margin: 2px auto;
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