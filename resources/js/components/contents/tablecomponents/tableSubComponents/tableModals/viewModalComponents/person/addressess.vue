<template>
  <div class="w-full col-span-1 gap-1 flex flex-col p-2 text-xs">
    <h1 class="text-xs font-bold underline p-1 ps-4 text-start">
      CURRENT ADDRESS:
    </h1>

    <div class="flex w-full gap-2 px-1">
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">STREET</label>
        <input
          v-if="data['current_street'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['current_street']"
          type="text"
        />
        <input
          v-if="data['current_street'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">HOUSE NO.</label>
        <input
        v-if="data['current_house_number'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['current_house_number']"
          type="text"
        />
        <input
          v-if="data['current_house_number'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">VILLAGE</label>
        <input
          v-if="data['current_village'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['current_village']"
          type="text"
        />
        <input
          v-if="data['current_village'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">BARANGAY</label>
        <input
          v-if="data['current_barangay'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['current_barangay']"
          type="text"
        />
        <input
          v-if="data['current_barangay'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">CITY</label>
        <input
          v-if="data['current_city'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['current_city']"
          type="text"
        />
        <input
          v-if="data['current_city'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">PROVINCE</label>
        <input
          v-if="data['current_province'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['current_province']"
          type="text"
        />
        <input
          v-if="data['current_province'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
    </div>
  </div>
  <div class="w-full col-span-1 gap-1 flex flex-col p-2 text-xs">
    <h1 class="text-xs font-bold underline p-1 ps-4 text-start">
      OTHER ADDRESS:
    </h1>

    <div class="flex w-full gap-2 px-1">
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">STREET</label>
        <input
          v-if="data['other_street'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['other_street']"
          type="text"
        />
        <input
          v-if="data['other_street'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">HOUSE NO.</label>
        <input
        v-if="data['other_house_number'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['other_house_number']"
          type="text"
        />
        <input
          v-if="data['other_house_number'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">VILLAGE</label>
        <input
          v-if="data['other_village'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['other_village']"
          type="text"
        />
        <input
          v-if="data['other_village'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">BARANGAY</label>
        <input
          v-if="data['other_barangay'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['other_barangay']"
          type="text"
        />
        <input
          v-if="data['other_barangay'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">CITY</label>
        <input
          v-if="data['other_city'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['other_city']"
          type="text"
        />
        <input
          v-if="data['other_city'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">PROVINCE</label>
        <input
          v-if="data['other_province'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['other_province']"
          type="text"
        />
        <input
          v-if="data['other_province'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
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