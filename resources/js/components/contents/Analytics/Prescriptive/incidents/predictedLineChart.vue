<template>
  <figure class="highcharts-figure p-3 border border-violet-600 rounded-md shadow-md shadow-violet-600 ">
    <div id="PredictedAnalyticsLine"></div>
  </figure>
</template>
  
  <script>
import { data } from "autoprefixer";
import Highcharts from "highcharts";

export default {
  data() {
    return {
      arr: [],
      filter: {
        date_start: "2024-10-25",
        date_end: "2024-11-25",
      },
    };
  },
  mounted() {
    (async () => {
      await this.getData("api/dashboard/lineraph/predict/generate");
      await this.chartify();
    })();
  },
  methods: {
    chartify() {
      let counts = this.arr.map((elem) => {
        return elem["count"];
      });

      Highcharts.chart("PredictedAnalyticsLine", {
        title: {
          text: "PREDICTED INCIDENT TRENDS NEXT MONTH",
          align: "center",
          style: {
            color: 'darkviolet'
          }
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
    async getData(param) {
      const data = await this.$store.dispatch("sendData", {
        url: param,
        data: this.filter,
      });
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