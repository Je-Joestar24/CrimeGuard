<template>
  <div class="bg-white p-6 rounded-xl shadow-lg">
    <h3 class="text-2xl font-bold text-indigo-600 mb-4">Physical Characteristics</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-lg font-semibold text-gray-700 mb-2">Hair</h4>
        <div class="space-y-2">
          <div class="flex items-center space-x-2">
            <span class="text-sm font-medium text-gray-500">Color:</span>
            <span class="text-sm font-semibold text-gray-700">{{ data.hair_color || 'N/A' }}</span>
          </div>
          <div class="flex items-center space-x-2">
            <span class="text-sm font-medium text-gray-500">Description:</span>
            <span class="text-sm font-semibold text-gray-700">{{ data.hair_description || 'N/A' }}</span>
          </div>
        </div>
      </div>

      <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-lg font-semibold text-gray-700 mb-2">Eyes</h4>
        <div class="space-y-2">
          <div class="flex items-center space-x-2">
            <span class="text-sm font-medium text-gray-500">Color:</span>
            <span class="text-sm font-semibold text-gray-700">{{ data.eyes_color || 'N/A' }}</span>
          </div>
          <div class="flex items-center space-x-2">
            <span class="text-sm font-medium text-gray-500">Description:</span>
            <span class="text-sm font-semibold text-gray-700">{{ data.eyes_description || 'N/A' }}</span>
          </div>
        </div>
      </div>

      <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-lg font-semibold text-gray-700 mb-2">Body</h4>
        <div class="space-y-2">
          <div class="flex items-center space-x-2">
            <span class="text-sm font-medium text-gray-500">Height:</span>
            <span class="text-sm font-semibold text-gray-700">{{ data.height || 'N/A' }}</span>
          </div>
          <div class="flex items-center space-x-2">
            <span class="text-sm font-medium text-gray-500">Weight:</span>
            <span class="text-sm font-semibold text-gray-700">{{ data.weight || 'N/A' }}</span>
          </div>
          <div class="flex items-center space-x-2">
            <span class="text-sm font-medium text-gray-500">Build:</span>
            <span class="text-sm font-semibold text-gray-700">{{ data.built || 'N/A' }}</span>
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
        innerSuspects:
          "api/suspects/view/physical_characteristics/details/request",
          innerSuspectsArchive:
          "api/suspects/view/physical_characteristics/details/request",
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