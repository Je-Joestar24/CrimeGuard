<template>
  <div
    v-if="!isPhone"
    class="m-4 p-2 mt-5 border rounded-xl shadow-md bg-gray-100"
  >
    <div class="grid grid-flow-col px-2 pt-1">
      <span class="text-lg font-semibold col-span-5">PERSONAL INFORMATION</span>
      <button
        v-if="!editOn"
        class="col-span-2 text-blue-500 text-center font-semibold"
        @click="editOn = !editOn"
      >
        EDIT
      </button>
      <button
        v-if="editOn"
        class="col-span-2 text-red-500 text-center font-semibold"
        @click="cancelIt"
      >
        CANCEL
      </button>
    </div>
    <div class="p-5 flex flex-col justify-center items-center">
      <div class="flex w-full gap-2">
        <div class="flex flex-col w-full">
          <label for="" class="text-xs font-semibold mb-1">LAST NAME:</label>
          <input
            class="bg-gray-200 text-center rounded-md border border-gray-500 w-full"
            :class="{ 'pointer-events-none': !editOn }"
            type="text"
            v-model="info.last_name"
          />
        </div>
        <div class="flex flex-col w-full">
          <label for="" class="text-xs font-semibold mb-1">FIRST NAME:</label>
          <input
            class="bg-gray-200 text-center rounded-md border border-gray-500 w-full"
            :class="{ 'pointer-events-none': !editOn }"
            type="text"
            v-model="info.first_name"
          />
        </div>
      </div>
      <div class="grid w-full my-2">
        <label for="" class="text-xs font-semibold mb-1">EMAIL:</label>
        <input
          class="bg-gray-200 text-start rounded-md border border-gray-500 w-full"
          :class="{ 'pointer-events-none': !editOn }"
          type="text"
          value="jejomarparrilla@gmail.com"
          v-model="info.email"
        />
      </div>
      <div class="grid w-full my-2">
        <label for="" class="text-xs font-semibold mb-1">CONTACT:</label>
        <input
          class="bg-gray-200 text-start rounded-md border border-gray-500 w-full"
          :class="{ 'pointer-events-none': !editOn }"
          type="text"
          v-model="info.contact"
        />
      </div>
    </div>
    <div v-if="editOn" class="w-full px-5 text-end">
      <button
        @click="sendData"
        class="text-sm text-white border-2 rounded-md px-3 py-1 bg-green-500"
      >
        SAVE
      </button>
    </div>
  </div>
  <div v-if="isPhone" class="m-4 p-2 mt-5 border-b">
    <div class="grid grid-flow-col px-2 pt-1">
      <span class="text-md font-semibold col-span-5 text-gray-600">PERSONAL INFORMATION</span>
      <button
        v-if="!editOn"
        class="col-span-2 text-blue-500 text-center font-semibold"
        @click="editOn = !editOn"
      >
        EDIT
      </button>
      <button
        v-if="editOn"
        class="col-span-2 text-red-500 text-center font-semibold"
        @click="cancelIt"
      >
        CANCEL
      </button>
    </div>
    <div
      class="p-5 flex flex-col gap-y-4 justify-center items-center text text-gray-600"
    >
      <div class="flex flex-col w-full">
        <label for="" class="text-xs font-semibold mb-1 text-gray-400"
          >LAST NAME:</label
        >
        <input
          class="bg-gray-50 rounded-md border border-gray-200 w-full"
          :class="{ 'pointer-events-none': !editOn }"
          type="text"
          v-model="info.last_name"
        />
      </div>
      <div class="flex flex-col w-full">
        <label for="" class="text-xs font-semibold mb-1 text-gray-400">FIRST NAME:</label>
        <input
          class="bg-gray-50 rounded-md border border-gray-200 w-full"
          :class="{ 'pointer-events-none': !editOn }"
          type="text"
          v-model="info.first_name"
        />
      </div>
      <div class="grid w-full">
        <label for="" class="text-xs font-semibold mb-1 text-gray-400">EMAIL:</label>
        <input
          class="bg-gray-50 rounded-md border border-gray-200 w-full"
          :class="{ 'pointer-events-none': !editOn }"
          type="text"
          value="jejomarparrilla@gmail.com"
          v-model="info.email"
        />
      </div>
      <div class="grid w-full">
        <label for="" class="text-xs font-semibold mb-1 text-gray-400">CONTACT:</label>
        <input
          class="bg-gray-50 rounded-md border border-gray-200 w-full"
          :class="{ 'pointer-events-none': !editOn }"
          type="text"
          v-model="info.contact"
        />
      </div>
    </div>
    <div v-if="editOn" class="w-full px-5 text-end">
      <button
        @click="sendData"
        class="text-sm text-white border-2 rounded-md px-3 py-1 bg-green-500"
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
        email: "",
        last_name: "",
        first_name: "",
        contact: "",
      },
      id: -1 /* temporary */,
      editOn: false,
    };
  },
  props: [],
  methods: {
    cancelIt() {
      this.editOn = !this.editOn;
      this.generateData();
    },
    async generateData() {
      const data = await this.$store.dispatch("sendData", {
        url: "api/citizen/personal/myaccount/view/request",
        data: {
          id: this.id, //Temporary
        },
      });
      if (data["response"] == "Success") {
        this.info = await data["data"];
      }
    },
    async sendData() {
      const data = await this.$store.dispatch("sendData", {
        url: "api/citizen/personal/myaccount/update/request",
        data: {
          id: this.id, //Temporary
          data: this.info,
        },
      });
      if (data["response"] == "Success") {
        this.cancelIt();
      } else {
        alert("Error");
      }
    },
  },
  mounted() {
    (async () => {
      await (async () => {
        const credentials = JSON.parse(localStorage.getItem("credentials"));
        this.id = credentials.id;
      })();
      await this.generateData();
    })();
  },
  computed: {
    isPhone() {
      return window.innerWidth <= 768;
    },
  },
};
</script>