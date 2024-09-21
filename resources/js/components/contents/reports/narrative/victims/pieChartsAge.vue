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
      person: {
        children: 0,
        adult: 0,
        old: 0,
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
          text: "Age",
        },
        subtitle: {
          text: "Most Prone Victims Age",
        },
        tooltip: {
          valueSuffix: "%",
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
            name: "Percentage",
            colorByPoint: true,
            data: [
              {
                name: "CHILDREN (0-months - 19 years old)",
                sliced:
                  this.person.children > this.person.adult &&
                  this.person.children > this.person.old,
                selected:
                  this.person.children > this.person.adult &&
                  this.person.children > this.person.old,
                y: this.person.children,
              },
              {
                name: "ADULT (20 years - 59 years old)",
                sliced:
                  this.person.children < this.person.adult &&
                  this.person.adult > this.person.old,
                selected:
                  this.person.children < this.person.adult &&
                  this.person.adult > this.person.old,
                y: this.person.adult,
              },
              {
                name: "OLD (60 years and up)",
                sliced:
                  this.person.children < this.person.old &&
                  this.person.adult < this.person.old,
                selected:
                  this.person.children < this.person.old &&
                  this.person.adult < this.person.old,
                y: this.person.old,
              },
            ],
          },
        ],
      });
    },
    async generateData() {
      const dt = await this.$store.dispatch("sendData", {
        url: "api/dashboard/generate/victims/age/pie",
        data: {},
      });

      if (dt["response"] == "Success") {
        let data = dt["data"];
        this.person = data;
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
