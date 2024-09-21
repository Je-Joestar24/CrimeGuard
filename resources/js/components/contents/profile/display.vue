<template>
  <div class="flex gap-2 mb-3">
    <svg
      v-if="!info.profile"
      class="h-56 w-56 border-slate-500 rounded-lg border-2 text-gray-900 bg-slate-50"
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
      class="h-56 w-56 border-slate-500 rounded-lg border-2 text-gray-900 bg-slate-50"
      :src="info.profile"
      alt="ERROR PROFILE"
    />
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
  },
};
</script>