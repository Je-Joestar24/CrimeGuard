<template>
    <monitoring v-if="$store.getters.CurrentActiveSideBar == 'innerMonitoring'"></monitoring>
    <heatmap v-if="$store.getters.CurrentActiveSideBar == 'innerHeatMap'"></heatmap>
</template>

<script>
import heatmap from './maps/heatmap.vue'
import monitoring from './maps/monitoring.vue';

export default{
    components:{
        heatmap,
        monitoring
    }
}
</script>