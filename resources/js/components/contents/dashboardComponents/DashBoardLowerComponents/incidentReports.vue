<template>
  <div class="justify-center pt-2 px-5 rounded shadow-md bg-gray-800">
    <h2 class="text-lg mb-3 font-semibold text-white">Reports Today:</h2>
    <ul class="max-w-md space-y-1 list-inside text-gray-400">
      <li v-if="arr.length > 0" v-for="elem of arr" class="flex items-center">
        <svg
          :class="{
            'w-3.5 h-3.5 me-2 text-gray-500 dark:text-gray-400 flex-shrink-0':
              elem['status'] == 'report',
            'w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0':
              elem['status'] != 'report',
          }"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="currentColor"
          viewBox="0 0 20 20"
        >
          <path
            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"
          />
        </svg>
        <span :class="{ 'text-red-600 ': elem['status'] == 'report' }">
          {{ elem["message"] }}, {{ elem["landmark"] }}, {{ elem["location"] }},
          {{ elem["time_reported"].split(" ")[1] }}</span
        >
      </li>
      <li v-if="arr.length <= 0" class="flex text-white w-full justify-center border-t border-l py-32">
        <span class=" text-lg font-semibold text-gray-100"> NO INCIDENT REPORTS TODAY</span>
      </li>
    </ul>
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
  created() {
    (async () => {
      await this.getData("api/dashboard/generate/reports");
    })();
  },
  methods: {
    async getData(param) {
      const data = await this.$store.dispatch("generateTableData", param);
      if (data["response"] == "Success") {
        this.arr = await data["data"]["reportedIncidents"];
        await console.log(this.arr);
      }
    },
  },
};
</script>