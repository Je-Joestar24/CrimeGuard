<template>
  <div class="border m-1 p-2 rounded-md h-full flex-col">
    <h1 class="border-b border-black text-gray-800 font-bold text-start">
      INCIDENT NARRATIVE
    </h1>
    <div class="w-full">
      <textarea
        id="message"
        rows="5"
        class="mt-3 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
        disabled
      >
      {{ data.details }}
            </textarea
      >
    </div>
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