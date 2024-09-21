<template>
  <div
    class="flex gap- text-start p-1 mt-3 border-b border-gray-700 text-gray-900 text-xs font-bold mx-1"
  >
    <div v-for="(heads, i) of table.headers" :class="table.temp[i]">
      {{ heads }}
    </div>
  </div>

  <div
    class="mx-1 mt-1 flex flex-col border-b border-gray-700 overflow-auto"
    style="height: 35vh"
  >
    <div
      v-if="table.data.length == 0"
      class="flex h-full justify-center items-center text-2xl text-gray-400"
    >
      NO PREVIOUS VICTIMS
    </div>
    <div
      v-for="row of table.data"
      v-if="table.data.length != 0"
      class="flex text-start px-1 pt-1 shadow"
    >
      <div v-for="(col, i) of Object.values(row)" :class="table.temp[i]">
        <span v-if="col != null || col != ''">{{ col }}</span>
        <span v-if="col == null || col == ''">No data</span>
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