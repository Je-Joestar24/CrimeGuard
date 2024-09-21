<template>
  <div class="w-full">
    <div
      class="font-semibold px-3 pt-2 shadow-md border-b-2 border-gray-400 rounded-t-sm"
    >
      REJECT MESSAGES
    </div>

    <ul
      class="mt-5 overflow-auto w-full divide-y divide-gray-200 dark:divide-gray-700 px-2"
      style="height: 30vh"
    >
      <li
        v-if="arr.length > 0"
        v-for="el in arr"
        class="py-3 mb-1 border-b px-2 bg-red-200"
      >
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
          <div class="w-full">
            <p class="text-sm font-medium text-gray-900">
              <!--truncate  dark:text-white -->
              {{ (el["first_name"] + " " + el['last_name']) }}
            </p>
            <p class="text-sm text-gray-500">
              <!-- truncate  dark:text-gray-400 -->
              {{ el["email"] }}
            </p>
          </div>
          <div class=" flex justify-start w-full">
            <span class=" text-sm font-semibold pe-3">MESSAGE: </span>
            <span class="  border-b border-s rounded w-full">{{ el['reject_message'] }}</span>
          </div>
        </div>
      </li>
      <li
        v-if="arr.length == 0"
        class="border-t shadow-inner border-gray-800 pt-2 text-center font-semibold text-gray-600"
      >
        No Rejected Incidents Today
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
        url: "api/incidents/reject/messages/list/Display",
        data: {},
      });

      if (data["response"] == "Success") {
        this.arr = await data["data"];
      }
    },
  },
};
</script>