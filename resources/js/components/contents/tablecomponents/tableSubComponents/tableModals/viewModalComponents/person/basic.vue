<template>
  <div class="bg-white p-6 rounded-xl shadow-lg">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <div class="space-y-4">
        <h3 class="text-2xl font-bold text-indigo-600">{{ data.first_name }} {{ data.last_name }}</h3>
        <div class="flex items-center space-x-2">
          <span class="text-sm font-medium text-gray-500">Middle Name:</span>
          <span class="text-sm font-semibold text-gray-700">{{ data.middle_name || 'N/A' }}</span>
        </div>
        <div class="flex items-center space-x-2">
          <span class="text-sm font-medium text-gray-500">Age:</span>
          <span class="text-sm font-semibold text-gray-700">{{ data.age || 'N/A' }}</span>
        </div>
        <div class="flex items-center space-x-2">
          <span class="text-sm font-medium text-gray-500">Gender:</span>
          <span class="text-sm font-semibold text-gray-700">
            <span v-if="data.gender === 'male'" class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full">Male</span>
            <span v-else-if="data.gender === 'female'" class="px-2 py-1 bg-pink-100 text-pink-800 rounded-full">Female</span>
            <span v-else class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full">N/A</span>
          </span>
        </div>
      </div>
      <div class="space-y-4">
        <div class="flex items-center space-x-2">
          <span class="text-sm font-medium text-gray-500">Nickname:</span>
          <span class="text-sm font-semibold text-gray-700">{{ data.nick_name || 'N/A' }}</span>
        </div>
        <div class="flex items-center space-x-2">
          <span class="text-sm font-medium text-gray-500">Facebook:</span>
          <span class="text-sm font-semibold text-blue-600 hover:underline">{{ data.facebook || 'N/A' }}</span>
        </div>
        <div class="flex items-center space-x-2">
          <span class="text-sm font-medium text-gray-500">Email:</span>
          <span class="text-sm font-semibold text-blue-600 hover:underline">{{ data.email || 'N/A' }}</span>
        </div>
      </div>
    </div>
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-gray-50 p-4 rounded-lg">
        <p class="text-sm font-medium text-gray-500 mb-1">Telephone</p>
        <p class="text-lg font-semibold text-gray-700">{{ data.telephone || 'N/A' }}</p>
      </div>
      <div class="bg-gray-50 p-4 rounded-lg">
        <p class="text-sm font-medium text-gray-500 mb-1">Contact</p>
        <p class="text-lg font-semibold text-gray-700">{{ data.contact || 'N/A' }}</p>
      </div>
      <div class="bg-gray-50 p-4 rounded-lg">
        <p class="text-sm font-medium text-gray-500 mb-1">Under the Influence</p>
        <p class="text-lg font-semibold text-gray-700">{{ data.under_influence || 'N/A' }}</p>
      </div>
      <div class="bg-gray-50 p-4 rounded-lg">
        <p class="text-sm font-medium text-gray-500 mb-1">Civil Status</p>
        <p class="text-lg font-semibold text-gray-700">{{ data.civil_status || 'N/A' }}</p>
      </div>
      <div class="bg-gray-50 p-4 rounded-lg">
        <p class="text-sm font-medium text-gray-500 mb-1">Nationality</p>
        <p class="text-lg font-semibold text-gray-700">{{ data.nationality || 'N/A' }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import { watch } from "vue";

export default {
  data() {
    return {
      viewApis: {
        innerIncident: "",
        innerSuspects: "api/suspects/view/basic/details/request",
        innerVictims: "api/victims/view/basic/details/request",
        innerWitnesses: "api/witness/view/basic/details/request",
        innerSuspectsArchive: "api/suspects/view/basic/details/request",
        innerVictimsArchive: "api/victims/view/basic/details/request",
        innerWitnessesArchive: "api/witness/view/basic/details/request",
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
    //console.log(sample);
  },
  props: ["suspectIdRequest", "setProf"],
  methods: {
    async sendData(param) {
      console.log(param);
      const data = await this.$store.dispatch("sendData", param);
      const res = await data["response"];

      if (res != "Success") {
        await alert("An error occured, please try again.");
      } else {
        this.data = await data["data"];
        this.data.gender = (""+this.data.gender).toLowerCase();
        if((this.$store.getters.getActive == 'innerSuspectsArchive' || this.$store.getters.getActive == 'innerVictimsArchive' || this.$store.getters.getActive == 'innerWitnessesArchive' || this.$store.getters.getActive == 'innerSuspects' || this.$store.getters.getActive == 'innerVictims' || this.$store.getters.getActive == 'innerWitnesses') && this.data.id_card_presented) this.setProf(this.data.id_card_presented);
        console.log(this.data);
      }
    },
  },
};
</script>