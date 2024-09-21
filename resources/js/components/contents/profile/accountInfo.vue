<template>
  <div class="m-2 p-2 mt-2 border rounded-xl shadow-md bg-gray-100">
    <div class="grid grid-flow-col px-2 pt-1">
      <span class="text-lg font-semibold col-span-5">ACCOUNT INFORMATION</span>
      <button
        @click="edit = !edit"
        v-if="!edit"
        class="col-span-2 text-blue-500 text-end font-semibold"
      >
        EDIT
      </button>
      <button
        @click="edit = !edit"
        v-if="edit"
        class="col-span-2 text-red-500 text-end font-semibold"
      >
        CANCEL
      </button>
    </div>
    <div class="p-2 flex flex-row justify-center items-center gap-2">
      <div class="grid w-1/3 my-2">
        <label for="" class="text-xs font-semibold mb-1">USERNAME:</label>
        <input
          class="bg-gray-200 text-start  rounded-md border border-gray-500 w-full"
          :class="{'pointer-events-none':!edit}"
          type="text"
          v-model="info.user_name"
        />
      </div>
      <div class="grid w-full my-2">
        <label for="" class="text-xs font-semibold mb-1">EMAIL:</label>
        <input
          class="bg-gray-200 text-startrounded-md border border-gray-500 w-full"
          :class="{'pointer-events-none':!edit}"
          type="text"
          v-model="info.email"
        />
      </div>
    </div>
    <div v-if="edit" class="w-full px-3 text-end">
      <button @click="senData" class="text-sm text-white border-2 rounded-md px-3 bg-green-500">
        SAVE
      </button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      info: {
        user_name: "",
        email: "",
      },
      id: -1,
      edit: false,
    };
  },
  mounted() {
    const credentials = JSON.parse(localStorage.getItem("credentials"));
    this.id = credentials.id;
    this.generateData(this.id);
  },
  methods: {
    async generateData(rID) {
      const send = await {
        data: { id: rID },
        url: "api/officer/account/myaccount/view/request",
      };

      //console.log(send)
      const data = await this.$store.dispatch("sendData", send);

      if (data.response == "Success") {
        this.info = data.data;
      } else {
        alert();
      }
    },
    async senData() {
      if (this.info.user_name == "" || this.info.email == "") {
        alert("Invalid data!");
        return;
      }

      const send = await {
        data: {
          data: this.info,
          id: this.id,
        },
        url: "api/officer/updatebasic/myaccount/update/request",
      };

      //console.log(send)
      const data = await this.$store.dispatch("sendData", send);

      if (data.response == "Success") {
        this.info = data.data;
        this.generateData(this.id);
        this.edit = !this.edit;
      } else {
        alert("Error");
      }
    },
  },
};
</script>