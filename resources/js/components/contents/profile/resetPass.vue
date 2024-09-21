<template>
  <div v-if="changePass" class="m-2 p-2 mt-2 border rounded-xl shadow-md bg-gray-100">
    <div class="grid grid-flow-col px-2 pt-1">
      <span class="text-lg font-semibold col-span-5">RESET PASSWORD</span>
      <button @click="changePass = !changePass" class="col-span-2 text-red-500 text-end font-semibold">
        CANCEL
      </button>
    </div>
    <div class="p-2 flex flex-row justify-center items-center gap-3">
      <div class="grid w-full my-2">
        <label for="" class="text-xs font-semibold mb-1"
          >ENTER CURRENT PASSWORD:</label
        >
        <input
          class="bg-gray-200 text-start rounded-md border border-gray-500 w-full"
          type="password"
          v-model="password.currentPass"
        />
      </div>
      <div class="grid w-full my-2">
        <label for="" class="text-xs font-semibold mb-1">NEW PASSWORD:</label>
        <input
          class="bg-gray-200 text-start rounded-md border border-gray-500 w-full"
          type="password"
          v-model="password.newPass"
        />
      </div>
    </div>
    <div class="w-full px-3 text-end">
      <button class="text-sm text-white border-2 rounded-md px-3 bg-green-500" @click="senData">
        SAVE
      </button>
    </div>
  </div>
  <div v-if="!changePass" class="w-full flex justify-center m-4">
    <button type="button" @click="changePass = !changePass" class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 me-2 mb-2">
       CHANGE PASSWORD
    </button>
  </div>
</template>


<script>
export default {
  data() {
    return {
      info: {},
      password: {
        currentPass: "",
        newPass: "",
      },
      id: -1,
      changePass: false
    };
  },
  mounted() {
    const credentials = JSON.parse(localStorage.getItem("credentials"));
    this.id = credentials.id;
  },
  methods: {
    async senData(rID) {
      if((this.password.currentPass == "") || (this.password.newPass == "")){
        alert('Invalid password!');
        return;
      }

      const send = await {
        data: {
          password: this.password,
          id: this.id
        },
        url: "api/officer/updatebasic/myaccount/update/request",
      };

      //console.log(send)
      const data = await this.$store.dispatch("sendData", send);

      if (data.response == "Success") {
        this.info = data.data;
        this.password.currentPass = "";
        this.password.newPass = "";
        this.changePass = !this.changePass;
      } else {
        alert("Error");
      }
    },
  },
};
</script>