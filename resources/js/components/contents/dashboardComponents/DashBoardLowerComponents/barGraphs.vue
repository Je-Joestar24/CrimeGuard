<template>
    <figure class="highcharts-figure">
      <div id="barType"></div>
    </figure>
  </template>
  
  
  <script>
  import Highcharts from 'highcharts';
  
export default {
  data() {
    return {
      data: {
        barangay: [],
        count:[]
      },
    };
  },
  mounted() {
    (async () => {
      await this.generateData();
      await this.highChartsBargraphy();
    })();
  },
  methods: {
    highChartsBargraphy() {
      Highcharts.chart("barType", {
        chart: {
          type: "bar",
        },
        title: {
          text: "Ormoc City Top Barangay Incident",
          align: "left",
        },
        subtitle: {
          text: "Top 4 Barangay with the highest Incident rates",
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
          valueSuffix: " Incidents",
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
            name: "Past 30 Days, Year 2023",
            data: this.data.count,
          },
        ],
      });
    },
    async generateData() {
      const dt = await this.$store.dispatch("sendData", {
        url: "api/dashboard/generate/incident/top/barangay/bar",
        data: {},
      });

      if (dt["response"] == "Success") {
        let data = dt["data"];
        for(let i = 0; i < data.length; i ++){
          this.data.barangay.push(data[i]['barangay']);
          this.data.count.push(data[i].count);
        }
        
      } else {
        alert("Error!");
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
  
  #barType {
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