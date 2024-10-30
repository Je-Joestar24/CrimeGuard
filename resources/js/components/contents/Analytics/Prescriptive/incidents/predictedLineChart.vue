<template>
  <div class="bg-violet-50 p-6 rounded-lg shadow-lg mb-6">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
      <div class="w-full md:w-auto flex gap-4 mb-4 md:mb-0">
        <input
          type="date"
          v-model="filter.date_start"
          class="px-4 py-2 border border-violet-300 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500"
        />
        <input
          type="date"
          v-model="filter.date_end"
          class="px-4 py-2 border border-violet-300 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500"
        />
      </div>
      <div class="flex gap-4">
        <div class="relative">
          <button
            v-if="!(incidentToggle && !barangayToggle)"
            @click="toggleI"
            class="bg-white hover:bg-violet-100 text-violet-700 font-semibold py-2 px-4 border border-violet-300 rounded-lg shadow transition duration-300 ease-in-out flex items-center"
            :disabled="barangayToggle"
          >
            SELECT INCIDENT
            <svg
              class="h-5 w-5 ml-2"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div
            v-else-if="incidentToggle && !barangayToggle"
            class="relative my-auto w-64 rounded-md"
          >
            <incident-lists :toggle="toggleI" :setIncident="selectIncident" />
          </div>
        </div>
        <div  class="relative">
          <button
          
            v-if="!(barangayToggle && !incidentToggle)"
            @click="toggleB"
            class="bg-white hover:bg-violet-100 text-violet-700 font-semibold py-2 px-4 border border-violet-300 rounded-lg shadow transition duration-300 ease-in-out flex items-center"
            :disabled="incidentToggle"
          >
            SELECT BARANGAY
            <svg
              class="h-5 w-5 ml-2"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div
            v-else-if="barangayToggle && !incidentToggle"
            class="  w-64 rounded-md  relative"
          >
            <barangaylists :setAddress="setAddress" :toggle="toggleB" />
          </div>
        </div>
      </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-md border border-violet-200">
      <div id="PredictedAnalyticsLine" class="w-full h-96"></div>
    </div>

    <div class="mt-10 bg-white p-6 rounded-lg shadow-md border border-violet-200">
      <h2 class="text-2xl font-bold mb-6 text-violet-700 text-center">
        PREDICTED INCIDENT CALENDAR
        <span class="text-lg font-normal text-violet-500">
          ({{ filter.date_start }} - {{ filter.date_end }})
        </span>
      </h2>
      <div class="grid grid-cols-7 gap-4">
        <div
          v-for="day in daysOfWeek"
          :key="day"
          class="font-semibold text-center text-violet-600"
        >
          {{ day }}
        </div>
        <div v-for="n in startOffset" :key="'offset-' + n"></div>
        <div
          v-for="(day, index) in daysInRange"
          :key="day.date"
          class="border rounded-lg p-3 text-center flex flex-col items-center justify-center transition-colors duration-300"
          :class="{
            'bg-violet-50 hover:bg-violet-100': day.count === 0,
            'bg-green-100 hover:bg-green-200': day.count > 0 && day.count <= 3,
            'bg-yellow-100 hover:bg-yellow-200': day.count > 3 && day.count <= 6,
            'bg-red-100 hover:bg-red-200': day.count > 6,
          }"
        >
          <span class="font-bold text-lg text-violet-800">{{ day.date.getDate() }}</span>
          <span v-if="day.count > 0" class="text-sm text-violet-600 mt-1">
            Count: {{ day.count }}
          </span>
        </div>
      </div>
    </div>
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
      filter: {
        date_start: "2024-10-25",
        date_end: "2024-11-25",
      },
      tempType: "",
      barangayToggle: false,
      incidentToggle: false,
      places: [],
      incidentT: {
        search: "",
        list: [],
      },
      daysOfWeek: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
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
      await this.getData("api/dashboard/lineraph/predict/generate");
      await this.chartify();
    })();
  },
  computed: {
    daysInRange() {
      const days = [];
      const startDate = new Date(this.filter.date_start);
      const endDate = new Date(this.filter.date_end);

      for (
        let d = new Date(startDate);
        d <= endDate;
        d.setDate(d.getDate() + 1)
      ) {
        const currentDateStr = d.toISOString().split("T")[0];
        const data = this.arr.find((entry) => entry.date === currentDateStr);
        days.push({
          date: new Date(d),
          count: data ? data.count : 0,
        });
      }
      return days;
    },
    startOffset() {
      const startDate = new Date(this.filter.date_start);
      return startDate.getDay(); // Offset for the first day of the range
    },
  },
  methods: {
    chartify() {
      let counts = this.arr.map((elem) => {
        return elem["count"];
      });

      Highcharts.chart("PredictedAnalyticsLine", {
        chart: {
          type: "spline", // Change from 'line' to 'spline' for curved lines
          animation: false,
        },
        title: {
          text:
            "PREDICTED INCIDENT TRENDS (" +
            this.filter.date_start +
            " - " +
            this.filter.date_end +
            ")",
          align: "center",
          style: {
            color: "darkviolet",
          },
        },

        subtitle: {
          text: "Source",
          align: "center",
        },

        yAxis: {
          title: {
            text: "Number of Incident",
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
        },

        plotOptions: {
          series: {
            label: {
              connectorAllowed: false,
            },
            pointStart: 1,
            marker: {
              enabled: false // Hide point markers for smoother look
            }
          },
          spline: {
            lineWidth: 3,
            states: {
              hover: {
                lineWidth: 4
              }
            },
            tension: 0.4 // Adjust curve tension (0-1)
          }
        },

        series: [
          {
            name: "INCIDENTS",
            data: counts,
            color: "darkviolet",
          },
        ],

        responsive: {
          rules: [
            {
              condition: {
                maxWidth: 500,
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
    setAddress(value) {
      this.filter["barangay"] = value;
      this.barangayToggle = false;
      (async () => {
        await this.getData("api/dashboard/lineraph/predict/generate");
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
        await this.getData("api/dashboard/lineraph/predict/generate");
        await this.chartify();
      })();
    },
    async getData(param) {
      const data = await this.$store.dispatch("sendData", {
        url: param,
        data: this.filter,
      });
      this.toggler = true;
      if (data["response"] == "Success") {
        this.arr = await data["data"]["linegraph"];
      }
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
          await this.getData("api/dashboard/lineraph/predict/generate");
          await this.chartify();
        })();
      }
    },
    "filter.date_end": function (newVal, oldVal) {
      if (newVal != oldVal) {
        (async () => {
          await this.getData("api/dashboard/lineraph/predict/generate");
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