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
          text: 'Distribution by Common Age of Suspects',
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
            name: "Count",
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
        url: "api/dashboard/generate/suspects/age/pie",data: {id: this.cred['id']}}
      );

      if (dt["response"] == "Success") {
        let data = dt["data"];
        this.person = data;
      } else {
        alert("Error!"+this.cred);
      }
    },
  },
};
</script>
  
    
  <style scoped>
.highcharts-figure,
.highcharts-data-table table {
  min-width: 320px;
  max-width: 100%;
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

input[type="number"] {
  min-width: 50px;
}
</style>