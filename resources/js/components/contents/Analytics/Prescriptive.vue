<template>
  <predicted-line-chart v-motion-slide-visible-right />
  <bar-graphs v-motion-slide-visible-right />
  <line-charts v-motion-slide-visible-right/>

  <div class="border p-5 flex flex-col my-5" v-motion-slide-visible-right>
    <span class="font-thin text-2xl border-b w-full text-center py-2"
      >SUSPECTS PIE CHART</span
    >
    <div class="flex">
      <s-pie-charts-age :ids="'AnalyticsSuspectAge'"></s-pie-charts-age>
      <s-pie-charts-mf :ids="'AnalyticsSuspectGender'"></s-pie-charts-mf>
    </div>
  </div>

  <div class="border p-5 flex flex-col my-5" v-motion-slide-visible-right>
    <span class="font-thin text-2xl border-b w-full text-center py-2"
      >VICTIMS PIE CHART</span
    >
    <div class="flex">
      <v-pie-charts-age :ids="'AnalyticsVictimAge'"></v-pie-charts-age>
      <v-pie-charts-mf :ids="'AnalyticsVictimGender'"></v-pie-charts-mf>
    </div>
  </div>
</template>
  
  <script>
import sPieChartsAge from "./Prescriptive/Suspects/sPieChartsAge.vue";
import sPieChartsMf from "./Prescriptive/Suspects/sPieChartsMF.vue";
import vPieChartsAge from "./Prescriptive/victims/pieChartsAge.vue";
import vPieChartsMf from "./Prescriptive/victims/pieChartsMF.vue";
import barGraphs from "./Prescriptive/incidents/barGraphs.vue";
import lineCharts from "./Prescriptive/incidents/lineCharts.vue";
import predictedLineChart from "./Prescriptive/incidents/predictedLineChart.vue";

export default {
  components: {
    sPieChartsAge,
    sPieChartsMf,
    vPieChartsAge,
    vPieChartsMf,
    barGraphs,
    lineCharts,
    predictedLineChart,
  },
};
</script>