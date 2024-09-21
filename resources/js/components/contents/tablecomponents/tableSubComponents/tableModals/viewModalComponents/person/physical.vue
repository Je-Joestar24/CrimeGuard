<template>
  <div class="w-full col-span-1 gap-1 flex flex-col p-2 text-xs">
    <h1 class="text-xs font-bold underline p-1 ps-4 text-start">HAIR:</h1>

    <div class="flex w-full gap-2 px-1">
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">HAIR COLOR</label>
        <input
          v-if="data['hair_color'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['hair_color']"
          type="text"
        />
        <input
          v-if="data['hair_color'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">DESCRIPTION OF HAIR</label>
        <input
          v-if="data['hair_description'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['hair_description']"
          type="text"
        />
        <input
          v-if="data['hair_description'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
    </div>
  </div>
  <div class="w-full col-span-1 gap-1 flex flex-col p-2 text-xs">
    <h1 class="text-xs font-bold underline p-1 ps-4 text-start">EYES:</h1>

    <div class="flex w-full gap-2 px-1">
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">EYES COLOR</label>
        <input
          v-if="data['eyes_color'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['eyes_color']"
          type="text"
        />
        <input
          v-if="data['eyes_color'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">DESCRIPTION OF EYES</label>
        <input
          v-if="data['eyes_description'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['eyes_description']"
          type="text"
        />
        <input
          v-if="data['eyes_description'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
    </div>
  </div>
  <div class="w-full col-span-1 gap-1 flex flex-col p-2 text-xs">
    <h1 class="text-xs font-bold underline p-1 ps-4 text-start">BODY:</h1>

    <div class="flex w-full gap-2 px-1">
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">HEIGHT</label>
        <input
          v-if="data['height'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['height']"
          type="text"
        />
        <input
          v-if="data['height'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">WEIGHT</label>
        <input
          v-if="data['weight'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['weight']"
          type="text"
        />
        <input
          v-if="data['weight'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">BUILT</label>
        <input
          v-if="data['built'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['built']"
          type="text"
        />
        <input
          v-if="data['built'] == null"
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