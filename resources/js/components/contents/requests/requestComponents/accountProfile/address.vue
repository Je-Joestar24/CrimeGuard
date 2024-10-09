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
          <AddressField label="Street" :value="data.current_street" color="blue" />
          <AddressField label="House No." :value="data.current_house_number" color="blue" />
          <AddressField label="Village" :value="data.current_village" color="blue" />
          <AddressField label="Barangay" :value="data.current_barangay" color="blue" />
          <AddressField label="City" :value="data.current_city" color="blue" />
          <AddressField label="Province" :value="data.current_province" color="blue" />
        </div>
      </div>
      <div v-else-if="selectedAddress === 'other'" key="other" class="bg-gradient-to-br from-purple-50 to-pink-50 p-5 rounded-lg shadow-inner">
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
          <span class="font-medium mr-2" :class="{'text-blue-700': color === 'blue', 'text-purple-700': color === 'purple'}">{{ label }}:</span>
          <span class="text-gray-800">{{ value || 'No data' }}</span>
        </div>
      `
    }
  },
  data() {
    return {
      data: {},
      selectedAddress: 'current'
    };
  },
  created() {
    this.fetchData();
  },
  props: ["suspectIdRequest"],
  methods: {
    async fetchData() {
      const send = {
        url: 'api/users/view/addresses/details/request',
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