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
      v-model="barangay"
      class="block w-full py-2 px-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
      placeholder="Search Incident Names"
      required
    />
    <svg
    @click="toggle"
      class="h-4 w-4 text-gray-700 absolute top-2.5 end-2.5 cursor-pointer hover:bg-gray-200 hover:rounded-full active:bg-gray-100"
      viewBox="0 0 24 24"
      fill="none"
      stroke="currentColor"
      stroke-width="2"
      stroke-linecap="round"
      stroke-linejoin="round"
    >
      <line x1="18" y1="6" x2="6" y2="18" />
      <line x1="6" y1="6" x2="18" y2="18" />
    </svg>
  </div>
  <div
    class="w-full overflow-auto divide-y divide-gray-100 rounded-lg h-44 shadow-sm mt-2"
  >
    <div
      v-if="places.length > 0"
      class="px-4 hover:bg-gray-50 py-1 border-b"
      v-for="place in places"
      @click.prevent="setAddress(place + '')"
    >
      {{ place }}
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      places: [],
      barangay: "",
    };
  },
  mounted() {
    this.generateAddress('');
  },
  methods: {
    async generateAddress(search) {
      const data = {
        search: search,
      };

      const send = {
        url: "api/barangay/request",
        data: data,
      };

      const test = await this.$store.dispatch("sendData", send);
      if (test["response"] == "Success") {
        this.places = test.data;
      } else {
        alert("Error");
      }
    },
  },
  watch: {
    'barangay' : function (newVal, oldVal) {
      if (newVal != oldVal) {
        this.generateAddress(newVal);
      }
    },
  },
  props: ["setAddress", "toggle"],
};
</script>