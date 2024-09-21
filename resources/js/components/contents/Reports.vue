<template>
  <div class="md:ps-60 pt-10">
    <statistics
    ></statistics>
    <!-- narrative --><!-- 
    <narrative
      v-if="$store.getters.CurrentActiveSideBar == 'innerNarrative'"
    ></narrative> -->
  </div>
</template>

<script>
import statistics from "./reports/statistics.vue";
import narrative from "./reports/narative.vue";

export default {
  components: {
    statistics,
    narrative,
  },
  computed: {},
};
</script>