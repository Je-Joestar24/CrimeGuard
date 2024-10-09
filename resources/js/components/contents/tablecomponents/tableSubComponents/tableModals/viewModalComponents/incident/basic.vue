<template>
  <div class="bg-gray-50 p-4 rounded-lg shadow">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="space-y-2">
        <h3 class="text-xl font-bold text-red-600">{{ data.incident_name }}</h3>
        <div class="space-y-1">
          <p class="text-sm text-gray-600">Date of Incident:</p>
          <p class="font-semibold">{{ data2.date_ofInc || 'NO DATA' }}</p>
        </div>
        <div class="space-y-1">
          <p class="text-sm text-gray-600">Time of Incident:</p>
          <p class="font-semibold">{{ data2.time_ofInc || 'NO DATA' }}</p>
        </div>
      </div>
      <div class="space-y-2">
        <div class="space-y-1">
          <p class="text-sm text-gray-600">Date Reported:</p>
          <p class="font-semibold">{{ data2.date_report || 'NO DATA' }}</p>
        </div>
        <div class="space-y-1">
          <p class="text-sm text-gray-600">Time Reported:</p>
          <p class="font-semibold">{{ data2.time_report || 'NO DATA' }}</p>
        </div>
        <div class="space-y-1">
          <p class="text-sm text-gray-600">Location:</p>
          <p class="font-semibold">{{ data.location || 'NO DATA' }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: {},
      data2: {
        date_ofInc: "",
        time_ofInc: "",
        date_report: "",
        time_report: ""
      },
      dateForm: [
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
  created() {
    (async () => {
      const send = await {
        url: "api/incidents/view/basic/details/request",
        data: {
          id: this.incidentId,
        },
      };
      await this.sendData(send);
      await this.formatEverything();
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
      const timein = `${timeString}`.split(":");
      const suffix = timein[0] >= 12 ? "PM" : "AM";

      const formattedHours = timein[0] % 12 || 12;

      const formattedMinutes = timein[1];

      return `${formattedHours}:${formattedMinutes} ${suffix}`;
    },
    formatEverything() {
      this.data2.date_ofInc =
        this.dateForm[this.data.date_of_incident.split("-")[1] - 1] +
        " " +
        this.data.date_of_incident.split("-")[2] +
        ", " +
        this.data.date_of_incident.split("-")[0];

      this.data2.time_ofInc = this.formatTime(this.data.time_of_incident.split(" ")[1]);
      this.data2.date_report = this.dateForm[this.data.date_reported.split("-")[1] - 1] +
              " " +
              this.data.date_of_incident.split("-")[2] +
              ", " +
              this.data.date_of_incident.split("-")[0];
      this.data2.time_report = this.formatTime(this.data.time_reported.split(" ")[1]);
      
    },
  },
};
</script>