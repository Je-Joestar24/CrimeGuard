<template>
  <div class="bg-white rounded-lg shadow p-6">
    <div class="flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-6">
      <div class="relative">
        <img
          v-if="info.profile"
          :src="info.profile"
          class="h-32 w-32 rounded-full object-cover border-4 border-blue-500 shadow-lg"
          alt="Profile Picture"
        />
        <svg
          v-else
          class="h-32 w-32 text-gray-300 bg-gray-100 rounded-full p-2"
          fill="currentColor"
          viewBox="0 0 24 24"
        >
          <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        <label class="absolute bottom-0 right-0 bg-blue-600 rounded-full p-2 cursor-pointer hover:bg-blue-700 transition duration-150">
          <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          <input type="file" class="hidden" @change="onFileChange($event, 'valid_id')" />
        </label>
      </div>
      <div class="flex-1 space-y-2">
        <h2 class="text-2xl font-bold text-gray-900">{{ info.user_name || "NO DATA" }}</h2>
        <p class="text-blue-600 font-medium">{{ info.email || "NO DATA" }}</p>
        <p class="text-gray-600">{{ info.contact || "NO DATA" }}</p>
        <div class="flex items-center space-x-2">
          <span class="font-semibold text-gray-700">Rank:</span>
          <span class="px-3 py-1 bg-red-600 text-white text-sm font-bold rounded-full">{{ info.rank || "NO DATA" }}</span>
        </div>
      </div>
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
        contact: "",
        profile: "",
        rank: "",
      },
      id: -1,
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
        url: "api/officer/basic/myaccount/view/request",
      };

      //console.log(send)
      const data = await this.$store.dispatch("sendData", send);

      if (data.response == "Success") {
        this.info = data.data;
      } else {
        alert();
      }
    },
    onFileChange(event, fileType) {
      this[fileType] = event.target.files[0];
      this.uploadFile(fileType);
    },
    async uploadFile(fileType) {
      const file = this[fileType];
      if (!file) {
        this.responseMessage = `No ${fileType} selected.`;
        return;
      }

      let formData = new FormData();
      formData.append("file", file);

      try {
        const response = await this.$store.dispatch("sendData", {
          url: "api/file/upload",
          data: formData,
        });

        this.responseMessage = response["response"];
        if (this.responseMessage == "Success") {
          this.info.profile = response.file_path;
          await this.$store.dispatch("sendData", {
            url: "api/citizen/personal/myaccount/update/request",
            data: { data:{profile: this.info.profile}, id: this.id },
          });
        }
      } catch (error) {
        console.error(error);
        this.responseMessage = `Upload of ${fileType} failed.`;
      }

      console.log(this.signUpForm);
      alert(this.responseMessage);
    },
  },
};
</script>