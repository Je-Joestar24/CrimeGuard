<template>
    <div class="w-full">
      <div
        class="font-semibold px-3 pt-2 shadow-md border-b-2 border-gray-400 rounded-t-sm"
      >
        RESPONDED
      </div>
  
      <ul
        class="mt-5 overflow-auto w-full divide-y divide-gray-200 dark:divide-gray-700 px-2"
        style="height: 30vh"
      >
        <li
          v-if="arr.length > 0"
          v-for="(el, counter) in arr"
          class="py-3 mb-1 border-b px-2 bg-green-100"
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
            <div class=" min-w-0 w-1/4">
              <p class="text-sm font-medium text-gray-900  font-semibold">
                <!--truncate  dark:text-white -->
                {{ el["assigned_to"] }}
              </p>
              <p class="text-sm text-gray-500 border-t border-black">
                <!-- truncate  dark:text-gray-400 -->
                RESPONDENT
              </p>
            </div>
            <div class="flex-1 min-w-0">
              <p>
                <span>{{ el["message"] }}</span> at
                <span> {{ el["location"] }} </span>
              </p>
            </div>
          </div>
        </li>
        <li
          v-if="arr.length == 0"
          class="border-t shadow-inner border-gray-800 pt-2 text-center font-semibold text-gray-600"
        >
          No Responded Incidents Today
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
            if(arr2[i].status != 'report' && arr2[i].status != 'reject')this.arr.push(arr2[i]);
          }
          console.log(this.arr)
        }
      },
    },
  };
  </script>