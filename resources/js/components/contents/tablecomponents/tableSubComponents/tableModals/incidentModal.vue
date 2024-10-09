<template>
  <div
    tabindex="-1"
    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-20"
  >
    <div class="relative w-full max-w-6xl p-6 bg-white rounded-lg shadow-xl">
      <button
        @click="toggle"
        class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200"
      >
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
      
      <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-3 border-b">View Incident Details</h2>
      
      <div class="space-y-6">
        <basicInfo :incidentId="incidentId" />
        
        <div class="space-y-4">
          <h3 class="text-lg font-semibold text-gray-900">Involved Persons</h3>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <incidentSuspects :incidentId="incidentId" />
            <incidentWitness :incidentId="incidentId" />
            <incidentVictim :incidentId="incidentId" />
          </div>
        </div>
        
        <incidentNarrative :incidentId="incidentId" />
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
  components: {
    basicInfo,
    incidentSuspects,
    incidentWitness,
    incidentVictim,
    incidentNarrative,
  },
  props: ["toggle", "incidentId", "isHidden", "hiddenT"],
};
</script>