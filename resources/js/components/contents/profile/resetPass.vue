<template>
  <div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Password Management</h3>
    <div v-if="changePass">
      <div class="space-y-4">
        <div>
          <label for="currentPass" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
          <input
            id="currentPass"
            v-model="password.currentPass"
            type="password"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>
        <div>
          <label for="newPass" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
          <input
            id="newPass"
            v-model="password.newPass"
            type="password"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>
      </div>
      <div class="mt-4 flex justify-end space-x-3">
        <button @click="changePass = false" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition duration-150">
          Cancel
        </button>
        <button @click="senData" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-150">
          Save Changes
        </button>
      </div>
    </div>
    <div v-else class="text-center">
      <button @click="changePass = true" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-150">
        Change Password
      </button>
    </div>
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