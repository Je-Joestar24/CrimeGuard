<template>
  <div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-lg font-semibold text-gray-900">Account Information</h3>
      <button
        @click="edit = !edit"
        class="px-4 py-2 text-sm font-medium rounded-md"
        :class="edit ? 'bg-red-100 text-red-600 hover:bg-red-200' : 'bg-blue-100 text-blue-600 hover:bg-blue-200'"
      >
        {{ edit ? 'Cancel' : 'Edit' }}
      </button>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
        <input
          id="username"
          v-model="info.user_name"
          :disabled="!edit"
          class="w-full px-3 py-2 border rounded-md"
          :class="{'bg-gray-100': !edit, 'border-gray-300': edit, 'border-gray-200': !edit}"
        />
      </div>
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input
          id="email"
          v-model="info.email"
          :disabled="!edit"
          class="w-full px-3 py-2 border rounded-md"
          :class="{'bg-gray-100': !edit, 'border-gray-300': edit, 'border-gray-200': !edit}"
        />
      </div>
    </div>
    <div v-if="edit" class="mt-4 text-right">
      <button @click="senData" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-150">
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