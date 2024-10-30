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
      <div class="relative">
        <button
          v-if="!incidentToggle"
          @click="toggleI"
          class="bg-white hover:bg-violet-100 text-violet-700 font-semibold py-2 px-4 border border-violet-300 rounded-lg shadow transition duration-300 ease-in-out flex items-center"
          :disabled="barangayToggle"
        >
          SELECT INCIDENT NAME
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
          v-else-if="incidentToggle"
          class="relative w-64 "
        >
          <incident-lists :toggle="toggleI" :setIncident="selectIncident" />
        </div>
      </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-md border border-violet-200">
      <div id="predictedBar" class="w-full h-96"></div>
    </div>
  </div>
</template>
  
  
  <script>
import Highcharts from "highcharts";
import incidentLists from "./filters/incidentLists.vue";

export default {
  data() {
    return {
      tempType: "",
      data: {
        barangay: [],
        count: [],
      },
      incidentToggle: false,
      filter: {
        date_start: "2024-10-25",
        date_end: "2024-11-25",
      },
      incidentT: {
        search: "",
        list: [],
      },
    };
  },
  mounted() {
    (async () => {
      await this.getDate("date_start", 0);
      await this.getDate("date_end", 1);
      await this.generateData();
      await this.highChartsBargraphy();
    })();
  },
  components: {
    incidentLists,
  },
  methods: {
    highChartsBargraphy() {
      Highcharts.chart("predictedBar", {
        chart: {
          type: "bar",
        },
        title: {
          text:
            "PREDICTED TOP BARANGAY ( " +
            this.filter.date_start +
            " - " +
            this.filter.date_end +
            " )",
          align: "center",
          style: {
            color: "darkviolet",
          },
        },
        subtitle: {
          text:
            "Top " + this.data.count.length + " Barangay with the high chance",
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
          valueSuffix: " %",
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
            name: "Probability",
            data: this.data.count,
            color: "darkviolet",
          },
        ],
      });
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
        await this.generateData();
        await this.highChartsBargraphy();
      })();
    },
    async generateData() {
      const dt = await this.$store.dispatch("sendData", {
        url: "api/incidents/top/baragay/prediction/display",
        data: this.filter,
      });
      this.data.barangay = [];
      this.data.count = [];
      if (dt["response"] == "Success") {
        let data = dt["data"];
        for (let i = 0; i < data.length; i++) {
          this.data.barangay.push(data[i]["barangay"]);
          this.data.count.push(data[i].probability);
        }
      } else {
        alert("Error!");
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
};
</script>
  
    
  <style scoped>
.highcharts-figure,
.highcharts-data-table table {
  min-width: 310px;
  max-width: 100%;
  margin: 1em auto;
}

#predictedBar {
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
