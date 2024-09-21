<template>
  <div v-if="!isPhone" class="mx-4 p-2 mt-5 border rounded-xl shadow-md bg-gray-100">
    <div class="grid grid-flow-col px-2 pt-1">
      <span class="text-lg font-semibold col-span-5">ACCOUNT INFORMATION</span>
      <button
        v-if="!editOn"
        class="col-span-2 text-blue-500 text-center font-semibold"
        @click="editOn = !editOn"
      >
        EDIT
      </button>
      <button
        v-if="editOn"
        class="col-span-2 text-blue-500 text-center font-semibold"
        @click="cancelIt"
      >
        CANCEL
      </button>
    </div>
    <div class="p-5 flex flex-col justify-center items-center">
      <div class="grid w-full mt-2">
        <label for="" class="text-xs font-semibold mb-1">USERNAME:</label>
        <input
          class="bg-gray-200 text-start rounded-md border border-gray-500 w-full"
          :class="{ 'pointer-events-none': !editOn }"
          type="text"
          v-model="info.user_name"
        />
      </div>
      <div class="grid w-full mt-2">
        <label for="" class="text-xs font-semibold mb-1">EMAIL:</label>
        <input
          class="bg-gray-200 text-start rounded-md border border-gray-500 w-full"
          :class="{ 'pointer-events-none': !editOn }"
          type="text"
          v-model="info.email"
        />
      </div>
      <button
        v-if="!changePass && editOn"
        @click="changePass = !changePass"
        class="w-full mt-2 text-blue-600 font-semibold p-2"
      >
        CHANGE PASSWORD
      </button>
      <button
        v-if="changePass && editOn"
        @click="clearpass"
        class="w-full text-red-600 font-semibold p-1"
      >
        CANCEL
      </button>
      <!-- password -->
      <div v-if="changePass && editOn" class="flex flex-col w-full mt-2">
        <div class="grid w-full mt-1">
          <label for="" class="text-xs font-semibold mb-1"
            >CURRENT PASSWORD:</label
          >
          <input
            class="bg-gray-200 text-start rounded-md border border-blue-200 w-full"
            type="password"
            v-model="password.currentPass"
          />
        </div>
        <div class="grid w-full mt-1">
          <label for="" class="text-xs font-semibold mb-1">NEW PASSWORD:</label>
          <input
            class="bg-gray-200 text-start rounded-md border border-blue-200 w-full"
            type="password"
            v-model="password.newPass"
          />
        </div>
      </div>
    </div>
    <div v-if="editOn" class="w-full px-5 text-end">
      <button
        class="text-sm text-white border-2 rounded-md px-3 py-1 bg-green-500"
        @click="sendData"
      >
        SAVE
      </button>
    </div>
  </div>
  
  <div v-if="isPhone" class="mx-4 p-2 my-5">
    <div class="grid grid-flow-col px-2 pt-1">
      <span class="text-lg font-semibold col-span-5 text-gray-600">ACCOUNT INFORMATION</span>
      <button
        v-if="!editOn"
        class="col-span-2 text-blue-500 text-center font-semibold"
        @click="editOn = !editOn"
      >
        EDIT
      </button>
      <button
        v-if="editOn"
        class="col-span-2 text-blue-500 text-center font-semibold"
        @click="cancelIt"
      >
        CANCEL
      </button>
    </div>
    <div class="p-5 flex flex-col justify-center items-center text-gray-700">
      <div class="grid w-full mt-2">
        <label for="" class="text-xs font-semibold mb-1 text-gray-400">USERNAME:</label>
        <input
          class="bg-gray-50 rounded-md border border-gray-200 w-full"
          :class="{ 'pointer-events-none': !editOn }"
          type="text"
          v-model="info.user_name"
        />
      </div>
      <div class="grid w-full mt-2">
        <label for="" class="text-xs font-semibold mb-1 text-gray-400">EMAIL:</label>
        <input
          class="bg-gray-50 rounded-md border border-gray-200 w-full"
          :class="{ 'pointer-events-none': !editOn }"
          type="text"
          v-model="info.email"
        />
      </div>
      <button
        v-if="!changePass && editOn"
        @click="changePass = !changePass"
        class="w-full mt-2 text-blue-600 font-semibold p-2"
      >
        CHANGE PASSWORD
      </button>
      <button
        v-if="changePass && editOn"
        @click="clearpass"
        class="w-full text-red-600 font-semibold p-1"
      >
        CANCEL
      </button>
      <!-- password -->
      <div v-if="changePass && editOn" class="flex flex-col w-full mt-2">
        <div class="grid w-full mt-1">
          <label for="" class="text-xs font-semibold mb-1 text-gray-400"
            >CURRENT PASSWORD:</label
          >
          <input
            class="bg-gray-50 rounded-md border border-gray-200 w-full"
            type="password"
            v-model="password.currentPass"
          />
        </div>
        <div class="grid w-full mt-1">
          <label for="" class="text-xs font-semibold mb-1 text-gray-400">NEW PASSWORD:</label>
          <input
            class="bg-gray-50 rounded-md border border-gray-200 w-full"
            type="password"
            v-model="password.newPass"
          />
        </div>
      </div>
    </div>
    <div v-if="editOn" class="w-full px-5 text-end">
      <button
        class="text-sm text-white border-2 rounded-md px-3 py-1 bg-green-500"
        @click="sendData"
      >
        SAVE
      </button>
    </div>

    <div class="py-10"></div>
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