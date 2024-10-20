<template>
  <div class="relative">
    <input
      type="text"
      v-model="barangay"
      class="w-full py-2 px-10 text-sm text-violet-900 border border-violet-300 rounded-lg bg-white focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-300"
      placeholder="Search Barangay"
      required
    />
    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
      <svg class="w-4 h-4 text-violet-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
      </svg>
    </div>
    <button @click="toggle" class="absolute inset-y-0 right-0 flex items-center pr-3">
      <svg class="w-4 h-4 text-violet-500 hover:text-violet-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18" />
        <line x1="6" y1="6" x2="18" y2="18" />
      </svg>
    </button>
  </div>
  <div class="mt-2 w-64 max-h-60 overflow-y-auto bg-white rounded-lg shadow-md absolute z-50">
    <ul class="divide-y divide-violet-100">
      <li 
        v-for="place in places" 
        :key="place"
        @click="setAddress(place)"
        class="px-4 py-2 hover:bg-violet-50 cursor-pointer transition-colors duration-150 ease-in-out"
      >
        {{ place }}
      </li>
    </ul>
    <div v-if="places.length === 0" class="px-4 py-2 text-violet-500 text-center">
      No barangays found
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