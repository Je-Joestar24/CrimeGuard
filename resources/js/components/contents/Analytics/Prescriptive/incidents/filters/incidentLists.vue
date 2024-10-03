<template>

  <div class="relative">
    <svg
      class="w-4 h-4 text-gray-500 absolute top-2.5 left-2.5"
      aria-hidden="true"
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 20 20"
    >
      <path
        stroke="currentColor"
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
      />
    </svg>
    <input
      type="test"
      v-model="filter.tempType"
      class="block w-full py-2 px-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
      placeholder="Search Incident Names"
      required
    />
    <svg
      class="h-4 w-4 text-gray-700 absolute top-2.5 end-2.5 cursor-pointer hover:bg-gray-200 hover:rounded-full active:bg-gray-100"
      viewBox="0 0 24 24"
      fill="none"
      stroke="currentColor"
      stroke-width="2"
      stroke-linecap="round"
      stroke-linejoin="round"
      @click="toggle"
    >
      <line x1="18" y1="6" x2="6" y2="18" />
      <line x1="6" y1="6" x2="18" y2="18" />
    </svg>
  </div>
  <div
    class="w-full overflow-auto divide-y divide-gray-100 rounded-lg h-44 shadow-sm mt-2"
  >
    <ul
      v-if="incidentT.list.length > 0"
      class="py-2 text-sm text-gray-700 border-b"
    >
      <li v-for="inc in incidentT.list">
        <span
          @click.prevent="setIncident(inc.incident_name, inc.id)"
          class="block px-4 py-1 hover:bg-gray-100 border-b"
          >{{ inc.incident_name }}
          <span class="text-xs text-gray-600">{{
            inc.sub_type != null ? `(${inc.sub_type})` : ""
          }}</span></span
        >
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      filter: {
        tempType: "",
      },
      places: [],
      incidentT: {
        search: "",
        list: [],
      },
    };
  },
  mounted() {
    this.search('incidentT', '');
  },
  methods: {
    async search(key, param) {
      const send = await {
        data: { search: param },
        url: "api/incidentNames/search/Display",
      };

      const data = await this.$store.dispatch("sendData", send);
      this.res = await data["response"];

      if (this.res == "Success") {
        this[key].list = data.data;
        console.log(this[key].list);
      } else {
        await alert("An error occured, please try again.");
      }
    },
  },
  watch: {
    "filter.tempType": function (newVal, oldVal) {
      if (newVal != oldVal) {
        this.search("incidentT", newVal);
      }
    },
  },
  props: ["setIncident", "toggle"],
};
</script>