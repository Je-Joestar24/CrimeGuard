<template>
  <figure class="highcharts-figure p-3 border rounded-md">
    <div id="AnalyticsLine"></div>
  </figure>
</template>
  
  <script>
import Highcharts from "highcharts";

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
      smonth: "",
      emonth: "",
      filter: { date_start: "2024-0-1", date_end: "2024-8-1" },
    };
  },
  mounted() {
    (async () => {
      await this.getData(this.filter);
      this.smonth =
        this.months[parseInt(this.filter["date_start"].split("-")[1])];
      this.emonth =
        this.months[parseInt(this.filter["date_end"].split("-")[1])];
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
          type: "line",
          animation: false, // Disable animations
        },
        title: {
          text: "INCIDENT RECORD",
          align: "center",
          style: {
            fontSize: "20px", // Adjust font size to fit smaller chart
          },
        },
        subtitle: {
          text: `FROM ${this.smonth} ${this.filter["date_start"].split("-")[2]} to ${this.emonth} ${this.filter["date_end"].split("-")[2]}, ${this.filter["date_end"].split("-")[0]}.`,
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
            animation: false, // Disable series animations
          },
        },
        series: [
          {
            name: "INCIDENTS",
            data: counts,
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