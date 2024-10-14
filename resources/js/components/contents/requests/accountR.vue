<template>
  <div class="bg-white shadow-lg rounded-lg overflow-hidden">
    <div class="p-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Account Registration Requests</h2>

      <div class="mb-4">
        <div class="relative">
          <input
            type="text"
            class="w-full pl-10 pr-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-400"
            placeholder="Search requests..."
            v-model="search"
          />
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-gray-50 rounded-lg overflow-hidden">
        <ul class="divide-y divide-gray-200">
          <li v-for="el in paginatedArr" :key="el.id" class="hover:bg-gray-100 transition duration-150 ease-in-out">
            <div class="p-4 flex items-center space-x-4">
              <div class="flex-shrink-0">
                <div v-if="!el.profile" class="h-12 w-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold text-lg">
                  {{ el.first_name.charAt(0).toUpperCase() }}
                </div>
                <img v-else :src="el.profile" alt="Profile" class="h-12 w-12 rounded-full object-cover">
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">
                  {{ el.first_name }} {{ el.last_name }}
                </p>
                <p class="text-sm text-gray-500 truncate">
                  {{ el.email }}
                </p>
              </div>
              <div class="text-sm text-gray-500">
                <p>{{ el.address }}</p>
                <p>{{ el.time }}</p>
              </div>
              <div class="text-sm font-semibold text-gray-700">
                {{ month[el.month - 1].charAt(0).toUpperCase() + month[el.month - 1].slice(1) }} {{ el.date }}
              </div>
              <div class="flex space-x-2">
                <button
                  @click="viewModalToggle(el.id)"
                  class="px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50 transition duration-150 ease-in-out"
                >
                  View
                </button>
                <button
                  @click="acceptToggle({ id: el.id, accepted_by: 3 })"
                  class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-150 ease-in-out"
                >
                  Accept
                </button>
                <button
                  @click="rejectModalToggle({ id: el.id, archived_by: 3 })"
                  class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-150 ease-in-out"
                >
                  Reject
                </button>
              </div>
            </div>
          </li>
        </ul>
      </div>

      <div v-if="paginatedArr.length === 0" class="text-center py-8">
        <p class="text-gray-500 text-lg">No account requests found</p>
      </div>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center my-4 space-x-2">
      <button
        @click="changePage(1)"
        :disabled="pagination.currentPage === 1"
        class="px-3 py-1.5 text-xs font-semibold text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150 ease-in-out"
      >
        <svg class="w-4 h-4 mr-1 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
        First
      </button>
      <button
        @click="changePage(pagination.currentPage - 1)"
        :disabled="pagination.currentPage === 1"
        class="px-3 py-1.5 text-xs font-semibold text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150 ease-in-out"
      >
        <svg class="w-4 h-4 mr-1 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        Previous
      </button>
      <span class="px-3 py-1.5 text-xs font-semibold text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm">
        Page {{ pagination.currentPage }} of {{ pagination.totalPages }}
      </span>
      <button
        @click="changePage(pagination.currentPage + 1)"
        :disabled="pagination.currentPage === pagination.totalPages"
        class="px-3 py-1.5 text-xs font-semibold text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150 ease-in-out"
      >
        Next
        <svg class="w-4 h-4 ml-1 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
      </button>
      <button
        @click="changePage(pagination.totalPages)"
        :disabled="pagination.currentPage === pagination.totalPages"
        class="px-3 py-1.5 text-xs font-semibold text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150 ease-in-out"
      >
        Last
        <svg class="w-4 h-4 ml-1 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
      </button>
    </div>
  </div>

  <acceptAccount
    v-show="!acceptLoading"
    :toggle="acceptToggle"
    :sendData="acceptData"
    v-if="modals.acceptIsOpen"
  ></acceptAccount>
  <rejectAccount
    v-show="!rejectLoading"
    :toggle="rejectModalToggle"
    :sendData="rejectData"
    v-if="modals.rejectIsOpen"
  ></rejectAccount>
  <accountProfile
    :toggle="viewModalToggle"
    v-if="modals.viewIsOpen && viewRequestId != -1"
    :suspectId="viewRequestId"
  ></accountProfile>

  <acceptLoading v-if="acceptLoading" />
  <rejectAccLoading v-if="rejectLoading" /> 
</template>

<script>
import acceptAccount from "./requestComponents/acceptAccount.vue";
import rejectAccount from "./requestComponents/rejectAccount.vue";
import accountProfile from "./requestComponents/accountProfile.vue";
import acceptLoading from "./requestComponents/loading/acceptLoading.vue";
import rejectAccLoading from "./requestComponents/loading/rejectAccLoading.vue";

export default {
  components: {
    acceptAccount,
    rejectAccount,
    accountProfile,
    acceptLoading,
    rejectAccLoading,
  },
  data() {
    return {
      arr: [],
      acceptLoading: false,
      rejectLoading: false,
      paginatedArr: [],
      month: [
        "january", "february", "march", "april", "may", "june",
        "july", "august", "september", "october", "november", "december"
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
      },
      viewRequestId: -1,
      search: '',
      pagination: {
        currentPage: 1,
        itemsPerPage: 7,
        totalItems: 0,
        totalPages: 0,
      },
    };
  },
  created() {
    this.getData({url: "api/citizenUsers/account/request/list/Display", data: {}});
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
    async getData(param) {
      const data = await this.$store.dispatch("sendData", param);
      if (data["response"] == "Success") {
        this.arr = await data["data"];
        this.createPaginatedData();
      }
    },
    async acceptData() {
      this.acceptLoading = true;
      const send = this.accept;
      const data = await this.$store.dispatch("sendData", send);
      const res = await data["response"];
      if (res == "Success") {
        this.acceptLoading = false;
        this.acceptToggle("");
        await this.getData({url: "api/citizenUsers/account/request/list/Display", data: {}});
      } else {
        await alert("An error occurred, please try again.");
        this.acceptLoading = false;
      }
    },
    async rejectData() {
      this.rejectLoading = true;
      const send = this.reject;
      const data = await this.$store.dispatch("sendData", send);
      const res = await data["response"];
      if (res == "Success") {
        this.rejectLoading = false;
        this.rejectModalToggle("");
        await this.getData({url: "api/citizenUsers/account/request/list/Display", data: {}});
      } else {
        await alert("An error occurred, please try again.");
        this.rejectLoading = false;
      }
    },
    changePage(page) {
      if (page >= 1 && page <= this.pagination.totalPages) {
        this.pagination.currentPage = page;
        this.createPaginatedData();
      }
    },
    createPaginatedData() {
      const startIndex = (this.pagination.currentPage - 1) * this.pagination.itemsPerPage;
      const endIndex = startIndex + this.pagination.itemsPerPage;
      this.paginatedArr = this.arr.slice(startIndex, endIndex);
      this.pagination.totalItems = this.arr.length;
      this.pagination.totalPages = Math.ceil(this.pagination.totalItems / this.pagination.itemsPerPage);

      if (this.pagination.currentPage > this.pagination.totalPages) {
        this.changePage(this.pagination.totalPages);
      }
    },
  },
  watch: {
    search: function(newVal, oldVal) {
      this.getData({url: "api/citizenUsers/account/request/list/Display", data: {search: newVal}});
      this.pagination.currentPage = 1; // Reset to first page when searching
    }
  }
};
</script>