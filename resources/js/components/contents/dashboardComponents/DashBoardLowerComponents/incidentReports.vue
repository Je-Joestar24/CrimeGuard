<template>
  <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-lg shadow-xl p-6 overflow-hidden col-span-2">
    <h2 class="text-2xl font-bold text-white mb-4 border-b border-gray-700 pb-2 ">Today's Incident Reports</h2>
    <div v-if="arr.length > 0" class="space-y-4 overflow-y-auto max-h-[280px]">
      <div v-for="elem of arr" :key="elem.id" class="bg-gray-700 bg-opacity-50 rounded-lg p-4 transition-all duration-300 hover:bg-opacity-70" @click="centerIt(elem)">
        <div class="flex items-center">
          <div :class="{
            'bg-yellow-500': elem.status === 'report',
            'bg-green-500': elem.status !== 'report'
          }" class="w-3 h-3 rounded-full mr-3"></div>
          <p :class="{
            'text-yellow-400': elem.status === 'report',
            'text-green-400': elem.status !== 'report'
          }" class="text-sm font-semibold">
            {{ elem.status === 'report' ? 'Reported' : 'Resolved' }}
          </p>
        </div>
        <p class="text-white mt-2">{{ elem.message }}</p>
        <div class="flex justify-between items-center mt-3 text-xs text-gray-400">
          <span>{{ elem.landmark }}, {{ elem.location }}</span>
          <span>{{ elem.time_reported.split(" ")[1] }}</span>
        </div>
      </div>
    </div>
    <div v-else class="flex items-center justify-center h-64">
      <p class="text-xl font-semibold text-gray-400">No incident reports today</p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      arr: [],
    };
  },
  mounted() {
    (async () => {
      await this.getData("api/dashboard/generate/reports");
    })();
  },
  methods: {
    async getData(param) {
      this.arr = [];
      const data = await this.$store.dispatch("generateTableData", param);
      if (data["response"] == "Success") {
        let dt = await data["data"]["reportedIncidents"];
        for (let i = 0; i < dt.length; i++) {
          this.arr.push({
            id: dt[i]['id'],
            landmark: dt[i]['landmark'],
            pos: {
              lat: parseFloat(dt[i]["pos"]["lat"]),
              lng: parseFloat(dt[i]["pos"]["lng"]),
            },
            message: dt[i]["message"],
            location: dt[i]["location"],
            status: dt[i]["status"],
            time_reported: dt[i]["time_reported"],
          });
        }
      }
    },
  },props: ['centerIt']
};
</script>