<template>
  <div>
    <div>
      <!-- <accountR v-if="activePage == 'regRequests'"></accountR> 
      <incidentR v-if="'reportedIncidents' == activePage"></incidentR> -->
      <incidentR></incidentR>
    </div>
  </div>
</template>

<script>
import accountR from "./requests/accountR.vue";
import incidentR from "./requests/incidentR.vue";
import searchBar from "./tablecomponents/tableSubComponents/tableFuntions/searchBar.vue";

export default {
  components: {
    accountR,
    incidentR,
    searchBar,
  },
  computed: {
    activePage() {
      return this.$store.getters.getActive;
    },
  },
};
</script>