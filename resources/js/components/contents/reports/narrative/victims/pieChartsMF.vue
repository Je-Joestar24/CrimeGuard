<template>
  <figure class="highcharts-figure">
    <div :id="ids"></div>
  </figure>
</template>

<script>
import Highcharts from "highcharts";

export default {
  data() {
    return {
      gender: {
        male: 0,
        female: 0,
      },
    };
  },
  props: ["ids"],
  mounted() {
    (async () => {
      await this.generateData();
      await this.highChartsBargraphy();
    })();
  },
  methods: {
    highChartsBargraphy() {
      Highcharts.chart(this.ids, {
        chart: {
          type: "pie",
          animation: false, // Disable animations
        },
        title: {
          text: "Gender",
        },
        subtitle: {
          text: "Most Prone Victims Gender",
        },
        tooltip: {
          valueSuffix: "",
        },
        plotOptions: {
          pie: {
            animation: false, // Disable pie slice animations
            allowPointSelect: true,
            cursor: "pointer",
            dataLabels: {
              enabled: true,
              format: "{point.name}: {point.percentage:.1f}%",
              style: {
                fontSize: "1em",
                textOutline: "none",
                opacity: 0.7,
              },
            },
          },
        },
        series: [
          {
            name: "Count",
            colorByPoint: true,
            data: [
              {
                name: "Woman",
                sliced: true,
                selected: true,
                y: this.gender.female,
              },
              {
                name: "Man",
                y: this.gender.male,
              },
            ],
          },
        ],
      });
    },
    async generateData() {
      const dt = await this.$store.dispatch("sendData", {
        url: "api/dashboard/generate/victims/gender/pie",
        data: {},
      });

      if (dt["response"] == "Success") {
        let data = dt["data"];
        this.gender = data;
      } else {
        alert("Error!");
      }
    },
  },
};
</script>

<style scoped>
.highcharts-figure {
  min-width: 360px;
  width: 100%;
  margin: 1em auto;
}
</style>
