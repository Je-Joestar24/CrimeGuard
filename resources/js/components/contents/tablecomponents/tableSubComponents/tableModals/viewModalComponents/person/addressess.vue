<template>
  <div class="bg-white p-4 rounded-xl shadow-lg">
    <h3 class="text-xl font-bold text-indigo-600 mb-3">Addresses</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="bg-gray-50 p-3 rounded-lg">
        <h4 class="text-base font-semibold text-gray-700 mb-2">Current Address</h4>
        <div class="space-y-1 max-h-32 overflow-y-auto text-sm">
          <p><span class="font-medium text-gray-500">Street:</span> {{ data.current_street || 'N/A' }}</p>
          <p><span class="font-medium text-gray-500">House No.:</span> {{ data.current_house_number || 'N/A' }}</p>
          <p><span class="font-medium text-gray-500">Village:</span> {{ data.current_village || 'N/A' }}</p>
          <p><span class="font-medium text-gray-500">Barangay:</span> {{ data.current_barangay || 'N/A' }}</p>
          <p><span class="font-medium text-gray-500">City:</span> {{ data.current_city || 'N/A' }}</p>
          <p><span class="font-medium text-gray-500">Province:</span> {{ data.current_province || 'N/A' }}</p>
        </div>
      </div>

      <div class="bg-gray-50 p-3 rounded-lg">
        <h4 class="text-base font-semibold text-gray-700 mb-2">Other Address</h4>
        <div class="space-y-1 max-h-32 overflow-y-auto text-sm">
          <p><span class="font-medium text-gray-500">Street:</span> {{ data.other_street || 'N/A' }}</p>
          <p><span class="font-medium text-gray-500">House No.:</span> {{ data.other_house_number || 'N/A' }}</p>
          <p><span class="font-medium text-gray-500">Village:</span> {{ data.other_village || 'N/A' }}</p>
          <p><span class="font-medium text-gray-500">Barangay:</span> {{ data.other_barangay || 'N/A' }}</p>
          <p><span class="font-medium text-gray-500">City:</span> {{ data.other_city || 'N/A' }}</p>
          <p><span class="font-medium text-gray-500">Province:</span> {{ data.other_province || 'N/A' }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      viewApis: {
        innerIncident: "",
        innerSuspects: "api/suspects/view/addresses/details/request",
        innerVictims: "api/victims/view/addresses/details/request",
        innerWitnesses: "api/witness/view/addresses/details/request",
        innerSuspectsArchive: "api/suspects/view/addresses/details/request",
        innerVictimsArchive: "api/victims/view/addresses/details/request",
        innerWitnessesArchive: "api/witness/view/addresses/details/request",
        innerNameIncidents: "",
      },
      data: {},
    };
  },
  created() {
    if (this.viewApis[this.$store.getters.getActive] != null) {
      (async () => {
        const send = await {
          url: this.viewApis[this.$store.getters.getActive],
          data: {
            id: this.suspectIdRequest,
          },
        };
        await this.sendData(send);
      })();
    }
  },
  props: ["suspectIdRequest"],
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
  },
};
</script>