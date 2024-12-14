<template>
  <div class="flex justify-center space-x-4 mb-8">
    <button
      @click="activeView = 'predictive'"
      :class="[
        'px-4 py-2 rounded-md',
        activeView === 'predictive'
          ? 'bg-blue-500 text-white'
          : 'bg-gray-200 text-gray-700',
      ]"
    >
      Predictive Analytics
    </button>
    <button
      @click="activeView = 'prescriptive'"
      :class="[
        'px-4 py-2 rounded-md',
        activeView === 'prescriptive'
          ? 'bg-blue-500 text-white'
          : 'bg-gray-200 text-gray-700',
      ]"
    >
      Dscriptive Analytics
    </button>
  </div>

  <div v-if="activeView === 'predictive'" v-motion-slide-visible>
    <h1 class="text-3xl font-bold mb-6">PREDICTIVE ANALYTICS</h1>
    <div>
      <predicted-line-chart v-motion-slide-visible-right />
      <div class="grid grid-cols-2 gap-4 bg-violet-50 p-6 rounded-lg shadow-lg mb-6">
        <predict-topbarangay />
        <predict-top-incidents class="mb-5" />
      </div>
    </div>
  </div>

  <div v-else-if="activeView === 'prescriptive'" v-motion-slide-visible>
    
    <h1 class="text-3xl font-bold mb-6">PRESCRIPTIVE ANALYTICS</h1>
    <bar-graphs v-motion-slide-visible-right />
    <line-charts v-motion-slide-visible-right />
    <div>
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
import PredictTopbarangay from "./Prescriptive/incidents/predictTopbarangay.vue";
import PredictTopIncidents from "./Prescriptive/incidents/predictTopIncidents.vue";

export default {
  components: {
    sPieChartsAge,
    sPieChartsMf,
    vPieChartsAge,
    vPieChartsMf,
    barGraphs,
    lineCharts,
    predictedLineChart,
    PredictTopbarangay,
    PredictTopIncidents,
  },
  data() {
    return {
      activeView: "predictive",
    };
  },
};
</script>