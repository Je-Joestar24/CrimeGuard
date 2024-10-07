<template>
  <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-xl">
      <button
        @click="toggle('')"
        class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200"
      >
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

      <div class="text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 mb-6 bg-blue-100 rounded-full">
          <svg class="w-10 h-10 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
          </svg>
        </div>

        <h3 class="mb-4 text-xl font-semibold text-gray-800">Assign To</h3>

        <div class="relative mb-6">
          <input
            v-model="searchOfficer"
            @click="search('officers', searchOfficer)"
            @focusout="clearIt()"
            type="text"
            class="w-full px-4 py-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
            placeholder="Search officer name..."
          />
          <svg class="absolute w-5 h-5 text-gray-400 top-3 right-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>

        <div v-if="officers.length > 0" class="mb-6 overflow-auto max-h-40 bg-white rounded-lg border border-gray-200">
          <ul class="divide-y divide-gray-200">
            <li v-for="ofcr in officers" :key="ofcr.id" class="p-2 hover:bg-gray-50 cursor-pointer" @click="selectOfficer(ofcr.id, `${ofcr.first_name} ${ofcr.last_name}`)">
              {{ ofcr.first_name }} {{ ofcr.last_name }}
            </li>
          </ul>
        </div>

        <div class="flex justify-center space-x-4">
          <button
            @click="sendData(officer)"
            :disabled="officer === -1"
            class="px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors duration-200"
            :class="{ 'opacity-50 cursor-not-allowed': officer === -1 }"
          >
            Assign
          </button>
          <button
            @click="toggle('')"
            class="px-6 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition-colors duration-200"
          >
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["sendData", "toggle"],
  data() {
    return {
      searchOfficer: "",
      officers: [],
      officer: -1,
    };
  },
  methods: {
    async clearIt() {
      await this.sleep(500);
      this.officers = [];
    },
    sleep(ms) {
      return new Promise((resolve) => setTimeout(resolve, ms));
    },
    async search(key, param) {
      const send = {
        data: { search: param },
        url: "api/officer/search/request",
      };

      const data = await this.$store.dispatch("sendData", send);
      const res = data["response"];

      if (res == "Success") {
        this[key] = data.data;
      } else {
        alert("An error occurred, please try again.");
      }
    },
    selectOfficer(id, name) {
      this.officer = id;
      this.searchOfficer = name;
      this.clearIt();
    }
  },
  watch: {
    searchOfficer: function (newVal, oldVal) {
      if (newVal !== oldVal) {
        this.search("officers", newVal);
      }
    },
  },
};
</script>