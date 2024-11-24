<template>
  <figure class="highcharts-figure border-2 p-3 bg-white rounded-md shadow-lg ">
    <div id="monthlyAnalytics"></div>
    <p class="highcharts-description">
      Line chart showing Incident trends.
    </p>
  </figure>
</template>
  
  <script>
import Highcharts from "highcharts";

export default {
  data() {
    return {
      arr: [],
    };
  },
  mounted() {
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
          type: 'spline'  // Change to spline for curved lines
        },
        title: {
          text: "LATEST INCIDENT RECORDS",
          align: "center",
        },
        subtitle: {
          text: "ORMOC CITY",
          align: "center"
        },
        yAxis: {
          title: {
            text: "Number of Incidents",
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
          spline: {  // Change to spline
            marker: {
              enabled: false
            },
            lineWidth: 3,
            color: '#7cb5ec',  // A nice blue color
            shadow: true,
            states: {
              hover: {
                lineWidth: 4
              }
            }
          },
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
            data: counts
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
      const data = await this.$store.dispatch("sendData", {url: param, data: {}});
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