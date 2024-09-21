<template>
  <div class="w-full col-span-1 gap-1 flex flex-col p-2 text-xs">
    <h1 class="text-xs font-bold underline p-1 ps-4 text-start">BACKGROUND:</h1>

    <div class="flex w-full gap-2 px-1">
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">HIGHEST EDUCATION ATTAINMENT</label>
        <input
          v-if="data['highest_educ_attainment'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['highest_educ_attainment']"
          type="text"
        />
        <input
          v-if="data['highest_educ_attainment'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">OCCUPATION</label>
        <input
          v-if="data['occupation'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['occupation']"
          type="text"
        />
        <input
          v-if="data['occupation'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
    </div>
  </div>

  <div class="w-full col-span-1 gap-1 flex flex-col p-2 text-xs">
    <h1 class="text-xs font-bold underline p-1 ps-4 text-start">
      PNP BACKGROUND:
    </h1>

    <div class="flex w-full gap-2 px-1">
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">RANK</label>
        <input
          v-if="data['pnp_rank'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['pnp_rank']"
          type="text"
        />
        <input
          v-if="data['pnp_rank'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">UNIT ASSIGNMENT</label>
        <input
          v-if="data['unit_assignment'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['unit_assignment']"
          type="text"
        />
        <input
          v-if="data['unit_assignment'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">GROUP AFFILIATION</label>
        <input
          v-if="data['group_affiliation'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['group_affiliation']"
          type="text"
        />
        <input
          v-if="data['group_affiliation'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
    </div>
  </div>
  <div class="w-full col-span-1 gap-1 flex flex-col p-2 text-xs">
    <h1 class="text-xs font-bold underline p-1 ps-4 text-start">
      WORK ADDRESS:
    </h1>

    <div class="flex w-full gap-2 px-1">
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">STREET</label>
        <input
          v-if="data['street'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['street']"
          type="text"
        />
        <input
          v-if="data['street'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">VILLAGE</label>
        <input
          v-if="data['village'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['village']"
          type="text"
        />
        <input
          v-if="data['village'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">BARANGAY</label>
        <input
          v-if="data['barangay'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['barangay']"
          type="text"
        />
        <input
          v-if="data['barangay'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">CITY</label>
        <input
          v-if="data['city'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['city']"
          type="text"
        />
        <input
          v-if="data['city'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">PROVINCE</label>
        <input
          v-if="data['province'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['province']"
          type="text"
        />
        <input
          v-if="data['province'] == null"
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