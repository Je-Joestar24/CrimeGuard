<template>
  <div v-if="!isPhone" class="mx-4 p-4 mt-5 border rounded-xl shadow-lg bg-gradient-to-br from-gray-100 to-gray-200">
    <div class="flex flex-col items-center">
      <div class="relative mb-6">
        <svg
          v-if="!info.profile"
          class="h-48 w-48 text-gray-400 bg-white rounded-full border-4 border-gray-300"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"
          />
        </svg>
        <img
          v-if="info.profile"
          :src="info.profile"
          class="h-48 w-48 rounded-full object-cover border-4 border-white shadow-lg"
          alt="profile"
        />
        <label
          class="absolute bottom-0 right-0 bg-blue-500 rounded-full p-2 cursor-pointer hover:bg-blue-600 transition duration-300 ease-in-out"
        >
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
          <input type="file" class="hidden" @change="onFileChange($event, 'profile')" />
        </label>
      </div>

      <h2 class="text-2xl font-bold text-gray-800 mb-2">
        {{ info.user_name ? info.user_name : "NO DATA" }}
      </h2>
      <p class="text-gray-600 mb-4">{{ info.email ? info.email : "NO DATA" }}</p>

      <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Username:</label>
          <p class="text-gray-900 font-semibold">{{ info.user_name ? info.user_name : "NO DATA" }}</p>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Email:</label>
          <p class="text-gray-900 font-semibold">{{ info.email ? info.email : "NO DATA" }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Contact:</label>
          <p class="text-gray-900 font-semibold">{{ info.contact ? info.contact : "NO DATA" }}</p>
        </div>
      </div>
    </div>
  </div>
  <div v-if="isPhone" class="bg-white shadow-lg rounded-lg">
    <div class="relative">
      <div class="h-40  bg-gradient-to-r from-blue-500 to-indigo-600 rounded-t-md"></div>
      <div class="absolute inset-0 flex items-center justify-center">
        <div class="relative">
          <svg
            v-if="!info.profile"
            class="h-32 w-32 bg-white rounded-full border-4 border-white shadow-lg text-gray-400"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
          <img
            v-if="info.profile"
            :src="info.profile"
            class="h-32 w-32 rounded-full border-4 border-white shadow-lg object-cover"
            alt="Profile"
          />
          <label
            class="absolute bottom-0 right-0 bg-blue-500 rounded-full p-2 shadow-lg cursor-pointer hover:bg-blue-600 transition-colors duration-300"
          >
            <svg
              class="h-6 w-6 text-white"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"
              />
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"
              />
            </svg>
            <input
              type="file"
              class="hidden"
              @change="onFileChange($event, 'valid_id')"
            />
          </label>
        </div>
      </div>
    </div>

    <div class="px-4 py-5">
      <h2 class="text-2xl font-semibold text-gray-800 text-center">
        {{ info.user_name ? info.user_name : "No Username" }}
      </h2>
      <p class="text-gray-600 text-center mt-1">
        {{ info.email ? info.email : "No Email" }}
      </p>
      <div class="mt-6 border-t border-gray-200 pt-4">
        <div class="flex items-center py-2">
          <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
          </svg>
          <span class="text-gray-700">{{ info.contact ? info.contact : "No Contact" }}</span>
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
        profile: "",
        user_name: "",
        email: "",
        contact: "",
      },
      id: -1,
    };
  },
  props: [],
  methods: {
    async sendData(param) {
      const data = await this.$store.dispatch("sendData", {
        url: "api/citizen/basic/myaccount/view/request",
        data: {
          id: this.id,
        },
      });
      if (data["response"] == "Success") {
        this.info = await data["data"];
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
  mounted() {
    (async () => {
      await (async () => {
        const credentials = JSON.parse(localStorage.getItem("credentials"));
        this.id = credentials.id;
      })();
      await this.sendData();
    })();
  },
  computed: {
    isPhone() {
      return window.innerWidth <= 768;
    },
  },
};
</script>