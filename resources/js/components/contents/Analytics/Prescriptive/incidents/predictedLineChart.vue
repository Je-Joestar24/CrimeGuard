<template>
  <div class="flex justify-between">
    <div class="w-full flex gap-2">
      <input type="date" v-model="filter.date_start" />
      <input type="date" v-model="filter.date_end" />
    </div>
    <div class="flex justify-end w-full gap-3">
      <div class="relative z-0 group">
        <button
          @click="toggleI"
          class="bg-gray-50 flex gap-2 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5"
          :disabled="barangayToggle"
        >
          SELECT INCIDENT NAME
          <svg
            class="h-5 w-5 text-gray-500 my-auto"
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
      </div>
      <div class="relative z-0 group">
        <button
          @click="toggleB"
          class="bg-gray-50 flex gap-2 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5"
          :disabled="incidentToggle"
        >
          SELECT BARANGAY
          <svg
            class="h-5 w-5 text-gray-500 my-auto"
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
      </div>
      <div
        v-if="incidentToggle && !barangayToggle"
        class="absolute z-40 px-1 py-1 w-60 right-64 bg-white rounded-md shadow-sm border"
      >
        <incident-lists :toggle="toggleI" :setIncident="selectIncident" />
      </div>
      <div
        v-if="barangayToggle && !incidentToggle"
        class="absolute z-40 px-1 py-1 w-60 bg-white rounded-md shadow-lg border right-20"
      >
        <barangaylists :setAddress="setAddress" :toggle="toggleB" />
      </div>
    </div>
  </div>
  <figure
    class="highcharts-figure p-3 border border-violet-600 rounded-md shadow-md shadow-violet-600"
  >
    <div id="PredictedAnalyticsLine"></div>
  </figure>

  <div
    class="container mx-auto mt-10 p-5 border border-violet-600 rounded-md shadow-md shadow-violet-600 mb-5"
  >
    <div class="text-center text-2xl font-bold mb-4 text-violet-500">
      PREDICTED INCIDENT CALENDAR ({{ filter.date_start }} -
      {{ filter.date_end }})
    </div>
    <div class="grid grid-cols-7 gap-2">
      <!-- Render days of the week -->
      <div
        v-for="day in daysOfWeek"
        :key="day"
        class="font-semibold text-center text-violet-400"
      >
        {{ day }}
      </div>
      <div v-for="n in startOffset" :key="'offset-' + n"></div>

      <div
        v-for="(day, index) in daysInRange"
        :key="day.date"
        class="border rounded p-2 text-center flex flex-col items-center"
        :class="{
          'bg-gray-100': day.count === 0,
          'bg-green-100': day.count > 0 && day.count <= 3,
          'bg-yellow-100': day.count > 3 && day.count <= 6,
          'bg-red-100': day.count > 6,
        }"
      >
        <span class="font-bold">{{ day.date.getDate() }}</span>
        <span v-if="day.count > 0" class="text-sm text-gray-700"
          >Count: {{ day.count }}</span
        >
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
          },
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
      const year = today.getFullYear();
      const month = String(today.getMonth() + 1 + parseInt(add)).padStart(
        2,
        "0"
      ); // Month starts at 0, so add 1
      const day = String(today.getDate()).padStart(2, "0");
      this.filter[key] = `${year}-${month}-${day}`;
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