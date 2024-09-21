<template>
  <div
    v-if="!isPhone"
    class="mt-6 p-5 py-20 flex flex-col justify-center items-center border rounded-xl shadow-md bg-gray-100"
  >
    <svg
      v-if="!info.profile"
      class="h-64 w-64 border-slate-500 rounded-lg border-2 text-gray-900 bg-slate-50"
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
      class="h-64 w-64 border-slate-500 rounded-lg border-2 text-gray-900 bg-slate-50"
      alt="profile"
    />
    <span
      class="font-bold mt-3 py-2 bg-gray-200 w-60 text-center rounded-md border border-gray-500"
      >{{ info.user_name ? info.user_name : "NO DATA" }}</span
    >
    <span
      class="py-2 m-2 bg-gray-200 w-60 text-center rounded-md border border-gray-500"
      >{{ info.email ? info.email : "NO DATA" }}</span
    >
    <label for="" class="w-60 pt-5">contact:</label>
    <span
      class="py-2 bg-gray-200 w-60 text-center rounded-md border border-gray-500"
      >{{ info.contact ? info.contact : "NO DATA" }}</span
    >
  </div>
  <div v-if="isPhone" class="flex flex-col">
    <div class="py-5 border-b flex flex-col justify-center">
      <svg
        v-if="!info.profile"
        class="h-32 w-32 border-slate-500 rounded-lg border-2 text-gray-900 bg-slate-50 block mx-auto"
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
        class="h-32 w-32 mx-auto border-slate-500 rounded-lg border-2 text-gray-900 bg-slate-50 block"
        alt="profile"
      />
      <div class="w-60 flex flex-col text-xs mx-auto">
        <span
          class="font-bold  text-center text-lg mt-3"
          >{{ info.user_name ? info.user_name : "NO DATA" }}</span
        >
        <span
          class=" text-center text-gray-400"
          >{{ info.email ? info.email : "NO DATA" }}</span
        >
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