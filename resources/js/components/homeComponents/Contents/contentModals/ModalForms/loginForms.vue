<template>
  <div
    class="fixed z-50 bg-white top-0 flex animate-popup"
    style="
      height: 100vh;
      background-image: url('/storage/system/bg.jpg');
      width: 100vw;
    "
  >
    <div v-if="!isPhone" class="flex w-full flex-col bg-blue-300">
      <img class="p-20" :src="'/storage/system/logo.png'" alt="logo" />
    </div>
    <div class="w-full border-l">
      <div class="w-full flex justify-end p-2">
        <svg
          class="w-10 h-10 p-2 text-blue-300 rounded-xl cursor-pointer hover:bg-opacity-50 hover:bg-blue-500 hover:text-white"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 14 14"
          @click.prevent="changeA()"
        >
          <path
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
          />
        </svg>
      </div>
      <h1 class="w-full flex justify-center">
        <span
          class="px-40 font-bold md:py-4 lg:py-4 xl:py-4 2xl:py-4 py-1 rounded text-xl bg-white"
          >LOGIN</span
        >
      </h1>
      <span class="flex justify-center pb-2">
        <span class="border px-4 py-0">CRIME GUARD</span></span
      >
      <div class="flex justify-center pb-6 border-b-2">
        <div class="p-4 pb-6 border-2 bg-white rounded-b-full">
          <img class="w-20 h-20" :src="'/storage/system/bg.png'" alt="logo" />
        </div>
      </div>
      <form class="max-w-sm mx-auto mt-5 md:mt-20 lg:mt-20 xl:mt-20 2xl:mt-20">
        <p
          class="border-yellow-400 bg-yellow-100 border rounded-md p-2 flex items-center text-red-700 text-sm font-light"
          v-if="!verified"
        >
          <svg
            class="flex-shrink-0 inline w-4 h-4 me-2"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            viewBox="0 0 20 20"
          >
            <path
              d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"
            />
          </svg>
          No match found!
        </p>
        <div :class="{ ' mb-2 ': isPhone, 'mb-5': !isPhone }">
          <label
            for="email"
            class="blocktext-sm font-medium text-gray-900"
            :class="{ ' mb-1 ': isPhone, 'mb-2': !isPhone }"
            >USERNAME</label
          >
          <input
            type="email"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            placeholder="USERNAME"
            v-model="loginform.user"
            required
          />
        </div>
        <div :class="{ ' mb-2 ': isPhone, 'mb-5': !isPhone }">
          <label
            for="password"
            class="block text-sm font-medium text-gray-900"
            :class="{ ' mb-1 ': isPhone, 'mb-2': !isPhone }"
            >PASSWORD</label
          >
          <input
            type="password"
            v-model="loginform.password"
            placeholder="PASSWORD"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            required
          />
        </div>
        <div class="flex items-start" :class="{ ' mb-2 ': isPhone, 'mb-5': !isPhone }"></div>
        <button
          type="button"
          class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center"
          @click="SendData()"
        >
          Login
        </button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loginform: {
        user: "",
        password: "",
      },
      requestType: "LOGIN",
      verified: true,
    };
  },
  props: ["changeActive"],
  methods: {
    async SendData() {
      const dt = await this.$store.dispatch("sendData", {
        url: "api/temporary/login/user/request",
        data: this.loginform,
      });

      if (dt.response == "Success") {
        localStorage.setItem("credentials", JSON.stringify(dt.data));
        this.$router.push("/ADMIN/Dashboard");
      } else this.verified = false;
      /* 
      else if (this.$store.getters.verificationResult) this.$router.push("/"); */
    },
    changeA() {
      this.changeActive("Home");
    },
  },
  computed: {
    isPhone() {
      return window.innerWidth <= 768;
    },
  },
};
</script>


<style scoped>
.animate-popup {
  animation: popup 0.1s ease-out forwards;
}

@keyframes popup {
  0% {
    transform: scale(0.5);
    opacity: 0;
  }
  100% {
    transform: scale(1);
    opacity: 1;
  }
}
</style>