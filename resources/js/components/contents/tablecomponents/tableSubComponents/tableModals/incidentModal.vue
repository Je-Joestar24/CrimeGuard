<template>
  <div
    tabindex="-1"
    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-20"
  >
    <div class="relative w-full max-w-6xl">
      <div class="relative bg-white rounded-lg border shadow-2xl">
        <button
          type="button"
          class="absolute top-3 right-3 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
          @click.prevent="toggle()"
        >
          <svg
            class="w-3 h-3"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 14 14"
          >
            <path
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
            />
          </svg>
          <span class="sr-only">Close modal</span>
        </button>
        <div class="p-4 md:p-5 text-center">
          <div
            class="flex text-xl text-black font-bold justify-center mb-5 border-b pb-5"
          >
            VIEW DETAILS
          </div>
          <div>
            <!-- Basic info -->
            <basicInfo :incidentId="incidentId"></basicInfo>
            <h1
              class="text-md py-2 rounded-md border-b border-gray-400 mb-1 font-bold text-gray-900 mt-4"
            >
              INVOLVED PESONS
            </h1>
            <div
              class="flex flex-col rounded-lg border border-gray-300 shadow-sm"
              style="height: 45vh"
            >
              <div class="flex gap-0.5">
                <incidentSuspects :incidentId="incidentId"></incidentSuspects>
                <incidentWitness :incidentId="incidentId"></incidentWitness>
                <incidentVictim :incidentId="incidentId"></incidentVictim>
              </div>
              <incidentNarrative :incidentId="incidentId"></incidentNarrative>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import basicInfo from "./viewModalComponents/incident/basic.vue";
import incidentNarrative from "./viewModalComponents/incident/incidentNarrative.vue";
import incidentSuspects from "./viewModalComponents/incident/incidentSuspects.vue";
import incidentVictim from "./viewModalComponents/incident/incidentVictim.vue";
import incidentWitness from "./viewModalComponents/incident/incidentWitness.vue";

export default {
  data() {
    return {};
  },
  props: ["toggle", "incidentId", "isHidden", "hiddenT"],
  created() {},
  components: {
    basicInfo,
    incidentSuspects,
    incidentWitness,
    incidentVictim,
    incidentNarrative,
  },
};
</script>