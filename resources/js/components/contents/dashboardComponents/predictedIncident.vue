<!-- Start of Selection -->
<template>
  <div
    class="col-span-3 border flex flex-col p-6 bg-violet-50 rounded-lg shadow-lg"
    role="region"
    aria-label="Predicted Incidents for Police Officers"
  >
    <h2 class="text-2xl font-bold text-violet-800 mb-4 text-center" role="heading" aria-level="2">
      Predicted Incidents for Today: {{ incidents.length }} incidents
    </h2>
    <p class="text-gray-600 mb-6 text-center" aria-label="Description of predicted incidents">
      Based on historical data and current trends, we anticipate a total of {{ incidents.length }} potential incidents occurring today. Please review the details below for more information on each predicted incident.
    </p>
    <div class="grid grid-cols-3 gap-4">
      <div
        v-for="incident in incidents"
        :key="incident.type"
        class="bg-blue-100 border-l-4 border-blue-600 p-6 mb-4 rounded-lg shadow-md w-full max-w-md transition-transform transform hover:scale-105"
        role="article"
        aria-label="Incident Details"
      >
        <h3 class="text-lg font-semibold text-blue-700 mb-2">
          {{ incident.name }}
        </h3>

        <p class="text-gray-700 flex flex-col">
          <span>BARANGAY:</span>
          <span class="font-medium text-blue-600"
            >{{ incident.barangay }}, Ormoc City, Leyte</span
          >
        </p>
        <p class="text-gray-700">
          Predicted Count:
          <span class="font-bold text-blue-800">{{ incident.count }}</span>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      incidents: [],
      filter: {
        date_start: "2024-10-25",
        date_end: "2024-11-25",
      },
    };
  },
  mounted() {
    (async () => {
      await this.getDate("date_start", 0);
      await this.getDate("date_end", 0);
      await this.generateData();
    })();
  },
  methods: {
    // Additional methods can be added here for future functionality
    async generateData() {
      const dt = await this.$store.dispatch("sendData", {
        url: "api/top/incidents/prediction/display",
        data: this.filter,
      });

      if (dt["response"] == "Success") {
        let data = dt["data"];
        for (let i = 0; i < data.length && i < 3; i++) {
          const barangay = await this.generateBData(data[i]["id"]);
          this.incidents.push({
            name: data[i]["incident"],
            count: Math.floor(data[i].predicted_count),
            barangay: barangay["barangay"],
          });
        }
      } else {
        alert("Error!");
      }
    },
    async generateBData(incident_id) {
      const dt = await this.$store.dispatch("sendData", {
        url: "api/incidents/top/baragay/prediction/display",
        data: { ...this.filter, inciddent_type: incident_id },
      });
      if (dt["response"] == "Success") {
        let data = dt["data"];
        if (data.length > 0) {
          return data[0];
        } else {
          return "Unsure";
        }
      } else {
        alert("Error!");
      }
    },
    getDate(key, add = 0) {
      const today = new Date();
      today.setMonth(today.getMonth() + add); // Adjust the month
      const year = today.getFullYear();
      const month = String(today.getMonth() + 1).padStart(2, "0"); // Month starts at 0, so add 1
      const day = String(today.getDate()).padStart(2, "0");
      this.filter[key] = `${year}-${month}-${day}`;
      console.log(this.filter);
    },
  },
};
</script>
<!-- End of Selection -->