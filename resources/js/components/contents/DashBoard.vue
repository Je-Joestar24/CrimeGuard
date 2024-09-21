<template>
  <div class="grid grid-cols-3 gap-4 mb-4">
    <dashboardUpper></dashboardUpper>
    <div
      class="flex items-center justify-center rounded bg-gray-50 col-span-4 shadow-lg"
    >
      <!-- dark:bg-gray-800 -->
      <p class="font-semibold font-mono p-1 text-gray-600">
        INSIGHTS
        <!-- dark:text-gray-500 -->
      </p>
    </div>
    <div
      class="rounded bg-gray-50 col-span-2 shadow-lg p-1 border"
      style="height: 40vh"
    >
      <!-- dark:text-gray-500 -->

      <section class="text-gray-600 body-font relative w-full h-full">
        <monitoringmap></monitoringmap>
      </section>
    </div>
    <incidentReports class="col-span-2"></incidentReports>
    <div
      class="flex items-center justify-center rounded bg-gray-50 col-span-4 shadow-md"
    >
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
      <div class="w-full bg-white rounded-md">
        <h1
          class="bg-white p-4 text-xl text-center border-b-2 font-bold rounded-t-md"
        >
          VICTIMS
        </h1>
        <div class="flex gap-2 px-2">
          <pc-gender-victim
            class="w-full border"
            :ids="'victimGenderPie'"
          ></pc-gender-victim>
          <pc-victim-age
            class="w-full border"
            :ids="'victimAgePie'"
          ></pc-victim-age>
        </div>
      </div>

    </div>
      <div
      class="flex items-center justify-center rounded col-span-4 bg-gray-50 shadow-md"
    >
        <div class="w-full bg-white rounded-md mt-3">
          <h1
            class="bg-white p-4 text-xl text-center border-b-2 font-bold rounded-t-md"
          >
            SUSPECTS
          </h1>
          <div class="flex gap-2 px-2">
            <pc-gender-suspect
              class="w-full border"
              :ids="'suspectGenderPie'"
            ></pc-gender-suspect>
            <pc-suspect-age
              class="w-full border"
              :ids="'suspectAgePie'"
            ></pc-suspect-age>
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
import incidentReports from "./dashboardComponents/DashBoardLowerComponents/incidentReports.vue";
import monitoringmap from "./dashboardComponents/MonitoringMap.vue";
import pcGenderVictim from "../homeComponents/Contents/contentModals/homeC/victims/pieChartsAge.vue";
import pcVictimAge from "../homeComponents/Contents/contentModals/homeC/victims/pieChartsMF.vue";
import pcSuspectAge from "../homeComponents/Contents/contentModals/homeC/Suspects/sPieChartsAge.vue";
import pcGenderSuspect from "../homeComponents/Contents/contentModals/homeC/Suspects/sPieChartsMF.vue";
export default {
  components: {
    lineCharts,
    barGraphs,
    pieCharts,
    dashboardUpper,
    incidentReports,
    monitoringmap,
    pcGenderVictim,
    pcVictimAge,
    pcSuspectAge,
    pcGenderSuspect,
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