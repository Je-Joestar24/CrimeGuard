<template>
  <div class="w-full">
    <div
      class="bg-green-600 text-white font-bold text-lg px-4 py-3 shadow-md rounded-t-lg"
    >
      Responded Incidents
    </div>

    <ul
      class="mt-2 overflow-auto w-full divide-y divide-gray-200 dark:divide-gray-700"
      style="height: 30vh"
    >
      <li
        v-if="arr.length > 0"
        v-for="(el, counter) in arr"
        class="py-4 px-4 bg-white hover:bg-green-50 transition duration-150 ease-in-out"
      >
        <div class="flex items-center space-x-4 rtl:space-x-reverse">
          <div class="flex-shrink-0">
            <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white font-bold">
              {{ ((""+el['assigned_to']).charAt(0).toUpperCase()) }}
            </div>
          </div>
          <div class="min-w-0 flex-1">
            <div class="flex justify-between items-center mb-1">
              <p class="text-sm font-medium text-gray-900">
                {{ el.assigned_to }}
              </p>
              <span class="text-xs font-semibold text-green-600 bg-green-100 px-2 py-1 rounded-full">
                Respondent
              </span>
            </div>
            <p class="text-sm text-gray-600 truncate">
              {{ el.message }}
            </p>
            <p class="text-xs text-gray-500 mt-1">
              Location: {{ el.location }}
            </p>
          </div>
        </div>
      </li>
      <li
        v-if="arr.length == 0"
        class="py-8 text-center text-gray-500 bg-gray-50"
      >
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No Responded Incidents Today</h3>
        <p class="mt-1 text-sm text-gray-500">Check back later for updates.</p>
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
    this.getData();
  },
  methods: {
    async getData() {
      this.arr = [];
      const cred = JSON.parse(localStorage.getItem("credentials"));
      
      const data = await this.$store.dispatch("sendData", {
        url: "api/incidents/report/list/Display",
        data: {/* 
          status: 'respond' */
        },
      });

      if (data["response"] == "Success") {
        const arr2 = await data["data"];
        console.log(this.arr)
        for(let i = 0; i < arr2.length; i ++){
          if(arr2[i].status != 'report' && arr2[i].status != 'reject' && arr2[i].assigned_to != NULL && arr2[i].assigned_to != '')this.arr.push(arr2[i]);
        }
        console.log(this.arr)
      }
    },
  },
};
</script>