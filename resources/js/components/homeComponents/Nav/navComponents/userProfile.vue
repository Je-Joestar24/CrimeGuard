<template>
  <div class="relative">
    <button
      type="button"
      class="flex items-center space-x-3 focus:outline-none"
      @click="toggle"
    >
      <span class="sr-only">Open user menu</span>
      <div class="relative">
        <svg
          v-if="!info.profile"
          class="h-10 w-10 text-gray-300 bg-gray-100 rounded-full"
          fill="currentColor"
          viewBox="0 0 24 24"
        >
          <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        <img
          v-else
          :src="info.profile"
          alt="User profile"
          class="h-10 w-10 rounded-full object-cover border-2 border-white"
        />
        <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-blue-600 bg-green-400"></span>
      </div>
      <div class="hidden md:block text-left">
        <p class="text-sm font-medium text-white">{{ info.user_name || 'User' }}</p>
        <p class="text-xs text-gray-300">{{ info.email || 'user@email.com' }}</p>
      </div>
      <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
      </svg>
    </button>

    <transition
      enter-active-class="transition ease-out duration-100"
      enter-from-class="transform opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-from-class="transform opacity-100 scale-100"
      leave-to-class="transform opacity-0 scale-95"
    >
      <div
        v-if="!hiddens"
        class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
      >
        <div class="px-4 py-3 border-b border-gray-100">
          <p class="text-sm font-medium text-gray-900">{{ info.user_name || 'User' }}</p>
          <p class="text-sm text-gray-500 truncate">{{ info.email || 'user@email.com' }}</p>
        </div>
        <a
          @click="changeIt"
          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer"
        >
          My Account
        </a>
        <a
          @click="logout(); toggle();"
          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer"
        >
          Log out
        </a>
      </div>
    </transition>
  </div>

  <div
    v-if="logoutToggle"
    class="fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
  >
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
              <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
              <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                Confirm Logout
              </h3>
              <div class="mt-2">
                <p class="text-sm text-gray-500">
                  Are you sure you want to log out? You will be redirected to the login page.
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button
            @click.prevent="
              sendData();
              $store.commit('changeActivePage', [
                'dashboard',
                'DASHBOARD',
                'dashboard',
              ]);
            "
            type="button"
            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"
          >
            Logout
          </button>
          <button
            @click="logout = false"
            type="button"
            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
          >
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      formData: {},
      logoutToggle: false,
      info: {
        profile: "",
        user_name: "",
        email: "",
        contact: "",
      },
      id: -1,
    };
  },
  methods: {
    sendData() {
      const formData = this.formData;
      localStorage.removeItem("credentials");
      this.logout();
      window.location.reload();
      /* 
      this.$emit('reload') */
    },
    async sendData2(param) {
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
    changeIt() {
      this.$emit("changeA", "myAccount");
      this.toggle();
    },
    logout() {
      this.logoutToggle = !this.logoutToggle;
    },
  },
  mounted() {
    (async () => {
      await (async () => {
        const credentials = JSON.parse(localStorage.getItem("credentials"));
        this.id = credentials.id;
      })();
      await this.sendData2();
    })();
  },props:['hiddens', 'toggle']
};
</script>

<style scoped>
.animate-popup {
  animation: popup 0.6s ease-out forwards;
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