<template>
  <figure class="highcharts-figure">
    <div :id="ids"></div>
  </figure>
</template>
  
  
  <script>
import Highcharts from "highcharts";

export default {
  data(){
    return{
      person:{
        children:0,
        adult:0,
        old:0
      },
      cred: {}
    }
  },
  props: ["ids"],
  mounted() {

    const credentials = JSON.parse(localStorage.getItem("credentials"));
    this.cred = credentials;
    (async () => {
      await this.generateData();
      await this.highChartsBargraphy();}
    )();
  },
  methods: {
    highChartsBargraphy() {
      Highcharts.chart(this.ids, {
        chart: {
          type: "pie",
        },
        title: {
          text: "Age",
        },
        tooltip: {
          valueSuffix: "",
        },
        subtitle: {
          text: 'Distribution by Common Age of Victims',
        },
        plotOptions: {
          series: {
            allowPointSelect: true,
            cursor: "pointer",
            dataLabels: [
              {
                enabled: true,
                distance: 20,
              },
              {
                enabled: true,
                distance: -40,
                format: "{point.percentage:.1f}%",
                style: {
                  fontSize: "1.2em",
                  textOutline: "none",
                  opacity: 0.7,
                },
                filter: {
                  operator: ">",
                  property: "percentage",
                  value: 10,
                },
              },
            ],
          },
        },
        series: [
          {
            name: "COUNT",
            colorByPoint: true,
            data: [
              {
                name: "CHILDREN (0-months - 19 years old)",
                sliced: this.person.children > this.person.adult && this.person.children > this.person.old,
                selected: this.person.children > this.person.adult && this.person.children > this.person.old,
                y: this.person.children,
              },
              {
                name: "ADULT (20 years - 59 years old)",
                sliced: this.person.children < this.person.adult && this.person.adult > this.person.old,
                selected: this.person.children < this.person.adult && this.person.adult > this.person.old,
                y: this.person.adult,
              },
              {
                name: "OLD (60 years and up)",
                sliced: this.person.children < this.person.old && this.person.adult < this.person.old,
                selected: this.person.children < this.person.old && this.person.adult < this.person.old,
                y: this.person.old,
              },
            ],
          },
        ],
      });
    },
    async generateData() {
      const dt = await this.$store.dispatch(
        "sendData",{
        url: "api/dashboard/generate/victims/age/pie",data: {id: this.cred['id']}}
      );

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
  
    