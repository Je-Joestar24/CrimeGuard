<template>
  <div class="flex p-3 bg-gradient-to-tr from-blue-700 to-blue-600">
    <img :src="'/images/system/bg.png'" alt="" class="w-6 h-6 inline" />
    <h2 class="text-xl font-semibold text-center m-auto text-white">
      CRIMEGUARD
    </h2>
  </div>
  <div class="bg-gray-100 p-4 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Recent Incidents</h2>

    <ul
      class="space-y-4 overflow-auto overflow-x-hidden"
      style="max-height: 70vh"
    >
      <div v-motion-slide-visible-right v-for="(el, i) in arr" :key="el.id">
        <li
          class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300"
        >
          <div class="flex items-center justify-between">
            <span class="text-lg font-semibold text-gray-800">{{
              el.incident
            }}</span>
            <span class="text-sm text-gray-500">{{
              formatDate(el.date, el.month)
            }}</span>
          </div>
          <p class="text-gray-600 mt-2">{{ el.location }}</p>
          <div class="flex justify-between items-center mt-3">
            <span class="text-sm font-medium text-blue-600">{{ el.time }}</span>
            <span
              class="text-xs bg-gray-200 text-gray-700 px-2 py-1 rounded-full"
              >Case #{{ el.id }}</span
            >
          </div>
        </li>
      </div>
    </ul>

    <p v-if="arr.length === 0" class="text-center text-gray-500 mt-8">
      No recent incidents to display at this time.
    </p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      arr: [],
      month: [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ],
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    async fetchData() {
      const data = await this.$store.dispatch(
        "generateTableData",
        "api/incidents/citizen/view/display"
      );
      if (data.response === "Success") {
        this.arr = await Promise.all(
          data.data.map(async (element) => {
            element.time = await this.$store.dispatch(
              "militaryToNormalTime",
              element.time
            );
            return element;
          })
        );
      }
    },
    formatDate(date, monthIndex) {
      return `${this.month[monthIndex - 1]} ${date}`;
    },
  },
  computed: {
    isPhone() {
      return window.innerWidth <= 768;
    },
  },
};
</script>