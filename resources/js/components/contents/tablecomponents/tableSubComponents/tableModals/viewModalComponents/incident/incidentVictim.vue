<template>
  <div class="bg-gray-50 p-4 rounded-lg shadow">
    <h3 class="text-lg font-semibold text-gray-900 mb-3">Victims</h3>
    <div class="space-y-2 max-h-40 overflow-y-auto">
      <div v-for="(dt, index) in data" :key="index" class="bg-white p-2 rounded shadow-sm">
        <p class="font-semibold">{{ dt.firstname }} {{ dt.lastname }}</p>
        <p class="text-sm text-gray-600">{{ dt.mobile_phone }}</p>
      </div>
      <p v-if="data.length === 0" class="text-gray-500 italic">No victims recorded</p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: {},
      dateForm: [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ],
    };
  },
  created() {
    (async () => {
      const send = await {
        url: "api/incidents/view/victim/list/request",
        data: {
          id: this.incidentId,
        },
      };
      await this.sendData(send);
    })();
  },
  props: ["incidentId"],
  methods: {
    async sendData(param) {
      console.log(param);
      const data = await this.$store.dispatch("sendData", param);
      const res = await data["response"];

      if (res != "Success") {
        await alert("An error occured, please try again.");
      } else {
        this.data = await data["data"];
        console.log(this.data);
      }
    },
    formatTime(timeString) {
    const [hours, minutes, seconds] = timeString.split(':').map(Number);

    const suffix = hours >= 12 ? 'PM' : 'AM';

    const formattedHours = hours % 12 || 12; 

    const formattedMinutes = minutes.toString().padStart(2, '0');

    return `${formattedHours}:${formattedMinutes} ${suffix}`;
}
  },
};
</script>