<template>
  <div class="flex gap-2 mb-3">

    <div class="relative w-56">
      <svg
        v-if="!info.profile"
        class="h-56 w-56 border-slate-500 rounded-lg border-2 text-gray-900 bg-slate-50 block mx-auto"
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
        class="h-56 w-56 mx-auto border-slate-500 rounded-lg border-2 text-gray-900 bg-slate-50 block"
        alt="profile"
      />
      <div class="absolute bottom-0 w-full flex items-center justify-center">
        <label
          class="cursor-pointer text-xs bg-gray-600 text-white justify-center flex rounded-b-md bg-opacity-50 w-56 rounded-sm hover:bg-blue-700 transition"
          ><svg
            class="h-8 w-8 text-gray-500"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke="currentColor"
            fill="none"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path stroke="none" d="M0 0h24v24H0z" />
            <path
              d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2"
            />
            <circle cx="12" cy="13" r="3" />
          </svg>
          <input
            type="file"
            class="hidden"
            @change="onFileChange($event, 'valid_id')"
          />
        </label>
      </div>
    </div>
    
    <div
      class="p-5 flex flex-col items-start border rounded-xl shadow-md bg-gray-100 w-4/5 h-56"
    >
      <span class="font-bold py-2 px-4 w-64 text-2xl rounded-md">{{
        info.user_name ? info.user_name : "NO DATA"
      }}</span>
      <span
        class="py-1 underline text-blue-800 px-4 w-64 rounded-md border-gray-500 font-semibold"
        >{{ info.email ? info.email : "NO DATA" }}</span
      >
      <span class="py-2 px-4 w-64 rounded-md">{{
        info.contact ? info.contact : "NO DATA"
      }}</span>

      <div class="flex mb-2">
        <label for="" class="py-1 ps-4 pr-2 font-bold font-mono">RANK: </label>
        <span
          class="py-1 px-5 font-bold font-mono text-white text-md border-2 bg-red-600"
          >{{ info.rank ? info.rank : "NO DATA" }}</span
        >
      </div>
      <!-- 
      <div class="flex">
        <label for="" class="py-1 ps-4 pr-2 font-bold font-mono">USER: </label>
        <span
          class="py-1 px-4 font-bold font-mono text-lg border-2 border-red-600"
          >OFFICER</span
        >
      </div> -->
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