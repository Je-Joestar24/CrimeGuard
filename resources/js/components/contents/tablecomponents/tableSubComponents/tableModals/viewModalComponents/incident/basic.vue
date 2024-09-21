<template>
  <div class="flex p-1 gap-0.5" style="height: 9vh">
    <span
      class="border-black border-2 p-4  text-white font-bold bg-red-600 w-1/2 flex flex-col justify-center"
      :class="{'text-xl': ((data.incident_name + '').length) > 7, 'text-5xl': ((data.incident_name + '').length) <= 7}"
      >{{ data.incident_name }}</span
    >
    <div class="bg-gray-700 w-full flex flex-col">
      <div class="bg-white w-full flex">
        <div class="w-full flex flex-col justify-start">
          <label class="text-start text-gray-900 text-xs" for=""
            >Date of Incident:</label
          >
          <p
            class="w-full rounded-md text-gray-950 text-start ps-2 font-bold pointer-events-none"
          >
            {{ (data2.date_ofInc == null || data2.date_ofInc == '') ? 'NO DATA' : data2.date_ofInc }}
          </p>
        </div>
        <div class="w-full flex flex-col justify-start">
          <label class="text-start text-gray-900 text-xs" for=""
            >Time of Incident:</label
          >
          <p
            class="w-full rounded-md text-gray-950 text-start ps-2 font-bold pointer-events-none"
          >
          {{ (data2.time_ofInc == null || data2.time_ofInc == '') ? 'NO DATA' : data2.time_ofInc }}
          </p>
        </div>
        <div class="w-full flex flex-col justify-start">
          <label class="text-start text-gray-900 text-xs" for=""
            >Date of Reported:</label
          >
          <p
            v-if="true"
            class="w-full rounded-md text-gray-950 text-start ps-2 font-bold pointer-events-none"
          >
          {{ (data2.date_report == null || data2.date_report == '') ? 'NO DATA' : data2.date_report }}
          </p>
        </div>
        <div class="w-full flex flex-col justify-start">
          <label class="text-start text-gray-900 text-xs" for=""
            >Time of Reported:</label
          >
          <p
            v-if="true"
            class="w-full rounded-md text-gray-950 text-start ps-2 font-bold pointer-events-none"
          >
          {{ (data2.time_report == null || data2.time_report == '') ? 'NO DATA' : data2.time_report }}
          </p>
        </div>
      </div>
      <div class="bg-white w-full flex mt-0.5 pb-0.5">
        <div class="w-full flex flex-col justify-start">
          <label class="text-start text-gray-900 text-xs" for=""
            >Location:</label
          >
          <p
            class="w-full rounded-md text-gray-950 text-start ps-2 font-bold pointer-events-none"
          > 
          {{ (data.location == null || data.location == '') ? 'NO DATA' : data.location }}
          </p>
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