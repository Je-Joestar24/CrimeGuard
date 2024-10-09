<template>
  <div class="bg-white p-4 rounded-xl shadow-lg max-h-[80vh] overflow-y-auto">
    <h3 class="text-2xl font-bold text-indigo-700 mb-4 sticky top-0 bg-white z-10 pb-2">Addresses</h3>
    
    <div class="mb-4 sticky top-12 bg-white z-10 pb-2">
      <label class="inline-flex items-center">
        <input type="radio" class="form-radio text-indigo-600" v-model="selectedAddress" value="current">
        <span class="ml-2 text-gray-700">Current Address</span>
      </label>
      <label class="inline-flex items-center ml-6">
        <input type="radio" class="form-radio text-indigo-600" v-model="selectedAddress" value="other">
        <span class="ml-2 text-gray-700">Other Address</span>
      </label>
    </div>

    <transition name="fade" mode="out-in">
      <div v-if="selectedAddress === 'current'" key="current" class="bg-gradient-to-br from-indigo-50 to-blue-50 p-5 rounded-lg shadow-inner">
        <h4 class="text-lg font-semibold text-indigo-800 mb-3">Current Address</h4>
        <div class="space-y-3 text-sm grid grid-cols-3 gap-3">
          <AddressField label="Street" :value="data.current_street" color="indigo" />
          <AddressField label="House No." :value="data.current_house_number" color="indigo" />
          <AddressField label="Village" :value="data.current_village" color="indigo" />
          <AddressField label="Barangay" :value="data.current_barangay" color="indigo" />
          <AddressField label="City" :value="data.current_city" color="indigo" />
          <AddressField label="Province" :value="data.current_province" color="indigo" />
        </div>
      </div>

      <div v-else key="other" class="bg-gradient-to-br from-purple-50 to-pink-50 p-5 rounded-lg shadow-inner">
        <h4 class="text-lg font-semibold text-purple-800 mb-3">Other Address</h4>
        <div class="space-y-3 text-sm grid grid-cols-3 gap-3">
          <AddressField label="Street" :value="data.other_street" color="purple" />
          <AddressField label="House No." :value="data.other_house_number" color="purple" />
          <AddressField label="Village" :value="data.other_village" color="purple" />
          <AddressField label="Barangay" :value="data.other_barangay" color="purple" />
          <AddressField label="City" :value="data.other_city" color="purple" />
          <AddressField label="Province" :value="data.other_province" color="purple" />
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  components: {
    AddressField: {
      props: ['label', 'value', 'color'],
      template: `
        <div class="flex items-center">
          <span class="font-medium" :class="'text-' + color + '-600'" style="width: 7rem;">{{ label }}:</span>
          <input 
            :value="value || 'N/A'" 
            class="flex-1 bg-white border rounded px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 transition"
            :class="'border-' + color + '-200 focus:ring-' + color + '-400'"
            readonly
          />
        </div>
      `
    }
  },
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
        regRequests: 'api/users/view/addresses/details/request',
        innerAccountsArchive: "api/users/view/addresses/details/request",
        innerCitizenAccounts: "api/users/view/addresses/details/request",
        innerOfficerAccounts: "api/users/view/addresses/details/request",
      },
      data: {},
      selectedAddress: 'current',
    };
  },
  created() {
    if (this.viewApis[this.$store.getters.getActive] != null) {
      this.fetchData();
    }
  },
  props: ["suspectIdRequest"],
  methods: {
    async fetchData() {
      const send = {
        url: this.viewApis[this.$store.getters.getActive],
        data: { id: this.suspectIdRequest },
      };
      await this.sendData(send);
    },
    async sendData(param) {
      try {
        const data = await this.$store.dispatch("sendData", param);
        if (data.response === "Success") {
          this.data = data.data;
        } else {
          throw new Error("Failed to fetch data");
        }
      } catch (error) {
        console.error("Error fetching data:", error);
        alert("An error occurred, please try again.");
      }
    },
  },
};
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>