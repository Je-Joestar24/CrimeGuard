<template>
  
  <div class="flex justify-end">
    <div class="relative mt-1 my-2 inline">
        <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
              <!-- dark:text-gray-400 -->  
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
        </div>
        <input type="text" v-model="search" class="block py-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search">
        <!--  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 -->
  </div>
</div>
  <div
    class="font-semibold px-3 pt-2 shadow-md border-b-2 border-gray-400 rounded-t-sm"
  >
    ACCOUNT REGISTRATION REQUEST LIST
  </div>
  <ul class="mt-5 overflow-auto h-96 w-full divide-y divide-gray-200">
    <li v-if="arr.length > 0" v-for="el in arr" class="pb-3 sm:pb-4 border-b">
      <div class="flex items-center space-x-4 rtl:space-x-reverse">
        <div class="flex-shrink-0">
          <svg
          v-if="el.profile == ''"
            class="h-10 w-10 text-gray-500 my-auto"
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
          <img v-if="el.profile != ''" class="h-10 rounded-full border w-10 text-gray-500 my-auto" :src="el.profile" alt="">
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-sm font-medium text-gray-900">
            <!--truncate  dark:text-white -->
            {{ el["first_name"] }}
            {{ el["last_name"] }}
          </p>
          <p class="text-sm text-gray-500">
            <!-- truncate  dark:text-gray-400 -->
            {{ el["email"] }}
          </p>
        </div>
        <p>
          <span> {{ el["address"] }} </span>, <span>{{ el["time"] }}</span>
        </p>
        <div
          class="inline-flex items-center text-base font-semibold text-gray-900"
        >
          <!--  dark:text-white -->
          <span>{{ month[el["month"] - 1] }}</span
          >, {{ el["date"] }}
        </div>
        <div class="flex gap-1">
          <!-- view button -->
          <button
            type="button"
            class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-2 py-1 text-xs font-thin text-center rounded-lg"
            @click.prevent="viewModalToggle(el['id'])"
          >
            <svg
              class="h-5 w-5 text-gray-100"
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
              <circle cx="12" cy="12" r="2" />
              <path d="M2 12l1.5 2a11 11 0 0 0 17 0l1.5 -2" />
              <path d="M2 12l1.5 -2a11 11 0 0 1 17 0l1.5 2" />
            </svg>
          </button>
          <!-- Accept button -->
          <button
            @click="
              acceptToggle(
                { id: el['id'], accepted_by: 3 }
                // Temporary ID
              )
            "
            type="button"
            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 px-2 py-1 text-xs font-thin text-center rounded-lg dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
          >
            <svg
              class="h-5 w-5 text-green-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke="white"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 13l4 4L19 7"
              />
            </svg>
          </button>
          <!-- reject button -->
          <button
            type="button"
            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 px-2 py-1 text-xs font-thin text-center rounded-lg dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
            @click="rejectModalToggle({ id: el['id'], archived_by: 3 })"
          >
            <svg
              class="h-5 w-5 text-green-600"
              viewBox="0 0 24 24"
              fill="none"
              stroke="white"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <line x1="18" y1="6" x2="6" y2="18" />
              <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
          </button>
        </div>
      </div>
    </li>
    <li
      v-if="arr.length == 0"
      class="text-center font-semibold text-gray-600 h-20 bg-gray-50 rounded-b-md"
    >
      No Account Requests!
    </li>
  </ul>
  <acceptAccount
    :toggle="acceptToggle"
    :sendData="acceptData"
    v-if="modals.acceptIsOpen"
  ></acceptAccount>
  <rejectAccount
    :toggle="rejectModalToggle"
    :sendData="rejectData"
    v-if="modals.rejectIsOpen"
  ></rejectAccount>
  <accountProfile
    :toggle="viewModalToggle"
    v-if="modals.viewIsOpen && viewRequestId != -1"
    :suspectId="viewRequestId"
  ></accountProfile>
</template>

<script>
import acceptAccount from "./requestComponents/acceptAccount.vue";
import rejectAccount from "./requestComponents/rejectAccount.vue";
import accountProfile from "./requestComponents/accountProfile.vue";

export default {
  components: {
    acceptAccount,
    rejectAccount,
    accountProfile,
  },
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
      ],
      modals: {
        acceptIsOpen: false,
        rejectIsOpen: false,
        viewIsOpen: false,
      },
      accept: {
        data: {},
        url: "api/users/accept/item/request",
      },
      reject: {
        data: {},
        url: "api/users/delete/item/request",
      },viewRequestId:-1,
      search:''
    };
  },
  created() {
    (async () => {
      await this.getData({url: "api/citizenUsers/account/request/list/Display", data: {}});
    })();
  },
  methods: {
    acceptToggle(param) {
      this.modals.acceptIsOpen = !this.modals.acceptIsOpen;
      this.accept.data = param;
    },
    rejectModalToggle(param) {
      this.modals.rejectIsOpen = !this.modals.rejectIsOpen;
      this.reject.data = param;
    },
    viewModalToggle(param) {
      this.viewRequestId = param;
      this.modals.viewIsOpen = !this.modals.viewIsOpen;
    },
    generateArray() {
      for (let i = 0; i < 20; i++) {
        const sample = {
          user_name: "Jejomar",
          first_name: "Jejomar",
          last_name: "Parrilla",
          email: "jpar1252003",
          address: "santirbot",
          time: "01:69",
          month: 1,
          date: "1213",
        };
        this.arr.push(sample);
      }
    },
    async getData(param) {
      this.header = [];
      this.data = [];
      const data = await this.$store.dispatch("sendData", param);
      if (data["response"] == "Success") {
        this.arr = await data["data"];
      }
    },
    async acceptData() {
      const send = this.accept;

      const data = await this.$store.dispatch("sendData", send);
      const res = await data["response"];

      if (res == "Success") {
        await alert("Account accepted.");
        this.acceptToggle("");
        await this.getData({url: "api/citizenUsers/account/request/list/Display", data: {}});
      } else {
        await alert("An error occured, please try again.");
      }
    },
    async rejectData() {
      const send = this.reject;

      const data = await this.$store.dispatch("sendData", send);
      const res = await data["response"];

      if (res == "Success") {
        await alert("Account rejected.");
        this.rejectModalToggle("");
        await this.getData({url: "api/citizenUsers/account/request/list/Display", data: {}});
      } else {
        await alert("An error occured, please try again.");
      }
    },
  },watch: {
    'search':function(newVal, oldVal){
        this.getData({url: "api/citizenUsers/account/request/list/Display", data: {search: newVal}});
      }
  }
};
</script>