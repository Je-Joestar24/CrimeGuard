<template>
  <div v-if="!isPhone" class="mx-4 p-4 mt-5 border rounded-xl shadow-lg bg-gradient-to-br from-gray-100 to-gray-200">
    <div class="flex justify-between items-center px-2 pt-1 border-b border-gray-300 pb-3">
      <span class="text-xl font-bold text-gray-800">Personal Information</span>
      <button
        v-if="!editOn"
        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
        @click="editOn = !editOn"
      >
        Edit Profile
      </button>
      <button
        v-if="editOn"
        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50"
        @click="cancelIt"
      >
        Cancel
      </button>
    </div>
    <div class="p-5 space-y-4">
      <div class="grid grid-cols-2 gap-4">
        <div class="relative">
          <label for="lastName" class="text-sm font-semibold text-gray-700 mb-1 block">Last Name:</label>
          <input
            id="lastName"
            class="w-full px-4 py-2 bg-white text-gray-800 rounded-md border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-300 ease-in-out"
            :class="{ 'cursor-not-allowed': !editOn }"
            :readonly="!editOn"
            type="text"
            v-model="info.last_name"
          />
        </div>
        <div class="relative">
          <label for="firstName" class="text-sm font-semibold text-gray-700 mb-1 block">First Name:</label>
          <input
            id="firstName"
            class="w-full px-4 py-2 bg-white text-gray-800 rounded-md border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-300 ease-in-out"
            :class="{ 'cursor-not-allowed': !editOn }"
            :readonly="!editOn"
            type="text"
            v-model="info.first_name"
          />
        </div>
      </div>
      <div class="relative">
        <label for="email" class="text-sm font-semibold text-gray-700 mb-1 block">Email:</label>
        <input
          id="email"
          class="w-full px-4 py-2 bg-white text-gray-800 rounded-md border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-300 ease-in-out"
          :class="{ 'cursor-not-allowed': !editOn }"
          :readonly="!editOn"
          type="email"
          v-model="info.email"
        />
      </div>
      <div class="relative">
        <label for="contact" class="text-sm font-semibold text-gray-700 mb-1 block">Contact:</label>
        <input
          id="contact"
          class="w-full px-4 py-2 bg-white text-gray-800 rounded-md border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-300 ease-in-out"
          :class="{ 'cursor-not-allowed': !editOn }"
          :readonly="!editOn"
          type="text"
          v-model="info.contact"
        />
      </div>
    </div>
    <div v-if="editOn" class="mt-6 text-right">
      <button
        class="px-6 py-2 bg-green-600 text-white font-bold rounded-md shadow-md hover:bg-green-700 transition duration-300 ease-in-out transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
        @click="sendData"
      >
        Save Changes
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