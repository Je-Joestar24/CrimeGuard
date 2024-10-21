<template>
    <div
    v-if="!checked"
    class="w-full h-screen flex items-center justify-center bg-gradient-to-r from-blue-50 to-white relative bg-transparent bg-opacity-50"
  >
    <!-- Floating CrimeGuard Logo and App Title -->
    <div class="absolute top-0 w-full py-6">
      <div class="flex justify-center items-center flex-col">
        <img class="w-24 h-24" :src="'/storage/system/bg.png'" alt="CrimeGuard Logo" />
        <h1 class="text-4xl font-extrabold text-gray-800 mt-4">CrimeGuard</h1>
      </div>
    </div>
  
    <!-- Form Container -->
    <div
      class="max-w-lg w-full mx-auto px-8 py-12 bg-white shadow-2xl rounded-2xl border border-gray-200 transform transition-all duration-500 ease-in-out hover:shadow-3xl hover:scale-105"
    >
      <!-- Heading Section -->
      <div class="text-center mb-12">
        <h2 class="text-3xl font-semibold text-gray-900">Verify Your Identity</h2>
        <p class="text-gray-500 mt-3">
          Enter your email to receive a 6-character verification code
        </p>
      </div>
  
      <!-- Form -->
      <form @submit.prevent="SendData" class="space-y-8">
        <!-- Error Message -->
        <div
          v-if="!verified"
          class="bg-red-50 border border-red-300 text-red-600 p-4 rounded-lg mb-6"
          role="alert"
        >
          <p class="font-semibold">Verification Failed</p>
          <p>Invalid email. Please try again.</p>
        </div>
  
        <!-- Email Input Field -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
          <input
            type="email"
            v-model="forgotForm.email"
            class="block w-full px-5 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 sm:text-base"
            required
            placeholder="Enter your email"
          />
        </div>
  
        <!-- Submit Button -->
        <div>
          <button
            type="submit"
            class="w-full py-3 bg-blue-600 text-white rounded-lg font-semibold shadow-lg transition duration-300 ease-in-out transform hover:bg-blue-700 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
          >
            Send Verification Code
          </button>
        </div>
      </form>
  
      <!-- Back Button -->
      <div class="mt-8 text-center">
        <router-link
        to="/"
          class="text-blue-500 hover:text-blue-700 font-medium transition duration-200"
        >
          ← Back to Home
        </router-link>
      </div>
    </div>
  </div>
  <reset-pass :mail="forgotForm.email" v-else/>
  

  <!--     <div v-if="isPhone" class="w-full h-full bg-white flex flex-col justify-between">
      <div class="w-full flex justify-end pt-4 pr-4">
        <button @click.prevent="changeA()" class="text-gray-600 hover:text-gray-800 transition-colors duration-300">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      <div class="flex-grow flex flex-col justify-center px-6 pb-8">
        <div class="text-center mb-8">
          <img class="w-24 h-24 mx-auto mb-4" :src="'/storage/system/bg.png'" alt="Crime Guard Logo" />
          <h1 class="text-2xl font-bold text-gray-800">Forgot Password</h1>
          <p class="text-sm text-gray-600 mt-2">Enter your email to reset your password</p>
        </div>
        <form @submit.prevent="SendData" class="space-y-4">
          <div v-if="!verified" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 text-sm" role="alert">
            <p class="font-bold">Reset Failed</p>
            <p>Invalid email or password. Please try again.</p>
          </div>
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input
              type="email"
              v-model="forgotForm.email"
              class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
              required
              placeholder="Enter your email"
            />
          </div>
          <div>
            <button
              type="submit"
              class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              Reset Password
            </button>
          </div>
        </form>
      </div>
    </div> -->
</template>

<script>
import resetPass from './resetPass.vue';

export default {
  data() {
    return {
      forgotForm: {
        email: "",
      },
      verified: true,
      checked: false
    };
  },
  components: {
    resetPass
  },
  created() {
    document.body.style.overflow = "hidden";
  },methods: {
    async SendData(){
      const send = {
        url: "api/create/reset/token",
        data: this.forgotForm,
      };

      const test = await this.$store.dispatch("sendData", send);
      if (test["response"] ) {
        this.checked = true;

      } else {
        alert("Error");
        this.verified = false
      }
    }
  }
};
</script>

<style>
</style>