<template>
  <div class="grid grid-cols-3 gap-4 mb-4">
    <dashboardUpper class="col-span-3"></dashboardUpper>
    <div
      class="flex items-center justify-center rounded bg-gray-50 col-span-4 shadow-lg"
    >
      <!-- dark:bg-gray-800 -->
      <p class="font-semibold font-mono p-1 text-gray-600">
        INSIGHTS
        <!-- dark:text-gray-500 -->
      </p>
    </div>
    <monitoringmap />
    <predicted-incident/>
    <div class="flex items-center justify-center col-span-4">
      <lineCharts></lineCharts>
    </div>
    <div
      class="flex items-center justify-center rounded col-span-4 bg-gray-50 shadow-md"
    >
      <barGraphs></barGraphs>
    </div>
    <div
      class="flex items-center justify-center rounded col-span-4 bg-gray-50 shadow-md"
    >
      <div class="w-full">
        <h2
          class="text-2xl font-bold text-gray-800 p-6 border-b border-gray-200"
        >
          Victim Analysis
        </h2>
        <p class="text-gray-600 px-6 pb-4 text-sm">
          Comprehensive breakdown of victim demographics to aid in support and
          prevention strategies.
        </p>
        <div class="flex flex-col md:flex-row gap-4 p-6">
          <div
            class="flex-1 bg-gray-100 rounded-lg p-4 transition-all duration-300 hover:bg-gray-200"
          >
            <h3 class="text-lg font-semibold text-gray-800 mb-2">
              Gender Distribution
            </h3>
            <pc-gender-victim
              class="w-full"
              :ids="'victimGenderPie'"
            ></pc-gender-victim>
          </div>
          <div
            class="flex-1 bg-gray-100 rounded-lg p-4 transition-all duration-300 hover:bg-gray-200"
          >
            <h3 class="text-lg font-semibold text-gray-800 mb-2">
              Age Demographics
            </h3>
            <pc-victim-age class="w-full" :ids="'victimAgePie'"></pc-victim-age>
          </div>
        </div>
      </div>
    </div>
    <div class="col-span-4 bg-white rounded-lg shadow-xl overflow-hidden">
      <div class="w-full">
        <h2
          class="text-2xl font-bold text-gray-800 p-6 border-b border-gray-200"
        >
          Suspect Analysis
        </h2>
        <p class="text-gray-600 px-6 pb-4 text-sm">
          Comprehensive breakdown of suspect demographics to aid in profiling
          and prevention strategies.
        </p>
        <div class="flex flex-col md:flex-row gap-4 p-6">
          <div
            class="flex-1 bg-gray-100 rounded-lg p-4 transition-all duration-300 hover:bg-gray-200"
          >
            <h3 class="text-lg font-semibold text-gray-800 mb-2">
              Gender Distribution
            </h3>
            <pc-gender-suspect
              class="w-full"
              :ids="'suspectGenderPie'"
            ></pc-gender-suspect>
          </div>
          <div
            class="flex-1 bg-gray-100 rounded-lg p-4 transition-all duration-300 hover:bg-gray-200"
          >
            <h3 class="text-lg font-semibold text-gray-800 mb-2">
              Age Demographics
            </h3>
            <pc-suspect-age
              class="w-full"
              :ids="'suspectAgePie'"
            ></pc-suspect-age>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import barGraphs from "./dashboardComponents/DashBoardLowerComponents/barGraphs.vue";
import lineCharts from "./dashboardComponents/DashBoardLowerComponents/lineCharts.vue";
import pieCharts from "./dashboardComponents/DashBoardLowerComponents/pieCharts.vue";
import dashboardUpper from "./dashboardComponents/DashboardUpper.vue";
import monitoringmap from "./dashboardComponents/MonitoringMap.vue";
import pcGenderVictim from "./dashboardComponents/DashBoardLowerComponents/victims/pieChartsAge.vue";
import pcVictimAge from "./dashboardComponents/DashBoardLowerComponents/victims/pieChartsMF.vue";
import pcSuspectAge from "./dashboardComponents/DashBoardLowerComponents/Suspects/sPieChartsAge.vue";
import pcGenderSuspect from "./dashboardComponents/DashBoardLowerComponents/Suspects/sPieChartsMF.vue";
import predictedIncident from "./dashboardComponents/predictedIncident.vue";

export default {
  components: {
    lineCharts,
    barGraphs,
    pieCharts,
    dashboardUpper,
    monitoringmap,
    pcGenderVictim,
    pcVictimAge,
    pcSuspectAge,
    pcGenderSuspect,
    predictedIncident
  },
  data() {
    return {
      cards: [
        {
          icons: {
            paths: [],
          },
          count: 0,
          name: "",
        },
      ],
    };
  },
};
</script>