<template>
  <div class="bg-white p-6 rounded-xl shadow-lg">
    <h3 class="text-2xl font-bold text-indigo-600 mb-4">Previous Victims</h3>
    
    <div class="bg-gray-50 p-4 rounded-lg">
      <div class="max-h-40 overflow-y-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-100">
            <tr>
              <th v-for="header in table.headers" :key="header" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ header }}
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="(row, index) in table.data" :key="index">
              <td v-for="(col, colIndex) in Object.values(row)" :key="colIndex" class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">
                {{ col || 'N/A' }}
              </td>
            </tr>
            <tr v-if="table.data.length === 0">
              <td :colspan="table.headers.length" class="px-4 py-2 text-center text-sm text-gray-500">
                No previous victims
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      table: {
        headers: [
          "INCIDENT",
          "LAST NAME",
          "FIRSTNAME",
          "MIDDLE NAME",
          "AGE",
          "GENDER",
          "DATE OF INCIDENT",
        ],
        data: [],
        temp: [
          "w-full text-gray-800 font-bold",
          "w-1/2",
          "w-1/2",
          "w-1/2",
          "w-1/6",
          "w-2/6",
          "w-3/6",
        ],
      },
      viewApis: {
        innerIncident: "",
        innerSuspects: "api/suspects/view/prevVictims/details/request",
        innerSuspectsArchive: "api/suspects/view/prevVictims/details/request",
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
        this.table.data = await data["data"];
        console.log(this.table.data);
      }
    },
  },
};
</script>