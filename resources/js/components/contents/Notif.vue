<template>
  
  <div class="flex justify-end">
    <div class="relative mt-1 my-2 inline">
        <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
              <!-- dark:text-gray-400 -->  
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
        </div>
        <input  v-model="search"  type="text"  class="block py-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search">
        <!--  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 -->
  </div>
</div>
  <div
    class="font-semibold px-3 pt-2 shadow-md border-b-2 border-gray-400 rounded-t-sm"
  >
    INCIDENT REPORT NOTIFICATIONS
  </div>
  <ul
    class="mt-5 overflow-auto h-96 w-full divide-y divide-gray-200 dark:divide-gray-700"
  >
    <li v-if="arr.length > 0" v-for="el in arr" class="pb-3 sm:pb-4 border-b">
      <div class="flex items-center space-x-4 rtl:space-x-reverse">
        <div class="flex-shrink-0">
          <svg
            class="h-8 w-8"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-sm font-medium text-gray-900">
            <!--truncate  dark:text-white -->
            {{ el["user_name"] }}
          </p>
          <p class="text-sm text-gray-500">
            <!-- truncate  dark:text-gray-400 -->
            {{ el["email"] }}
          </p>
        </div>
        <p>
          <span>{{ el["message"] }}</span> at
          <span> {{ el["location"] }} </span>, <span>{{ el["time"] }}</span>
        </p>
        <div
          class="inline-flex items-center text-base font-semibold text-gray-900"
        >
          <!--  dark:text-white -->
          <span>{{ month[el["month"] - 1] }}</span
          >, {{ el["date"] }}
        </div>
      </div>
    </li>
    <li v-if="arr.length == 0" class="text-center font-semibold text-gray-600 h-20 bg-gray-50 rounded-b-md">No Incident Reports Notifications</li>
  </ul>
</template>

<script>
export default {
  data() {
    return {
      arr: [],
      month: [
        "january",
        "february",
        "march",
        "april",
        "may",
        "june",
        "july",
        "august",
        "september",
        "october",
        "november",
        "december",
      ],search: ""
    };
  },
  mounted() {
    (async () => {
      await this.getData({url: "api/notifications/list/Display", data: {search: ""}});
      await console.log(arr);
    })();
  },
  methods: {
    generateArray() {
      for (let i = 0; i < 20; i++) {
        this.arr.push(i);
      }
    },/* 
    async getData(param) {
      this.header = [];
      this.data = [];
      const data = await this.$store.dispatch("generateTableData", param);
      if (data["response"] == "Success") {
        this.arr = await data["list"]["data"];
      }
    }, */
    async getData(param) {
      this.header = [];
      this.data = [];
      const data = await this.$store.dispatch("sendData", param);
      if (data["response"] == "Success") {
        this.arr = await data['list']["data"];
      }
    },
  },watch: {
    'search':function(newVal, oldVal){
        this.getData({url: "api/notifications/list/Display", data: {search: newVal}});
      }
  }
};
</script>