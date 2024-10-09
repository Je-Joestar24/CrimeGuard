<template>
  <div class="bg-white p-6 rounded-xl shadow-lg">
    <h3 class="text-2xl font-bold text-indigo-600 mb-4">Background Information</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-lg font-semibold text-gray-700 mb-2">Education & Occupation</h4>
        <div class="space-y-2 max-h-48 overflow-y-auto">
          <div class="flex items-center space-x-2">
            <span class="text-sm font-medium text-gray-500">Highest Education:</span>
            <span class="text-sm font-semibold text-gray-700">{{ data.highest_educ_attainment || 'N/A' }}</span>
          </div>
          <div class="flex items-center space-x-2">
            <span class="text-sm font-medium text-gray-500">Occupation:</span>
            <span class="text-sm font-semibold text-gray-700">{{ data.occupation || 'N/A' }}</span>
          </div>
        </div>
      </div>

      <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-lg font-semibold text-gray-700 mb-2">PNP Background</h4>
        <div class="space-y-2 max-h-48 overflow-y-auto">
          <div class="flex items-center space-x-2">
            <span class="text-sm font-medium text-gray-500">Rank:</span>
            <span class="text-sm font-semibold text-gray-700">{{ data.pnp_rank || 'N/A' }}</span>
          </div>
          <div class="flex items-center space-x-2">
            <span class="text-sm font-medium text-gray-500">Unit Assignment:</span>
            <span class="text-sm font-semibold text-gray-700">{{ data.unit_assignment || 'N/A' }}</span>
          </div>
          <div class="flex items-center space-x-2">
            <span class="text-sm font-medium text-gray-500">Group Affiliation:</span>
            <span class="text-sm font-semibold text-gray-700">{{ data.group_affiliation || 'N/A' }}</span>
          </div>
        </div>
      </div>

      <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-lg font-semibold text-gray-700 mb-2">Work Address</h4>
        <div class="space-y-2 max-h-48 overflow-y-auto">
          <div class="flex items-center space-x-2">
            <span class="text-sm font-medium text-gray-500">Street:</span>
            <span class="text-sm font-semibold text-gray-700">{{ data.street || 'N/A' }}</span>
          </div>
          <div class="flex items-center space-x-2">
            <span class="text-sm font-medium text-gray-500">Village:</span>
            <span class="text-sm font-semibold text-gray-700">{{ data.village || 'N/A' }}</span>
          </div>
          <div class="flex items-center space-x-2">
            <span class="text-sm font-medium text-gray-500">Barangay:</span>
            <span class="text-sm font-semibold text-gray-700">{{ data.barangay || 'N/A' }}</span>
          </div>
          <div class="flex items-center space-x-2">
            <span class="text-sm font-medium text-gray-500">City:</span>
            <span class="text-sm font-semibold text-gray-700">{{ data.city || 'N/A' }}</span>
          </div>
          <div class="flex items-center space-x-2">
            <span class="text-sm font-medium text-gray-500">Province:</span>
            <span class="text-sm font-semibold text-gray-700">{{ data.province || 'N/A' }}</span>
          </div>
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
      viewApis: {
        innerIncident: "",
        innerSuspects: "api/suspects/view/backgorund_info/details/request",
        innerSuspectsArchive: "api/suspects/view/backgorund_info/details/request",
        innerVictims: "",
        innerWitnesses: "",
        innerNameIncidents: "",
      },
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
    //alert(this.suspectIdRequest)
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