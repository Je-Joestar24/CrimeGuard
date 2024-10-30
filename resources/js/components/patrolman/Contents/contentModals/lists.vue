<template>
  <div v-if="!isPhone" class="w-full flex justify-center" style="">
    <div
      class="w-3/4 flex justify-center rounded-xl"
      style="
        height: 90vh;
        background-color: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(10px);
      "
    >
      <reportedincidents
        v-if="active == 'Reported Incidents'"
      ></reportedincidents>
      <recentincidents v-if="active == 'Recent Incidents'"></recentincidents>
    </div>
  </div>

  <div class="px-4 bg-gray-100" v-if="isPhone">
    <recentincidents v-if="active == 'Recent Incidents'"></recentincidents>
    <reportedincidents
      v-if="active == 'Reported Incidents'"
    ></reportedincidents>
  </div>
</template>

<script>
import recentincidents from "./lists/RecentIncidents.vue";
import reportedincidents from "./lists/ReportedIncidents.vue";

export default {
  components: {
    recentincidents,
    reportedincidents,
  },
  props: ["active"],
  computed: {
    isPhone() {
      return window.innerWidth <= 768;
    },
  },
};
</script>