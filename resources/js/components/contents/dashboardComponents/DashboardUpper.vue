<template>
  <div class="flex p-2 h-40 rounded bg-gray-50 shadow-md">
    <div class="flex-1 grid grid-cols-6">
      <div
        class="flex items-center justify-center align-items-center col-span-1"
      >
        <svg
          class="h-12 w-12"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          stroke-width="2"
          stroke="currentColor"
          fill="none"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <path stroke="none" d="M0 0h24v24H0z" />
          <polyline points="12 4 4 8 12 12 20 8 12 4" />
          <polyline points="4 12 12 16 20 12" />
          <polyline points="4 16 12 20 20 16" />
        </svg>
      </div>
      <div class="col-span-5 grid grid-flow-row">
        <div class="grid-flow-col gap-2 row-span-1 flex items-center">
          <span  class="text-blue-800 text-lg font-bold"
            >{{ arr['incidentCount'] }}</span
          >
          <span>INCIDENTS</span>
        </div>
        <div class="border-t-2 border-gray-900">
<!--           <button  class="text-xs underline text-blue-800"
            >View all</button
          > -->
        </div>
      </div>
    </div>
  </div>
  <div class="flex p-2 h-40 rounded bg-gray-50 shadow-md">
    <div class="flex-1 grid grid-cols-6">
      <div
        class="flex items-center justify-center align-items-center col-span-1"
      >
        <svg
          class="h-12 w-12 text-black"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          stroke-width="2"
          stroke="currentColor"
          fill="none"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <path stroke="none" d="M0 0h24v24H0z" />
          <path
            d="M9 5H7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2V7a2 2 0 0 0 -2 -2h-2"
          />
          <rect x="9" y="3" width="6" height="4" rx="2" />
          <path d="M9 14l2 2l4 -4" />
        </svg>
      </div>
      <div class="col-span-5 grid grid-flow-row">
        <div class="grid-flow-col gap-2 row-span-1 flex items-center">
          <span  class="text-blue-800 text-lg font-bold"
            >{{ arr['clearedCount'] }}</span
          >
          <span>CLEARED</span>
        </div>
        <div class="border-t-2 border-gray-900">
<!--           <button class="text-xs underline text-blue-800"
            >View all</button
          > -->
        </div>
      </div>
    </div>
  </div>
  <div class="flex p-2 h-40 rounded bg-gray-50 shadow-md">
    <div class="flex-1 grid grid-cols-6">
      <div
        class="flex items-center justify-center align-items-center col-span-1"
      >
        <svg
          class="h-12 w-12 text-black"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
          />
        </svg>
      </div>
      <div class="col-span-5 grid grid-flow-row">
        <div class="grid-flow-col gap-2 row-span-1 flex items-center">
          <span class="text-blue-800 text-lg font-bold"
            >{{ arr['underICount'] }}</span
          >
          <span>UNDER INVESTIGATION</span>
        </div>
        <div class="border-t-2 border-gray-900">
<!--           <button class="text-xs underline text-blue-800"
            >View all</button
          > -->
        </div>
      </div>
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
  created() {
    //alert("mounted");
    this.getData('api/dashboard/counts/Display');
  },
  methods: {
    async getData(param) {
      const data = await this.$store.dispatch("generateTableData", param);
      if (data["response"] == "Success") {
        this.arr = await data["data"]['upper'];
      }
    },
  },
  mounted() {
    this.getData('api/dashboard/counts/Display');
  },
};
</script>