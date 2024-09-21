<template>
  <div
    class="w-full border m-1 p-2 rounded-md flex flex-col"
    style="height: 25vh"
  >
    <h1
      class="text-start text-gray-700 font-bold border-b mb-2 border-gray-900"
    >
      Suspect
    </h1>
    <div class="w-full border-b flex-col" style="height: 20vh">
      <div v-for="dt in data" class="flex border-b">
        <span class="text-gray-900 w-full text-start font-semibold"
          >{{ dt.firstname }} {{ dt.lastname }}</span
        >
        <span class="text-gray-900 w-full text-end">{{ dt.mobile_phone }}</span>
      </div>
      <div v-if="data.length == 0" class="flex-col h-full py-5 bg-gray-100">
        <span class=" h-full text-2xl">NO DATA</span>
      </div>
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
        url: "api/incidents/view/suspects/list/request",
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