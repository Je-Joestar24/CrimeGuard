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
    <div v-if="!isPhone" class="w-full border-l  shadow-lg">
      <div class="w-full flex justify-end p-4 mt-10">
        <button @click.prevent="changeA()" class="text-gray-600 hover:text-gray-800 transition-colors duration-300">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      
      <div class="max-w-md mx-auto px-6 py-8">
        <div class="text-center mb-8">
          <img class="w-24 h-24 mx-auto mb-4" :src="'/storage/system/bg.png'" alt="Crime Guard Logo" />
          <h1 class="text-3xl font-bold text-gray-800">Login to Crime Guard</h1>
          <p class="text-gray-600 mt-2">Enter your credentials to access your account</p>
        </div>

        <form @submit.prevent="SendData" class="space-y-6">
          <div v-if="!verified" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p class="font-bold">Login Failed</p>
            <p>Invalid username or password. Please try again.</p>
          </div>

          <div>
            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
            <input
              type="text"
              v-model="loginform.user"
              class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              required
              placeholder="Enter your username"
            />
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input
              type="password"
              v-model="loginform.password"
              class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              required
              placeholder="Enter your password"
            />
          </div>

          <div>
            <button
              type="submit"
              class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              Sign In
            </button>
          </div>
        </form>
<!-- 
        <div class="mt-6 text-center">
          <a href="#" class="text-sm text-blue-600 hover:text-blue-500">Forgot your password?</a>
        </div> -->
      </div>
    </div>

    <div v-if="isPhone" class="w-full h-full bg-white flex flex-col justify-between">
      <div class="w-full flex justify-end p-4">
        <button @click.prevent="changeA()" class="text-gray-600 hover:text-gray-800 transition-colors duration-300">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      
      <div class="flex-grow flex flex-col justify-center px-6 py-8">
        <div class="text-center mb-8">
          <img class="w-24 h-24 mx-auto mb-4" :src="'/storage/system/bg.png'" alt="Crime Guard Logo" />
          <h1 class="text-2xl font-bold text-gray-800">Login to Crime Guard</h1>
          <p class="text-sm text-gray-600 mt-2">Enter your credentials to access your account</p>
        </div>

        <form @submit.prevent="SendData" class="space-y-4">
          <div v-if="!verified" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 text-sm" role="alert">
            <p class="font-bold">Login Failed</p>
            <p>Invalid username or password. Please try again.</p>
          </div>

          <div>
            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
            <input
              type="text"
              v-model="loginform.user"
              class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
              required
              placeholder="Enter your username"
            />
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input
              type="password"
              v-model="loginform.password"
              class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
              required
              placeholder="Enter your password"
            />
          </div>

          <div>
            <button
              type="submit"
              class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              Sign In
            </button>
          </div>
        </form>
      </div>

      <div class="mt-6 text-center pb-8">
        <p class="text-sm text-gray-600">Don't have an account?</p>
        <a @click="goToSignup" class="text-sm text-blue-600 hover:text-blue-500 font-medium cursor-pointer">Sign up here</a>
      </div>
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