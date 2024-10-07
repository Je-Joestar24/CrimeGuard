<template>
  <div v-if="!isPhone" class="mx-4 p-4 mt-5 border rounded-xl shadow-lg bg-gradient-to-br from-gray-100 to-gray-200">
    <div class="flex justify-between items-center px-2 pt-1 border-b border-gray-300 pb-3">
      <span class="text-xl font-bold text-gray-800">Account Information</span>
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
      <div class="relative">
        <label for="username" class="text-sm font-semibold text-gray-700 mb-1 block">Username:</label>
        <input
          id="username"
          class="w-full px-4 py-2 bg-white text-gray-800 rounded-md border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-300 ease-in-out"
          :class="{ 'cursor-not-allowed': !editOn }"
          :readonly="!editOn"
          type="text"
          v-model="info.user_name"
        />
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
      <div v-if="editOn" class="pt-2">
        <button
          v-if="!changePass"
          @click="changePass = !changePass"
          class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-md shadow-md transition duration-300 ease-in-out transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50"
        >
          Change Password
        </button>
        <button
          v-if="changePass"
          @click="clearpass"
          class="w-full mt-2 py-2 px-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-md shadow-md transition duration-300 ease-in-out transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
        >
          Cancel Password Change
        </button>
      </div>
      <div v-if="changePass && editOn" class="space-y-3 pt-2">
        <div>
          <label for="currentPass" class="text-sm font-semibold text-gray-700 mb-1 block">Current Password:</label>
          <input
            id="currentPass"
            class="w-full px-4 py-2 bg-white text-gray-800 rounded-md border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-300 ease-in-out"
            type="password"
            v-model="password.currentPass"
          />
        </div>
        <div>
          <label for="newPass" class="text-sm font-semibold text-gray-700 mb-1 block">New Password:</label>
          <input
            id="newPass"
            class="w-full px-4 py-2 bg-white text-gray-800 rounded-md border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-300 ease-in-out"
            type="password"
            v-model="password.newPass"
          />
        </div>
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
  <div v-if="isPhone" class="mx-4 p-2 my-5">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-lg font-semibold text-gray-800">Account Information</h2>
      <button
        v-if="!editOn"
        class="text-blue-600 font-medium"
        @click="editOn = !editOn"
      >
        Edit
      </button>
      <button
        v-if="editOn"
        class="text-gray-600 font-medium"
        @click="cancelIt"
      >
        Cancel
      </button>
    </div>
    <div class="space-y-4">
      <div>
        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
        <input
          id="username"
          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          :class="{ 'bg-gray-100': !editOn }"
          :readonly="!editOn"
          type="text"
          v-model="info.user_name"
        />
      </div>
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input
          id="email"
          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          :class="{ 'bg-gray-100': !editOn }"
          :readonly="!editOn"
          type="email"
          v-model="info.email"
        />
      </div>
      <div v-if="editOn">
        <button
          v-if="!changePass"
          @click="changePass = !changePass"
          class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-blue-600 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
        >
          Change Password
        </button>
        <button
          v-else
          @click="clearpass"
          class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
        >
          Cancel Password Change
        </button>
      </div>
      <div v-if="changePass && editOn" class="space-y-4">
        <div>
          <label for="currentPassword" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
          <input
            id="currentPassword"
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            type="password"
            v-model="password.currentPass"
          />
        </div>
        <div>
          <label for="newPassword" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
          <input
            id="newPassword"
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            type="password"
            v-model="password.newPass"
          />
        </div>
      </div>
    </div>
    <div v-if="editOn" class="mt-6">
      <button
        class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
        @click="sendData"
      >
        Save Changes
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
        user_name: "",
      },
      id: -1 /* temporary */,
      editOn: false,
      changePass: false,
      password: {
        currentPass: "",
        newPass: "",
      },
    };
  },
  props: [],
  methods: {
    cancelIt() {
      this.editOn = !this.editOn;
      this.clearpass();
      this.generateData();
    },
    async generateData() {
      const data = await this.$store.dispatch("sendData", {
        url: "api/citizen/account/myaccount/view/request",
        data: {
          id: this.id, //Temporary
        },
      });
      if (data["response"] == "Success") {
        this.info = await data["data"];
      }
    },
    async sendData() {
      const send = {
        id: this.id, //Temporary
        data: this.info,
      };
      if (this.password.currentPass != "" && this.password.newPass != "") {
        send["password"] = this.password;
      }
      const data = await this.$store.dispatch("sendData", {
        url: "api/citizen/personal/myaccount/update/request",
        data: send,
      });
      if (data["response"] == "Success") {
        this.cancelIt();
      } else {
        alert("Error");
      }
    },
    clearpass() {
      this.password.currentPass = "";
      this.password.newPass = "";
      this.changePass = false;
    },
  },
  mounted() {
    (async () => {
      
      await (async () => {
        const credentials = JSON.parse(localStorage.getItem("credentials"));
        this.id = credentials.id;
        console.log(this.id);
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