<template>
  <div class="bg-gray-50 p-4 rounded-lg shadow">
    <h3 class="text-lg font-semibold text-gray-900 mb-3">Incident Narrative</h3>
    <p class="text-gray-700 whitespace-pre-wrap">{{ data.details || 'No narrative available.' }}</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: {},
    };
  },
  created() {
    (async () => {
      const send = await {
        url: "api/incidents/view/narative/details/request",
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
      const [hours, minutes, seconds] = timeString.split(":").map(Number);

      const suffix = hours >= 12 ? "PM" : "AM";

      const formattedHours = hours % 12 || 12;

      const formattedMinutes = minutes.toString().padStart(2, "0");

      return `${formattedHours}:${formattedMinutes} ${suffix}`;
    },
  },
};
</script>