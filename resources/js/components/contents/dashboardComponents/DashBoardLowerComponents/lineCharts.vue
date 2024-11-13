<template>
  <div class="bg-white rounded-lg shadow-xl p-6 overflow-hidden w-full">
    <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b border-gray-200 pb-2">Incident Trend Analysis</h2>
    <div class="highcharts-figure">
      <div id="monthlyAnalytics" class="w-full h-80"></div>
      <p class="text-sm text-gray-600 mt-4 italic">
        This elegant spline chart visualizes incident report trends over the past 30 days, 
        offering crucial insights into crime patterns and facilitating data-driven policing strategies.
      </p>
    </div>
  </div>
</template>
  
  <script>
import Highcharts from "highcharts";

export default {
  data() {
    return {
      arr: [],
      cred: {}
    };
  },
  mounted() {
    
    const credentials = JSON.parse(localStorage.getItem("credentials"));
    this.cred = credentials;
    (async () => {
      await this.getData("api/dashboard/lineraph/generate");
      await this.chartify();
    })()
  },
  methods: {
    chartify() {
      let counts = this.arr.map((elem) => {return elem['count']});

      Highcharts.chart("monthlyAnalytics", {
        chart: {
          type: "spline", // Change from implicit 'line' to 'spline' for curved lines
          animation: false,
        },
        title: {
          text: "INCIDENT RECORD LAST 30 DAYS",
          align: "center",
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
            color: '#7cb5ec' // You can choose a custom color if desired
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
    async getData(param) {
      const data = await this.$store.dispatch("sendData", {url: param, data: {id: this.cred['id']}});
      if (data["response"] == "Success") {
        this.arr = await data["data"]["linegraph"];
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