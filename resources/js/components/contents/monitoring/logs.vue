<template>
  <div class="bg-white shadow-lg rounded-lg overflow-hidden">
    <div class="p-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Officer Logs</h2>

      <div class="mb-4">
        <div class="relative">
          <input
            type="text"
            class="w-full pl-10 pr-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-400"
            placeholder="Search logs..."
            v-model="search"
          />
          <div
            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
          >
            <svg
              class="h-5 w-5 text-gray-400"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                clip-rule="evenodd"
              />
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-gray-50 rounded-lg overflow-hidden">
        <ul class="divide-y divide-gray-200">
          <li
            v-for="el in paginatedArr"
            class="hover:bg-gray-100 transition duration-150 ease-in-out"
          >
            <div class="p-4 flex items-center space-x-4">
              <div class="flex-shrink-0">
                <div
                  class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold text-lg"
                >
                  {{ el.user_name.charAt(0).toUpperCase() }}
                </div>
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">
                  {{ el.user_name }}
                </p>
                <p class="text-sm text-gray-500 truncate">
                  {{ el.email }}
                </p>
              </div>
              <div class="text-sm text-gray-500">
                <p>Login: {{ el.login }}</p>
                <p>Logout: {{ el.logout ? el.logout : "Active" }}</p>
              </div>
              <div class="text-sm font-semibold text-gray-700">
                {{
                  month[el.month - 1].charAt(0).toUpperCase() +
                  month[el.month - 1].slice(1)
                }}
                {{ el.date }}
              </div>
            </div>
          </li>
        </ul>
      </div>

      <div v-if="paginatedArr.length === 0" class="text-center py-8">
        <p class="text-gray-500 text-lg">No logs found</p>
      </div>
    </div>
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
      ],
      search: "",
      paginatedArr: [],
      pagination: {
        currentPage: 1,
        itemsPerPage: 7,
        totalItems: 0,
        totalPages: 0,
      },
    };
  },
  mounted() {
    this.getData({ url: this.$store.getters.api, data: {} });
  },
  methods: {
    async getData(param) {
      this.arr = [];
      const data = await this.$store.dispatch("sendData", param);
      if (data["response"] == "Success") {
        this.arr = await data["list"]["data"];
        this.createPaginatedData();
      }
    },
    changePage(page) {
      if (page >= 1 && page <= this.pagination.totalPages) {
        this.pagination.currentPage = page;
        this.createPaginatedData();
      }
    },
    createPaginatedData() {
      this.paginatedArr = [];
      const startIndex =
        (this.pagination.currentPage - 1) * this.pagination.itemsPerPage;
      const endIndex = startIndex + this.pagination.itemsPerPage;
      this.paginatedArr = this.arr.slice(startIndex, endIndex);
      this.pagination.totalItems = this.arr.length;
      this.pagination.totalPages = Math.ceil(
        this.pagination.totalItems / this.pagination.itemsPerPage
      );

      console.log(this.paginatedArr);
      // Ensure the current page is not greater than the total pages
      /* if (this.pagination.currentPage > this.pagination.totalPages) {
        this.changePage(this.pagination.totalPages);
      } */
    },
  },
  watch: {
    search: function (newVal, oldVal) {
      this.getData({ url: this.$store.getters.api, data: { search: newVal } });
    },
  },
  computed: {},
};
</script>