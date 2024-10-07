<template>
  <div class="bg-gray-100 p-4 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Reported Incidents</h2>
    <p class="text-gray-600 mb-6 text-center">Review the incidents you've reported. This list helps you track the status of your reports and stay updated on any developments.</p>
    
    <div class="overflow-auto" style="max-height: 70vh">
      <ul class="space-y-4 overflow-auto overflow-x-hidden">
        <div  v-motion-slide-visible-right v-for="(el, i) in arr" :key="el.id">
          <li class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between mb-2">
              <span class="text-lg font-semibold text-gray-800">{{ el.incident }}</span>
              <span :class="getStatusClass(el.status)">{{ getStatusText(el.status) }}</span>
            </div>
            <p class="text-gray-600 mb-2">{{ el.location }}</p>
            <p class="text-gray-600 mb-2" v-if="el.landmark">Near: {{ el.landmark }}</p>
            <div class="flex justify-between items-center mt-3">
              <span class="text-sm font-medium text-blue-600">{{ el.time }}</span>
              <span class="text-sm text-gray-500">{{ formatDate(el.date, el.month) }}</span>
            </div>
          </li>
        </div>
      </ul>
    </div>

    <p v-if="arr.length === 0" class="text-center text-gray-500 mt-8">
      You haven't reported any incidents yet. If you witness or experience an incident, please report it promptly.
    </p>

    <p v-if="arr.length > 0" class="text-center text-gray-500 mt-8">
      End of reported incidents list. Thank you for your vigilance in keeping our community safe.
    </p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      arr: [],
      month: [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
      ],
      req: {
        url: "api/incidents/citizen/view/display2",
        data: {
          id: -1,
        },
      },
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    async fetchData() {
      const credentials = JSON.parse(localStorage.getItem("credentials"));
      this.req.data.id = credentials.id;
      const data = await this.$store.dispatch("sendData", this.req);
      if (data.response === "Success") {
        this.arr = await Promise.all(data.data.map(async (element) => {
          element.time = await this.$store.dispatch("militaryToNormalTime", element.time);
          return element;
        }));
      }
    },
    formatDate(date, monthIndex) {
      return `${this.month[monthIndex - 1]} ${date}`;
    },
    getStatusClass(status) {
      const baseClasses = "text-xs px-2 py-1 rounded-full";
      switch (status.toLowerCase()) {
        case 'under investigation':
          return `${baseClasses} bg-yellow-200 text-yellow-800`;
        case 'cleared':
          return `${baseClasses} bg-green-200 text-green-800`;
        case 'solved':
          return `${baseClasses} bg-blue-200 text-blue-800`;
        case 'pending':
          return `${baseClasses} bg-gray-200 text-gray-800`;
        default:
          return `${baseClasses} bg-gray-200 text-gray-800`;
      }
    },
    getStatusText(status) {
      switch (status.toLowerCase()) {
        case 'under investigation':
        case 'cleared':
        case 'solved':
        case 'pending':
          return status.charAt(0).toUpperCase() + status.slice(1);
        default:
          return 'Unknown';
      }
    }
  },
};
</script>