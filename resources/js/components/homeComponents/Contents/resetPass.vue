<template>
    <div
    v-if="!isPhone"
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
        <h2 class="text-3xl font-semibold text-gray-900">Reset Your Password</h2>
        <p class="text-gray-500 mt-3">
          Enter your new password
        </p>
      </div>
  
      <!-- Form -->
      <form v-if="verified" @submit.prevent="ResetPassword" class="space-y-8">
        <!-- Error Message -->
        <div
          v-if="!passMatch"
          class="bg-red-50 border border-red-300 text-red-600 p-4 rounded-lg mb-6"
          role="alert"
        >
          <p class="font-semibold">Password Reset Failed</p>
          <p>Invalid password. Please try again.</p>
        </div>
  
        <!-- Password Input Field -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
          <input
            type="password"
            v-model="resetForm.password"
            class="block w-full px-5 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 sm:text-base"
            required
            placeholder="Enter your new password"
          />
        </div>
  
        <!-- Confirm Password Input Field -->
        <div>
          <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
          <input
            type="password"
            v-model="resetForm.confirmPassword"
            class="block w-full px-5 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 sm:text-base"
            required
            placeholder="Confirm your new password"
          />
        </div>
  
        <!-- Submit Button -->
        <div>
          <button
            type="submit"
            class="w-full py-3 bg-blue-600 text-white rounded-lg font-semibold shadow-lg transition duration-300 ease-in-out transform hover:bg-blue-700 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
          >
            Reset Password
          </button>
        </div>
      </form>
      <form v-else @submit.prevent="verifyToken" class="space-y-8">
        <!-- Error Message -->
        <div
          v-if="!verifiedT"
          class="bg-red-50 border border-red-300 text-red-600 p-4 rounded-lg mb-6"
          role="alert"
        >
          <p class="font-semibold">Verification Failed</p>
          <p>Invalid token. Please try again.</p>
        </div>
      
        <!-- Token Input Field -->
        <div>
          <label for="token" class="block text-sm font-medium text-gray-700 mb-2">Verification Code</label>
          <input
            type="text"
            v-model="tokenForm.code"
            class="block w-full px-5 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 sm:text-base"
            required
            placeholder="Enter the 6-digit code sent to your email"
          />
        </div>
      
      
        <!-- Submit Button -->
        <div>
          <button
            type="submit"
            class="w-full py-3 bg-blue-600 text-white rounded-lg font-semibold shadow-lg transition duration-300 ease-in-out transform hover:bg-blue-700 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
          >
            Verify Code
          </button>
        </div>
      </form>
      
      <!-- Back Button -->
      <div class="mt-8 text-center">
        <router-link to="/"
          class="text-blue-500 hover:text-blue-700 font-medium transition duration-200"
        >
          ← Back to Home
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      resetForm: {
        email: this.mail,
        password: "",
        confirmPassword: "",
        code:""
      },
      tokenForm: {
        code:"",
        email:this.mail
      },
      verified: false,
      verifiedT: true,
      passMatch: true
    };
  },
  created() {
    document.body.style.overflow = "hidden";
  },
  methods: {
    async ResetPassword() {
        if(this.resetForm.password != this.resetForm.confirmPassword){
            this.passMatch = false
            return;
        }
        const send = {
        url: "api/my/password/reset",
        data: this.resetForm,
      };

      const test = await this.$store.dispatch("sendData", send);
      if (test["response"] ) {
        this.passMatch = true;
        setTimeout(()=> {
            this.$router.push("/");
        }, 100);
      } else {
        alert("Error");
      }
    },
    async verifyToken(){
        const send = {
        url: "api/validate/reset/token",
        data: this.tokenForm,
      };

      const test = await this.$store.dispatch("sendData", send);
      if (test["reset"] ) {
        this.verified = true;
        this.resetForm.code = this.tokenForm.code;
      } else {
        alert("Error");
        this.verified = false;
        this.verifiedT = false;
      }
    }
  },
  props: ['mail']
};
</script>

<style>
</style>