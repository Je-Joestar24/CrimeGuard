<template>
  <div style="width: 100vw; display: flex; justify-content: center">
    <figure class="highcharts-figure">
      <div id="monthlyAnalytics"></div>
      <p class="highcharts-description">
        Line chart showing Incident trends
        <span v-if="filter['date_start'] != ''"
          >from {{ smonth }} {{ filter["date_start"].split("-")[2] }},
          {{ filter["date_start"].split("-")[0] }}
          <span v-if="filter['date_end'] != ''">
            to {{ emonth }} {{ filter["date_end"].split("-")[2] }},
            {{ filter["date_end"].split("-")[0] }}.</span
          ></span>
          <span v-if="filter['date_end'] == ''"> to current day.</span>
      </p>
    </figure>
  </div>
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

      Highcharts.chart("monthlyAnalytics", {
        chart: {
          type: "line",
          animation: false, // Disable animations
          width: 600, // Set a smaller width
          height: 300, // Set a smaller height
        },
        title: {
          text: "INCIDENT RECORD",
          align: "center",
          style: {
            fontSize: "14px", // Adjust font size to fit smaller chart
          },
        },
        subtitle: {
          text: "Source",
          align: "center",
          style: {
            fontSize: "10px", // Adjust font size
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
  props: ["filter"],
};
</script>

<style scoped>
.highcharts-figure {
  max-width: 1200px; /* Limit the figure width to match the chart size */
  margin: 0 auto; /* Center the figure */
  border: 5px solid green; /* Add a green border */
  padding: 5px; /* Add some padding inside the border */
}

.highcharts-description {
  font-size: 15px; /* Adjust the font size for the description */
  text-align: center; /* Center the description text */
}
</style>
