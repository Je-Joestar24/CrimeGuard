<template>
  <div
    tabindex="-1"
    class="fixed inset-0 z-50 items-center justify-center flex bg-gray-900 bg-opacity-20"
  >
    <div class="relative p-4 w-full max-w-md max-h-full">
      <div class="relative bg-white rounded-lg border shadow-2xl">
        <button
          type="button"
          class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
          @click.prevent="toggle('')"
        >
          <svg
            class="w-3 h-3"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 14 14"
          >
            <path
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
            />
          </svg>
          <span class="sr-only">Close modal</span>
        </button>
        <div class="p-4 md:p-5 text-center">
          <div class="flex justify-center">
            <div class="p-1 border-4 border-gray-500 rounded-full">
              <svg
                class="h-24 w-24 text-gray-500 p-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"
                />
              </svg>
            </div>
          </div>

          <h3 class="mb-5 text-lg font-normal text-gray-500 border-b">
            ASSIGN TO:
          </h3>
          <div class="relative z-0 w-full col-span-6 mb-5 group pb-4">
            <div class="relative w-full">
              <div
                class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none"
              >
                <svg
                  class="w-4 h-4 text-gray-500 dark:text-gray-400"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 18 20"
                >
                  <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2"
                  />
                </svg>
              </div>
              <input
                type="text"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                placeholder="Search officer name..."
                @click="search('officers', searchOfficer)"
                @focusout="clearIt()"
                v-model="searchOfficer"
                required
              />
            </div>

            
            <div
              v-if="officers.length > 0"
              class="max-h-32 overflow-auto bg-white divide-y divide-gray-100 rounded-lg border shadow"
            >
              <ul class="py-2 text-sm text-gray-700 border-b">
                <li v-for="ofcr in officers" >
                  <span
                    @click.prevent="selectOfficer(ofcr.id, (ofcr.first_name+' '+ofcr.last_name))"
                    class="block px-4 py-1 hover:bg-gray-100 border-b text-start"
                    >{{ ofcr.first_name }} {{ ofcr.last_name }}</span>
                </li>
              </ul>
            </div>
          </div>
          <button
            type="button"
            :class="{'cursor-not-allowed': (officer == -1)}"
            :disabled="(officer == -1)"
            class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center"
            @click="sendData(officer)"
          >
            ASSIGN
          </button>
          <button
            data-modal-hide="popup-modal"
            type="button"
            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100"
            @click="toggle('')"
          >
            CANCEL
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
      const send = await {
        data: { search: param },
        url: "api/officer/search/request",
      };

      const data = await this.$store.dispatch("sendData", send);
      const res = await data["response"];

      if (res == "Success") {
        this[key] = data.data;
      } else {
        await alert("An error occured, please try again.");
      }
    },selectOfficer(id, name){
      this.officer = id;
      this.searchOfficer = name;
      this.clearIt();
    }
  },
  watch: {
    searchOfficer: function (newVal, oldVal) {
      if (newVal != oldVal) {
        this.search("officers", newVal);
      }
    },
  },
};
</script>