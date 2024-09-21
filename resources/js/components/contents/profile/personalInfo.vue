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
      <div class="grid w-full my-2">
        <label for="" class="text-xs font-semibold mb-1">LAST NAME:</label>
        <input
          class="bg-gray-200 text-start rounded-md border border-gray-500 w-full"
          type="text"
          :class="{ 'pointer-events-none': !edit }"
          v-model="info.last_name"
        />
      </div>
      <div class="grid w-full my-2">
        <label for="" class="text-xs font-semibold mb-1">FIRST NAME:</label>
        <input
          class="bg-gray-200 text-start rounded-md border border-gray-500 w-full"
          type="text"
          :class="{ 'pointer-events-none': !edit }"
          v-model="info.first_name"
        />
      </div>
      <div class="grid w-full my-2">
        <label for="" class="text-xs font-semibold mb-1">MIDDLE NAME:</label>
        <input
          class="bg-gray-200 text-start rounded-md border border-gray-500 w-full"
          type="text"
          :class="{ 'pointer-events-none': !edit }"
          v-model="info.middle_name"
        />
      </div>
      <div class="grid w-3/4 my-2">
        <label for="" class="text-xs font-semibold mb-1">RANK:</label>
        <input
          class="bg-gray-200 text-start rounded-md border border-gray-500 w-full"
          type="text"
          :class="{ 'pointer-events-none': !edit }"
          v-model="cred.rank"
        />
      </div>
    </div>
    <div v-if="edit" class="w-full px-3 text-end">
      <button
        @click="senData"
        class="text-sm text-white border-2 rounded-md px-3 bg-green-500"
      >
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
        last_name: "",
        first_name: "",
        middle_name: "",
      },
      cred: {
        rank: "",
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
        url: "api/officer/personal/myaccount/view/request",
      };

      //console.log(send)
      const data = await this.$store.dispatch("sendData", send);

      if (data.response == "Success") {
        this.info = data.data;
        this.cred.rank = data.data.rank;
      } else {
        alert();
      }
    },
    async senData() {
      if (
        this.info.last_name == "" ||
        this.info.first_name == "" ||
        this.cred.rank == ""
      ) {
        alert("Invalid data!");
        return;
      }

      const send = await {
        data: {
          data: this.info,
          cred: this.cred,
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