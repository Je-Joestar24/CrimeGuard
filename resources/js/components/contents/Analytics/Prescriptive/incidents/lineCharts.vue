<template>
  <div class=" p-6 rounded-lg shadow-lg mb-6">
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
    <figure class="highcharts-figure p-3 border rounded-md">
      <div id="AnalyticsLine"></div>
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
  components: {
    barangaylists,
    incidentLists,
  },
  mounted() {
    (async () => {
      await this.getDate("date_start", 0);
      await this.getDate("date_end", 1);
      this.smonth = this.months[parseInt(this.filter.date_start.split('-')[1])];
      this.emonth = this.months[parseInt(this.filter.date_end.split('-')[1])];
      await this.getData(this.filter);
      this.chartify();
    })();
  },
  methods: {
    chartify() {
      let counts = this.arr.map((elem) => {
        return elem["count"];
      });

      Highcharts.chart("AnalyticsLine", {
        chart: {
          type: "spline", // Change from 'line' to 'spline' for curved lines
          animation: false,
        },
        title: {
          text: "INCIDENT RECORD",
          align: "center",
          style: {
            fontSize: "20px", // Adjust font size to fit smaller chart
          },
        },
        subtitle: {
          text: `FROM ${this.smonth} ${
            this.filter["date_start"].split("-")[2]
          } to ${this.emonth} ${this.filter["date_end"].split("-")[2]}, ${
            this.filter["date_end"].split("-")[0]
          }.`,
          align: "center",
          style: {
            fontSize: "15px", // Adjust font size
          },
        },
        yAxis: {
          title: {
            text: "Number of Incidents",
            style: {
              fontSize: "10px", // Adjust font size
            },
          },
        },
        xAxis: {
          accessibility: {
            rangeDescription: "Range: 2010 to 2020",
          },
        },
        legend: {
          layout: "vertical",
          align: "right",
          verticalAlign: "middle",
          itemStyle: {
            fontSize: "10px", // Adjust font size for legend items
          },
        },
        plotOptions: {
          series: {
            label: {
              connectorAllowed: false,
            },
            pointStart: 1,
            animation: false,
            marker: {
              enabled: false, // Hide point markers for smoother look
            },
          },
          spline: {
            lineWidth: 3,
            states: {
              hover: {
                lineWidth: 4,
              },
            },
            tension: 0.4, // Adjust curve tension (0-1)
          },
        },
        series: [
          {
            name: "INCIDENTS",
            data: counts,
            color: "#7cb5ec", // You can choose a custom color if desired
          },
        ],
        responsive: {
          rules: [
            {
              condition: {
                maxWidth: 400, // Adjust for smaller screens
              },
              chartOptions: {
                legend: {
                  layout: "horizontal",
                  align: "center",
                  verticalAlign: "bottom",
                },
              },
            },
          ],
        },
      });
    },
    async getData(param) {
      const send = await {
        data: param,
        url: "api/dashboard/lineraph/filtered/generate",
      };

      const data = await this.$store.dispatch("sendData", send);
      if (data["response"] == "Success") {
        this.arr = data["data"]["linegraph"];
      }
    },
    setAddress(value) {
      this.filter["barangay"] = value;
      this.barangayToggle = false;
      (async () => {
        await this.getData(this.filter);
        await this.chartify();
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
      console.log(this.filter);
      this.toggleI();
      (async () => {
        await this.getData(this.filter);
        await this.chartify();
      })();
    },
    getDate(key, add = 0) {
      const today = new Date();
      const year = today.getFullYear();
      const month = String(today.getMonth() + 1 + parseInt(add)).padStart(
        2,
        "0"
      ); // Month starts at 0, so add 1
      const day = String(today.getDate()).padStart(2, "0");
      this.filter[key] = `${year}-${month}-${day}`;
      console.log(this.filter);
    },
  },
  watch: {
    "filter.date_start": function (newVal, oldVal) {
      if (newVal != oldVal) {
        (async () => {
          await this.getData(this.filter);
          await this.chartify();
        })();
      }
    },
    "filter.date_end": function (newVal, oldVal) {
      if (newVal != oldVal) {
        (async () => {
          await this.getData(this.filter);
          await this.chartify();
        })();
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