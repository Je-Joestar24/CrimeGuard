<template>
  <div class="grid grid-cols-6 gap-4 w-full">
    <div class="col-span-6 sm:col-span-3 md:col-span-2 lg:col-span-1 bg-white rounded-lg shadow-md p-4 transition-all duration-300 hover:shadow-lg hover:scale-105">
      <div class="flex items-center justify-between mb-2">
        <div class="p-3 rounded-full bg-blue-100">
          <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
          </svg>
        </div>
        <div class="text-right">
          <p class="text-2xl font-semibold">{{ arr.incidentCount.totalCount }}</p>
          <p class="text-gray-600">Incidents</p>
        </div>
      </div>
      <div class="text-sm text-gray-500">
        <span :class="arr.incidentCount.growth >= 0 ? 'text-green-500' : 'text-red-500'" class="font-semibold">
          {{ arr.incidentCount.growth >= 0 ? '↑' : '↓' }} {{ Math.abs(arr.incidentCount.growth).toFixed(2) }}%
        </span> since last month
      </div>
    </div>

    <div class="col-span-6 sm:col-span-3 md:col-span-2 lg:col-span-1 bg-white rounded-lg shadow-md p-4 transition-all duration-300 hover:shadow-lg hover:scale-105">
      <div class="flex items-center justify-between mb-2">
        <div class="p-3 rounded-full bg-green-100">
          <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="text-right">
          <p class="text-2xl font-semibold">{{ arr.clearedCount.totalCount }}</p>
          <p class="text-gray-600">Cleared</p>
        </div>
      </div>
      <div class="text-sm text-gray-500">
        <span :class="arr.clearedCount.growth >= 0 ? 'text-green-500' : 'text-red-500'" class="font-semibold">
          {{ arr.clearedCount.growth >= 0 ? '↑' : '↓' }} {{ Math.abs(arr.clearedCount.growth).toFixed(2) }}%
        </span> since last month
      </div>
    </div>

    <div class="col-span-6 sm:col-span-3 md:col-span-2 lg:col-span-1 bg-white rounded-lg shadow-md p-4 transition-all duration-300 hover:shadow-lg hover:scale-105">
      <div class="flex items-center justify-between mb-2">
        <div class="p-3 rounded-full bg-yellow-100">
          <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="text-right">
          <p class="text-2xl font-semibold">{{ arr.underICount.totalCount }}</p>
          <p class="text-gray-600">Under Investigation</p>
        </div>
      </div>
      <div class="text-sm text-gray-500">
        <span :class="arr.underICount.growth >= 0 ? 'text-green-500' : 'text-red-500'" class="font-semibold">
          {{ arr.underICount.growth >= 0 ? '↑' : '↓' }} {{ Math.abs(arr.underICount.growth).toFixed(2) }}%
        </span> since last month
      </div>
    </div>

    <div class="col-span-6 sm:col-span-3 md:col-span-2 lg:col-span-1 bg-white rounded-lg shadow-md p-4 transition-all duration-300 hover:shadow-lg hover:scale-105">
      <div class="flex items-center justify-between mb-2">
        <div class="p-3 rounded-full bg-red-100">
          <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </div>
        <div class="text-right">
          <p class="text-2xl font-semibold">{{ arr.rejectCount.totalCount }}</p>
          <p class="text-gray-600">Rejected</p>
        </div>
      </div>
      <div class="text-sm text-gray-500">
        <span :class="arr.rejectCount.growth >= 0 ? 'text-green-500' : 'text-red-500'" class="font-semibold">
          {{ arr.rejectCount.growth >= 0 ? '↑' : '↓' }} {{ Math.abs(arr.rejectCount.growth).toFixed(2) }}%
        </span> since last month
      </div>
    </div>

    <div class="col-span-6 sm:col-span-3 md:col-span-2 lg:col-span-1 bg-white rounded-lg shadow-md p-4 transition-all duration-300 hover:shadow-lg hover:scale-105">
      <div class="flex items-center justify-between mb-2">
        <div class="p-3 rounded-full bg-indigo-100">
          <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
          </svg>
        </div>
        <div class="text-right">
          <p class="text-2xl font-semibold">{{ arr.reportCount.totalCount }}</p>
          <p class="text-gray-600">Reports</p>
        </div>
      </div>
      <div class="text-sm text-gray-500">
        <span :class="arr.reportCount.growth >= 0 ? 'text-green-500' : 'text-red-500'" class="font-semibold">
          {{ arr.reportCount.growth >= 0 ? '↑' : '↓' }} {{ Math.abs(arr.reportCount.growth).toFixed(2) }}%
        </span> since last month
      </div>
    </div>

    <div class="col-span-6 sm:col-span-3 md:col-span-2 lg:col-span-1 bg-white rounded-lg shadow-md p-4 transition-all duration-300 hover:shadow-lg hover:scale-105">
      <div class="flex items-center justify-between mb-2">
        <div class="p-3 rounded-full bg-purple-100">
          <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
          </svg>
        </div>
        <div class="text-right">
          <p class="text-2xl font-semibold">{{ arr.solvedCount.totalCount }}</p>
          <p class="text-gray-600">Solved</p>
        </div>
      </div>
      <div class="text-sm text-gray-500">
        <span :class="arr.solvedCount.growth >= 0 ? 'text-green-500' : 'text-red-500'" class="font-semibold">
          {{ arr.solvedCount.growth >= 0 ? '↑' : '↓' }} {{ Math.abs(arr.solvedCount.growth).toFixed(2) }}%
        </span> since last month
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      arr: {
            "incidentCount": {
                "totalCount": 0,
                "currentMonthCount": 0,
                "growth": 0
            },
            "clearedCount": {
                "totalCount": 0,
                "currentMonthCount": 0,
                "growth": 0
            },
            "solvedCount": {
                "totalCount": 0,
                "currentMonthCount": 0,
                "growth": 0
            },
            "underICount": {
                "totalCount": 0,
                "currentMonthCount": 0,
                "growth": 0
            },
            "rejectCount": {
                "totalCount": 0,
                "currentMonthCount": 0,
                "growth": 0
            },
            "reportCount": {
                "totalCount": 0,
                "currentMonthCount": 0,
                "growth": 0
            },
            "respondCount": {
                "totalCount": 0,
                "currentMonthCount": 0,
                "growth": 0
            },
            "totalIncidents": {
                "totalCount": 0,
                "currentMonthCount": 0,
                "growth": 0
            }
        }
    };
  },
  created() {
    //alert("mounted");
    this.getData('api/dashboard/counts/Display');
  },
  methods: {
    async getData(param) {
      const data = await this.$store.dispatch("generateTableData", param);
      if (data["response"] == "Success") {
        this.arr = await data["data"]['upper'];
        console.log(this.arr);
      }
    },
  },
  mounted() {
    this.getData('api/dashboard/counts/Display');
  },
};
</script>